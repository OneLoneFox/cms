<?php

namespace Controllers\Api\Tab;
use \Models\Congreso;
use \Models\TempImages;
use \Djaravel\Utils\ModelFactory;

class TabImageUploadEndpoint
{
    static function dispatch(...$args){
        $currentAdmin = $_SESSION['user']->id;
        $file = self::saveImage($_FILES['image'], $_POST['post_id'], $_POST['tab_id']);
        if(count($file['errors']) > 0){
            http_response_code(500);
            // If errors return success: 0
            $response = [
                'success' => 0,
                'errors' => $file['errors'],
            ];
        }else{
            // Create a new temp image record so we can delete unused images
            $tempRecord  = ModelFactory::fromArray(TempImages::class, [
                'path' => $file['path'],
                'congreso' => $_POST['post_id'],
                'pagina' => $_POST['tab_id'],
                'admin' => $currentAdmin,
            ]);
            $tempRecord->save();
            $response = [
                'success' => 1,
                'file' => [
                    'url' => $file['public_path'],
                ],
            ];
        }
        echo json_encode($response);
    }

    static function saveImage($file, $postId, $tabId){
        $errors = self::validateImage($file);
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        $uniqueName = time() . '.' . $ext;
        $publicPath = sprintf(
            '/'.$_ENV['BASE_DIR'].'/public/uploads/%s/%s/',
                $postId,
                $tabId
        );
        $path = $_SERVER['DOCUMENT_ROOT'].$publicPath;
        // If the dir does not exist then create it
        if(!is_dir($path)){
            // If for any reason failed to create the dir then add an error
            if(!mkdir($path, 0777, true)){
                $errors[] = 'failed to create directory '.$path;
            }
        }
        // add the filename after ensuring the dir is created
        $path .= $uniqueName;
        // move tmp file to new location and filename
        if( !move_uploaded_file($file['tmp_name'], $path) ){
            $errors[] = 'Could not save';
        }
        // Add the filename to the public path too
        $publicPath .= $uniqueName;
        return [
            'path' => $path,
            'public_path' => $publicPath,
            'errors' => $errors,
        ];
    }

    static function validateImage($file){
        $errors = [];
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors[] = 'No file sent.';
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors[] = 'Exceeded filesize limit.';
            default:
                $errors[] = 'Unknown errors.';
        }
        return $errors;
    }
}