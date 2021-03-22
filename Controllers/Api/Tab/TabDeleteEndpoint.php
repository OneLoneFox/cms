<?php

namespace Controllers\Api\Tab;
use \Models\Pagina;

class TabDeleteEndpoint
{
    // ToDo: validate admin user
    static function dispatch(...$args){
        if(!Pagina::exists(...$args)){
            http_response_code(404);
            $response = [
                'success' => false,
                'errors' => ['Resource does not exist.'],
            ];
        }
        if(Pagina::delete(...$args)){
            $response = [
                'success' => true,
            ];
        }else{
            http_response_code(500);
            $response = [
                'success' => false,
                'errors' => 'Could not delete resource. Unknown error.',
            ];
        }
        echo json_encode($response);
    }
}