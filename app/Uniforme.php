<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uniforme extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'uniformes';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'empleado_id', 'playera_polo', 'camisa', 'pantalones', 'chaleco', 'sueter',
    	'chamarra', 'gorra', 'botas', 'traje', 'corbata', 'otros'
    ];

    /**
	 * Obtiene el empleado al que pertenece la documentación.
	 */
	public function empleado()
	{
	    return $this->belongsTo('App\Empleado', 'empleado_id', 'id');
	}

    /**
     * Actualiza o crea un nuevo modelo
     */
    public static function findOrCreate($id)
    {
        $obj = static::find($id);
        return $obj ?: new static;
    }
}
