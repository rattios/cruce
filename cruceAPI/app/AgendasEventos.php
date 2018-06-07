<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendasEventos extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agendas_eventos';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','nombre','telefono','email','servicio','valor','n_importacion','angenda_id','created_at','updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['created_at','updated_at'];

}
