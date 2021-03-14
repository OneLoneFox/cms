<?php

namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyField;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\ForeignKeyField;

class Admin extends Model
{
    protected static $table = 'admin';
    static $baseRoute = 'admins';

    protected $id;
    protected $contrasena;
    protected $usuario;

    static function getFields(){
        return [
            'id' => new PrimaryKeyField(),
            'contrasena' => new VarcharField(false, 256, 'Contraseña'),
            'usuario' => new ForeignKeyField(Usuario::class, 'Usuario'),
        ];
    }

    function userObject(){
        return Usuario
            ::where('id', $this->usuario)
            ->first();
    }

    function __toString(){
        return $this->userObject->nombre;
    }
}