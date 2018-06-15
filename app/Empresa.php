<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'empresas';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'nombre', 'oficina_cargo', 'direccion', 'contacto', 'telefono', 
        'marcacion_corta', 'contrato', 'numero_elementos', 'fecha_inicio', 
        'fecha_termino', 'observaciones','status', 'created_at'
    ];

    /**
     * Define los campos que se ocultarán en las llamadas.
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Obtiene el servicio al que pertenece la empresaGet the user that owns the phone.
     */
    public function servicios()
    {
        return $this->hasMany('App\EmpresaServicio', 'empresa_id', 'id');
    }
}
