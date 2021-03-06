<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\modules\telegram\commands\UserCommands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use app\modules\telegram\components\UserCommand;

/**
 * User "/weather" command
 */
class WeatherCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'weather';
    protected $description = 'Show weather by location';
    protected $usage = '/weather <location>';
    protected $version = '1.1.0';
    public $enabled = true;
    public $show_in_help=false;
    public $private_only=true;
    /**#@-*/

    /**
     * Base URI for OpenWeatherMap API
     *
     * @var string
     */
    private $owm_api_base_uri = 'http://api.openweathermap.org/data/2.5/';

    /**
     * Get weather data using HTTP request
     *
     * @param string $location
     *
     * @return string
     */
    private function getWeatherData($location)
    {
        $client = new Client(['base_uri' => $this->owm_api_base_uri]);
        $path = 'weather';
        $query = [
            'q'     => $location,
            'units' => 'metric',
            'APPID' => trim($this->getConfig('owm_api_key')),
        ];

        try {
            $response = $client->get($path, ['query' => $query]);
        } catch (RequestException $e) {
            throw new TelegramException($e->getMessage());
        }

        return (string)$response->getBody();
    }

    /**
     * Get weather string from weather data
     *
     * @param array $data
     *
     * @return bool|string
     */
    private function getWeatherString(array $data)
    {
        try {
            if (empty($data) || $data['cod'] !== 200) {
                return false;
            }

            //http://openweathermap.org/weather-conditions
            $conditions = [
                'clear'        => ' ☀ ',
                'clouds'       => ' ☁ ',
                'rain'         => ' ☔ ',
                'drizzle'      => ' ☔ ',
                'thunderstorm' => ' ⚡ ',
                'snow'         => ' ❄ ',
            ];
            $conditions_now = strtolower($data['weather'][0]['main']);


            $text = 'Температура в '.$data['name'].' ('.$data['sys']['country'].') '.round($data['main']['temp']).'°C'.PHP_EOL;
            $text .= 'Текущие условия: '.$data['weather'][0]['description'].' '.((isset($conditions[$conditions_now])) ? $conditions[$conditions_now] : '');

            return $text;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();
        $text = '';

        if (trim($this->getConfig('owm_api_key'))) {
            if ($location = trim($message->getText(true))) {
                if ($weather_data = json_decode($this->getWeatherData($location), true)) {
                    $text = $this->getWeatherString($weather_data);
                }
                if (!$text) {
                    $text = 'Не могу найти погоду для местоположения: ' . $location;
                }
            } else {
                $text = 'Вы должны указать местоположение в формате: /weather <city>';
            }
        } else {
            $text = 'OpenWeatherMap API key не определено.';
        }

        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

        return Request::sendMessage($data);
    }
}
