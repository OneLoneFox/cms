<?php

namespace Models;
use \Djaravel\Models\Model;
use \Djaravel\Models\Fields\PrimaryKeyfield;
use \Djaravel\Models\Fields\VarcharField;
use \Djaravel\Models\Fields\IntegerField;
use \Djaravel\Models\Fields\ForeignKeyField;

class Congreso extends Model
{
    const PRIVATE = 0;
    const PUBLIC = 1;
    const PUBLIC_CHOICES = [
        self::PRIVATE => 'Privado',
        self::PUBLIC => 'Publico',
    ];

    protected static $table = 'congreso';
    static $baseRoute = 'dashboard/posts';

    protected $id;
    protected $nombre;
    protected $programa_pdf;
    protected $publico;
    protected $admin;

    static function getFields(){
        return [
            'id' => new PrimaryKeyfield('Id'),
            'nombre' => new VarcharField(false, 50, 'Nombre'),
            'programa_pdf' => new VarcharField(true, 100, 'Programa (pdf)'),
            'publico' => new IntegerField(1, 'Publico', self::PUBLIC_CHOICES, self::PRIVATE),
            'admin' => new ForeignKeyField(Admin::class, 'Creado por'),
        ];
    }

    function createdBy(){
        return Usuario
            ::where('id', $this->admin__usuario)
            ->first();
    }
}