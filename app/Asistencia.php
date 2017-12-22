<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
	protected $fillable = [
		'usuario_pago_id', 'status'
	];

	public function pago(){
		return $this->belongsTo('App\UsuarioPago', 'usuario_pago_id');
	}
}
