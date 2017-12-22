<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Faq extends Model
{
    /**
     * El nombre de la tabla usada por el modelo.
     *
     * @var string
     */
    protected $table = 'preguntas_frecuentes';

    /**
     * Los atributos que pueden ser asignados masivamente.
     *
     * @var array
     */
    protected $fillable = ['ayuda_menu_id', 'pregunta', 'respuesta', 'imagen'];

}
