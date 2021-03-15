<?php
namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyfield;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\IntegerField;
use \Djaravel\Models\Fields\ForeignKeyField;

class Autor extends Model
{
    const APPROVED = 0;
    const REVIEWING = 1;
    const DENIED = 2;
    
    const ARTICLES_STATUS_CHOICES = [
        self::APPROVED => 'Aprovado',
        self::REVIEWING => 'En revisión',
        self::DENIED => 'Rechazado',
    ];

    protected static $table = 'autor';
    static $baseRoute = 'authors';

    protected $id;
    protected $contrasena;
    protected $usuario;
    protected $articulo;
    protected $status;

    static function getFields(){
        return [
            'id' => new PrimaryKeyField(),
            'contrasena' => new VarcharField(false, 256, 'Contraseña'),
            'articulo' => new VarcharField(false, 100, 'Articulo'),
            'status' => new IntegerField(1, 'Estatus', self::ARTICLES_STATUS_CHOICES),
            'usuario' => new ForeignKeyField(Usuario::class, 'Usuario'),
            
        ];
    }

    function userObject(){
        return Usuario
            ::where('id', $this->usuario)
            ->first();
    }
}


?>