<?php

namespace Controllers\Api\Tab;
use \Djaravel\Utils\ModelFactory;
use \Djaravel\Models\Validator;
use \Models\Pagina;

class TabCreateEndpoint
{
    private static $model = Pagina::class;

    static function dispatch(...$args){
        # Set response headers: header('Content-Type: application/json')
        header('Content-Type: application/json');
        # Get raw request body data
        $content = json_decode(file_get_contents('php://input'), true);
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
        # Return the created object in JSON format
        $response = [
            'success' => true,
            'data' => $newTab->serialize(),
        ];
        echo json_encode($response);
    }
}