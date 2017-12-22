<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioDetalle extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'servicio_detalles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'servicio_id', 'tipo', 'nombre_producto', 'foto_producto', 'precio', 'cantidad', 
        'porciones_adicionales', 'precio_porcion', 'medida_porcion', 'created_at'
    ];   
}
