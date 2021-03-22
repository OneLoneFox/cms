<?php

namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyField;
use \Djaravel\Models\Fields\LongtextField;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\ForeignKeyField;
use \Models\Congreso;

class Pagina extends Model
{
    protected static $table = 'pagina';

    protected $id;
    protected $nombre;
    protected $contenido;
    protected $congreso;

    static function getFields(){
        return [
            'id' => new PrimaryKeyField('Id'),
            'nombre' => new VarcharField(false, 20, 'Nombre'),
            // 'contenido' => new VarcharField(false, -1, 'Contenido'),
            'contenido' => new LongtextField(true, 'Contenido'),
            'congreso' => new ForeignKeyField(Congreso::class, 'Congreso'),
        ];
    }
}