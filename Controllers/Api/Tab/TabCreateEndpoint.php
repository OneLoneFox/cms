<?php

namespace Controllers\Api\Tab;
use \Djaravel\Utils\ModelFactory;
use \Djaravel\Models\Validator;
use \Models\Pagina;
use \Models\Congreso;

class TabCreateEndpoint
{
    // ToDo: Admin validation
    private static $model = Pagina::class;

    static function dispatch(...$args){
        # Set response headers: header('Content-Type: application/json')
        header('Content-Type: application/json');
        # Get raw request body data
        $content = json_decode(file_get_contents('php://input'), true);
        # First of all make sure there's no repeated Tab name under the current Post
        $tabName = $content['nombre'];
        $ffs = Congreso::where('id', $content['congreso'])->first();
        $repeatedTab = Pagina::where('nombre', $tabName)->first();
        if($repeatedTab){
            http_response_code(409);
            $response = [
                'success' => false,
                'errors' => [
                    'Could not create tab, the name '.$tabName.' already exists.'
                ],
            ];
            echo json_encode($response);
            return;
        }
        # Create new object
        $newTab = ModelFactory::fromArray(self::$model, $content);
        $validator = new Validator();
        $errors = $validator->validate($newTab);
        if(count($errors) > 0){
            http_response_code(400);
            // Return a list with the errors if any
            $response = [
                'success' => false,
                'errors' => $errors,
            ];
            echo json_encode($response);
            return;
        }
        if($newTab->save()){
            http_response_code(201);
            $response = [
                'success' => true,
                'data' => $newTab->serialize(),
            ];
            echo json_encode($response);
            return;
        }
        $response = [
            'success' => false,
            'errors' => [
                'Unknown error. Could not save.'
            ],
        ];
        # Return the created object in JSON format
        echo json_encode($response);
    }
}