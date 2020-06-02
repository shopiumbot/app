<?php

namespace api\rest;

use yii\rest\Serializer as BaseSerializer;

class Serializer extends BaseSerializer
{
    protected function serializeDataProvider($dataProvider)
    {
        if ($this->preserveKeys) {
            $models = $dataProvider->getModels();
        } else {
            $models = array_values($dataProvider->getModels());
        }
        $models = $this->serializeModels($models);

        if (($pagination = $dataProvider->getPagination()) !== false) {
            $this->addPaginationHeaders($pagination);
        }

        if ($this->request->getIsHead()) {
            return null;
        } elseif ($this->collectionEnvelope === null) {
            return $models;
        }
        $result['success']=true;
        $result[$this->collectionEnvelope] = $models;

        if ($pagination !== false) {
            return array_merge($result, $this->serializePagination($pagination));
        }

        return $result;
    }
}