<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
	public $timestamps = false;

	protected $fillable = [
		"empresa_id", "servicio_id", "fecha_inicio", "fecha_fin", "num_empleados", "status"
	];

	public function PagoUsuarios(){
		return $this->hasMany('App\UsuarioPago');
	}

	public function empresa(){
		return $this->belongsTo('App\Empresa');
	}

	public function servicio(){
		return $this->belongsTo('App\EmpresaServicio');
	}

}
