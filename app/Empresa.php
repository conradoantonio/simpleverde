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
    	'nombre', 'oficina_cargo', 'direccion', 'contacto', 'telefono', 'marcacion_corta', 'status', 'created_at'
    ];

    /**
     * Obtiene el servicio al que pertenece la empresaGet the user that owns the phone.
     */
    public function servicios()
    {
        return $this->hasMany('App\EmpresaServicio', 'empresa_id', 'id');
    }
}
