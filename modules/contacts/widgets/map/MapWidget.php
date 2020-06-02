<?php

namespace app\modules\contacts\widgets\map;


use panix\lib\google\maps\Event;
use panix\lib\google\maps\EventType;
use panix\lib\google\maps\overlays\Animation;
use panix\lib\google\maps\overlays\Polygon;
use panix\lib\google\maps\overlays\PolylineOptions;
use panix\lib\google\maps\services\DirectionsRenderer;
use panix\lib\google\maps\services\DirectionsRequest;
use panix\lib\google\maps\services\DirectionsService;
use panix\lib\google\maps\services\DirectionsWayPoint;
use panix\lib\google\maps\services\TravelMode;
use Yii;
use panix\lib\google\maps\LatLng;
use panix\lib\google\maps\overlays\InfoWindow;
use panix\lib\google\maps\overlays\Marker;
use panix\lib\google\maps\Map;
use panix\lib\google\maps\MapAsset;
use app\modules\contacts\models\Maps;
use panix\engine\data\Widget;
use yii\helpers\ArrayHelper;
use panix\lib\google\maps\controls\ControlPosition;
use panix\lib\google\maps\controls\MapTypeControlStyle;
use panix\lib\google\maps\layers\BicyclingLayer;
use panix\lib\google\maps\layers\TrafficLayer;
use panix\lib\google\maps\layers\TransitLayer;
use app\modules\contacts\models\Markers;
use yii\web\JsExpression;

/**
 * Description of Map
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 */
class MapWidget extends Widget
{

    /**
     * @var Map
     */
    private $map;
    public $map_id;
    public $options = [];
    private $model;
    public static $autoIdPrefix = '';

