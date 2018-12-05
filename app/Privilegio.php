<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilegio extends Model
{
    /**
     * Define el nombre de la tabla del modelo.
     */
    protected $table = 'privilegios';

    /**
     * Define el nombre de los campos que podrán ser alterados de la tabla del modelo.
     */
    protected $fillable = [
    	'user_id', 'cli_act', 'cli_act_mod', 'cli_baj', 'cli_baj_mod', 'emp_act', 'emp_act_mod',
    	'emp_baj', 'emp_baj_mod', 'emp_mod_prop', 'usuarios', 'asistencias', 
        'asistencias_mod_list', 'asistencias_mod_all_days', 'historial_asistencias'
    ];

    /**
	 * Obtiene el usuario al que pertenecen los privilegios.
	 */
	public function usuario()
	{
	    return $this->belongsTo('App\User', 'user_id', 'id');
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
