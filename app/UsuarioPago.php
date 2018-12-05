<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPago extends Model
{
	public $timestamps = false;

	protected $table = "usuario_pagos";

	/**
     * Obtiene la lista de pago asociado con el registro.
     */
	public function pago()
	{
		return $this->belongsTo('App\Pago');
	}

	/**
     * Obtiene el empleado asociados con el registro.
     */
	public function usuarios()
	{
		return $this->belongsTo('App\Empleado', 'trabajador_id', 'id');
	}

	/**
     * Obtiene la lista de pago asociado con el registro.
     */
	public function asistencia()
	{
		return $this->hasMany('App\Asistencia');
	}

	/**
     * Obtiene los detalles de deducciones asociados con el registro.
     */
	public function deducciones_detalles()
	{
		return $this->hasMany('App\DeduccionDetalle');
	}

	/**
     * Obtiene las retenciones asociadas con el registro.
     */
	public function retenciones()
	{
		return $this->hasMany('App\Retencion');
	}

	/**
     * Obtiene las conceptos asociadas con el registro.
     */
	public function conceptos()
	{
		return $this->hasMany('App\Concepto');
	}
}
