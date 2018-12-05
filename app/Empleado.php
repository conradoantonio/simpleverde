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
        'telefono', 'rfc', 'curp', 'nss', 'telefono_emergencia', 'fecha_ingreso',
        'escolaridad', 'infonavit', 'vacaciones', 'pensionado', 'perfil_laboral',
        'fecha_baja', 'motivo_baja', 'fecha_finiquito', 'descripcion_finiquito',
        'fecha_entrega_papeles', 'entrega_papeles', 'status', 'created_at'
    ];

    /**
     * Define los campos que se ocultarán en las llamadas.
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Obtiene la documentación asociada con el empleado.
     */
    public function documentacion()
    {
        return $this->hasOne('App\Documentacion', 'empleado_id');
    }

    /**
     * Obtiene la información del uniforme asociado con el empleado.
     */
    public function uniforme()
    {
        return $this->hasOne('App\Uniforme', 'empleado_id');
    }

    /**
     * Obtiene la información de los aditamentos asociados con el empleado.
     */
    public function aditamento()
    {
        return $this->hasOne('App\Aditamento', 'empleado_id');
    }

    /**
     * Obtiene las posibles deducciones del empleado.
     */
    public function deducciones()
    {
        return $this->hasMany('App\Deduccion', 'empleado_id');
    }

    /**
     * Obtiene las posibles retenciones del empleado.
     */
    public function retenciones()
    {
        return $this->hasMany('App\Retencion', 'empleado_id');
    }

    /**
     * Obtiene las posibles conceptos del empleado.
     */
    public function conceptos()
    {
        return $this->hasMany('App\Concepto', 'empleado_id');
    }
}
