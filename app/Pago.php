<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
	public $timestamps = false;

	protected $fillable = [
		"empresa_id", "servicio_id", "fecha_inicio", "fecha_fin", "num_empleados", "status"
	];

	/**
     * Obtiene los usuarios relacionados con la lista de pago.
     */
	public function PagoUsuarios()
	{
		return $this->hasMany('App\UsuarioPago');
	}

	/**
     * Obtiene la empresa asociado con el pago.
     */
	public function empresa()
	{
		return $this->belongsTo('App\Empresa');
	}

	/**
     * Obtiene la deducción asociado con el detalle.
     */
	public function servicio()
	{
		return $this->belongsTo('App\EmpresaServicio');
	}
}
