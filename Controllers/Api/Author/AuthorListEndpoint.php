<?php

namespace Controllers\Api\Author;
use \Models\Usuario;
use \Models\Autor;
use \Djaravel\Utils\DB;

class AuthorListEndpoint
{
    static function dispatch(...$args){
        $orderBy = $_GET['orderBy'] ?? 'autor.id';
        $orderDirection = $_GET['direction'] ?? 'asc';
        $pageSize = 10;
        $currentPage = $_GET['page'] ?? 1;

        $authors = Autor
            ::select('autor.*')
            ->join('usuario', 'usuario.id', '=', 'autor.usuario')
            ->where('congreso', ...$args)
            ->orderBy($orderBy, $orderDirection)
            ->paginate($pageSize, $currentPage)
            ->getQuery();

        $totalAuthors = Autor::where('congreso', ...$args)->getQuery();
        $totalPages = ceil(count($totalAuthors) / $pageSize);

        $serializedAuthors = [];
        foreach($authors as $author){
            $user = $author->userObject->serialize();
            unset($user['tipo_de_usuario']);
            $authorUser = $author->serialize();
            unset($authorUser['contrasena']);
            unset($authorUser['count']);
            $authorUser['usuario'] = $user;
            $serializedAuthors[] = $authorUser;
        }
        $response = [
            'success' => true,
            'data' => $serializedAuthors,
            'page' => $currentPage,
            'total_pages' => $totalPages,
        ];
        echo json_encode($response);
    }
}