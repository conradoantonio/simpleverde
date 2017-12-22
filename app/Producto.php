<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class producto extends Model
{
	/**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'productos';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'nombre', 'descripcion', 'precio', 'categoria_id', 'foto_producto', 'precio_porcion', 
    	'cantidad_porcion', 'precio_chico', 'precio_grande', 'status'
    ];
}
