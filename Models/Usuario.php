<?php

namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyField;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\IntegerField;

class Usuario extends Model
{
    const MALE = 'm';
    const FEMALE = 'f';

    const SEX_CHOICES = [
        self::MALE => 'Masculino',
        self::FEMALE => 'Femenino'
    ];

    const ADMIN = 0;
    const PARTICIPANT = 1;
    const AUTHOR = 2;
    const CO_AUTHOR = 3;

    const USER_TYPE_CHOICES = [
        self::ADMIN => 'Admin',
        self::PARTICIPANT => 'Participante',
        self::AUTHOR => 'Autor',
        self::CO_AUTHOR => 'Co-autor',
    ];

    protected static $table = 'usuario';
    static $baseRoute = 'users';

    protected $id;
    protected $nombre;
    protected $correo;
    protected $celular;
    protected $sexo;
    protected $tipo_de_usuario;

    static function getFields(){
        return [
            'id' => new PrimaryKeyField('Id'),
            'nombre' => new VarcharField(false, 200, 'Nombre'),
            'correo' => new VarcharField(false, 200, 'Correo'),
            'celular' => new VarcharField(false, 10, 'Celular'),
            'sexo' => new VarcharField(false, 1, 'Sexo', self::SEX_CHOICES),
            'tipo_de_usuario' => new IntegerField(1, 'Tipo de usuario', self::USER_TYPE_CHOICES),
        ];
    }
}