    public function init()
    {
        parent::init();
        $view = Yii::$app->getView();

        $this->model = Maps::findOne($this->map_id);


        if ($this->model) {

            Yii::$app->assetManager->bundles['panix\lib\google\maps\MapAsset'] = [
                'options' => [
                    'key' => $this->model->api_key,
                    'libraries' => 'geometry,places,drawing,visualization'
                ]
            ];
            MapAsset::register($view);

            $opt = [];


            $opt['center'] = new LatLng($this->model->getCenter());
            $opt['zoom'] = $this->model->zoom;
            $opt['width'] = $this->model->width;
            $opt['mapTypeId'] = $this->model->type;
            $opt['scrollwheel'] = boolval($this->model->scrollwheel);


            $opt['fullscreenControl'] = boolval($this->model->fullscreenControl);
            $opt['zoomControl'] = boolval($this->model->zoomControl);
            $opt['scaleControl'] = boolval($this->model->scaleControl);
            $opt['mapTypeControl'] = boolval($this->model->mapTypeControl);
            $opt['streetViewControl'] = boolval($this->model->streetViewControl);
            $opt['rotateControl'] = boolval($this->model->rotateControl);
            $opt['mapTypeControlOptions'] = [
                'style' => MapTypeControlStyle::HORIZONTAL_BAR,
                'position' => ControlPosition::TOP_CENTER
            ];
            $opt['disableDefaultUI'] = true;

            //$opt['StreetViewControlOptions'] = [
            //    'position' => ControlPosition::TOP_CENTER
            //];

            $mapOptions = ArrayHelper::merge($opt, $this->options);

            $this->map = new Map($mapOptions);


            if ($this->model->trafficLayer) {
                $trafficLayer = new TrafficLayer(['map' => $this->map->getName()]);
                $this->map->appendScript($trafficLayer->getJs());
            }
            if ($this->model->transitLayer) {
                $transitLayer = new TransitLayer(['map' => $this->map->getName()]);
                $this->map->appendScript($transitLayer->getJs());
            }
            if ($this->model->bikeLayer) {
                $bikeLayer = new BicyclingLayer(['map' => $this->map->getName()]);
                $this->map->appendScript($bikeLayer->getJs());
            }

            // lets use the directions renderer
            $corner = new LatLng(['lat' => 46.4709167635098, 'lng' => 30.744864122187664]);
            $train = new LatLng(['lat' => 46.46720189828257, 'lng' => 30.741441249847412]);
            $myhome = new LatLng(['lat' => 46.400986935183376, 'lng' => 30.71399688720703]);

            // setup just one waypoint (Google allows a max of 8)
            $waypoints = [
                new DirectionsWayPoint(['location' => $myhome]),
                new DirectionsWayPoint(['location' => new LatLng(['lat' => 46.430496096695265, 'lng' => 30.761869684965177])])
            ];
            $polylineOptions = new PolylineOptions([
                'strokeColor' => '#FF0000',
                'draggable' => true
            ]);
            $directionsRequest = new DirectionsRequest([
                'origin' => $corner,
                'destination' => $train,
                'waypoints' => $waypoints,
                'travelMode' => TravelMode::DRIVING
            ]);
            // Now the renderer
            $directionsRenderer = new DirectionsRenderer([
                'map' => $this->map->getName(),
                'polylineOptions' => $polylineOptions
            ]);

            // Finally the directions service
            $directionsService = new DirectionsService([
                'directionsRenderer' => $directionsRenderer,
                'directionsRequest' => $directionsRequest
            ]);
            //$this->map->appendScript($directionsService->getJs());
            /*$coords = [
                new LatLng(['lat' => 25.774252, 'lng' => -80.190262]),
                new LatLng(['lat' => 18.466465, 'lng' => -66.118292]),
                new LatLng(['lat' => 32.321384, 'lng' => -64.75737]),
                new LatLng(['lat' => 25.774252, 'lng' => -80.190262])
            ];
            $polygon = new Polygon([
                'paths' => $coords
            ]);
            $polygon->attachInfoWindow(new InfoWindow([
                'content' => '<p>This is my super cool Polygon</p>'
            ]));
            $this->map->addOverlay($polygon);*/


            $this->map->appendScript("
            var mymap = {$this->map->getName()};
            


            var latLng;
            mymap.addListener('click', function(e) {
                latLng = e.latLng;
                console.log('map click',latLng.lat(),latLng.lng());
                var controlUI = document.createElement('div');

                if(!document.getElementById('map-control-btn')){
                    controlUI.title = 'test';
                    controlUI.id = 'map-control-btn';
                    controlUI.innerHTML = 'test';
                    controlUI.style.margin = '10px';
                    controlUI.style.cursor = 'pointer';
                    //controlUI.style.backgroundColor = '#fff';
                    controlUI.className = 'btn btn-outline-secondary controlUI';
                   // controlDiv.appendChild(controlUI);
                
                    mymap.controls[google.maps.ControlPosition.TOP_LEFT].push(controlUI);
                    controlUI.addEventListener('click', function() {
                    
                    $('#maps-center').val(latLng.lat()+','+latLng.lng());
                        //map.setCenter(chicago);
                         console.log('Button click',latLng.lat(),latLng.lng());
                    });
                }
            });
            ");
            $this->initMarkers();

        } else {
            $this->map = false;
        }
    }

    public function run()
    {
        if ($this->map) {
            echo $this->map->display();
        }
    }


    private function initMarkers()
    {
        if ($this->model->boundMarkers)
            $this->map->appendScript('var bounds = new google.maps.LatLngBounds();');

        foreach ($this->model->markers as $marker) {
            /** @var Markers $marker */
            $position = new LatLng($marker->getCoords());

            $eventDrag = new Event([
                'trigger' => 'dragend',
                'js' => '

                    console.log(event.latLng.lat(),event.latLng.lng());
                ']);

            $markers = new Marker([
                'position' => $position,
                'title' => $marker->name,
                'opacity' => $marker->opacity,
                'draggable' => boolval($marker->draggable),
                'crossOnDrag' => boolval(1),
               // 'animation' => Animation::BOUNCE,
                'events' => [$eventDrag]
            ]);

            /*$this->map->appendScript("
                var mark = {$markers->getName()};
            google.maps.event.addListener(mark, 'dragend', function()
            {
                console.log(mark.getPosition().lat(),mark.getPosition().lng());
            });
            ");*/


            if ($marker->content_body) {
                $markers->attachInfoWindow(
                    new InfoWindow([
                        'content' => $marker->content_body
                    ])
                );
            }

            $this->map->addOverlay($markers);
            if ($this->model->boundMarkers)
                $this->map->appendScript('bounds.extend(' . $position->getJs() . ');');
        }
        if ($this->model->markersCount > 1 && $this->model->boundMarkers)
            $this->map->appendScript($this->map->getName() . ".fitBounds(bounds);");
    }

}
