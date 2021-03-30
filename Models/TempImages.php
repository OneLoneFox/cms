<?php

namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyField;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\ForeignKeyField;

class TempImages extends Model
{
    protected static $table = 'temp_images';

    protected $id;
    protected $path;
    protected $congreso;
    protected $pagina;
    protected $admin;

    static function getFields(){
        return [
            'id' => new PrimaryKeyField('Id'),
            'path' => new VarcharField(false, 200, 'Path'),
            'congreso' => new ForeignKeyField(Congreso::class, 'Congreso'),
            'pagina' => new ForeignKeyField(Pagina::class, 'Página'),
            'admin' => new ForeignKeyField(Admin::class, 'Admin'),
        ];
    }
}