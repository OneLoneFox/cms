<?php

namespace Controllers\Api\Tab;
use \Models\Pagina;

class TabUpdateEndpoint
{
    // ToDo: on update remove record from temp_images table (select by tab id and current admin id)
    static function dispatch(...$args){
        $tabToUpdate = Pagina::get(...$args);
        $_PATCH = json_decode(file_get_contents('php://input'), true);
        $tabToUpdate->contenido = json_encode($_PATCH['contenido']);
        if($tabToUpdate->save()){
            $response = [
                'success' => true,
                'data' => $tabToUpdate->serialize(),
            ];
        }else{
            // ToDo: validate content to update
            $response = [
                'success' => false,
                'errors' => [
                    'failed to update',
                ],
            ];
        }
        echo json_encode($response);
    }
}