<?php

namespace Controllers\Api\Tab;
use \Models\Pagina;

class TabDetailEndpoint
{
    static function dispatch(...$args){

        $tab = Pagina::get(...$args);
        if(!$tab){
            http_response_code(404);
            $response = [
                'success' => false,
                'errors' => [
                    'Not found',
                ],
            ];
        }else{
            $response = [
                'success' => true,
                'data' => $tab->serialize(),
            ];
        }
        echo json_encode($response);
    }
}