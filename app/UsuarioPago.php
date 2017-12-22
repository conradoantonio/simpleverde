<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPago extends Model
{
	public $timestamps = false;

	protected $table = "usuario_pagos";

	public function pago(){
		return $this->belongsTo('App\Pago');
	}

	public function usuarios(){
		return $this->belongsTo('App\Empleado', 'trabajador_id', 'id');
	}

	public function asistencia(){
		return $this->hasMany('App\Asistencia');
	}
}
