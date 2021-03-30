<?php

namespace Controllers\Api\Tab;
use \Djaravel\Serializers\ModelSerializer;
use \Models\Pagina;

class TabListEndpoint
{
    // ToDo: validation
    private static $model = Pagina::class;

    static function dispatch(...$args){
        # Id of parent post is the first element of args
        $postTabs = Pagina
            ::select('id', 'nombre')
            ->where('congreso', $args[0])
            ->orderBy('id')
            ->getQuery();
        $serializer = new ModelSerializer($postTabs);
        $response = [
            'success' => true,
            'data' => json_decode($serializer->data),
        ];
        echo json_encode($response);
    }
}