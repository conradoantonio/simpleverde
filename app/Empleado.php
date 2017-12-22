<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	/**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'empleados';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'nombre', 'apellido', 'num_empleado', 'num_cuenta', 'domicilio', 'ciudad',
        'telefono', 'rfc', 'curp', 'nss', 'telefono_emergencia', 'status', 'created_at'
    ];

    /**
     * Obtiene la documentación asociada con el empleado.
     */
    public function documentacion()
    {
        return $this->hasOne('App\Documentacion', 'empleado_id');
    }
}
