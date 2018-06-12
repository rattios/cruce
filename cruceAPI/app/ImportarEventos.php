<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportarEventos extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'importar_eventos';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','evento','tipo_del_evento','datos_del_envento','observaciones','id_usuario','usuario','nombre','telefono','dni','email','ciudad','pais','url','comentarios','me_gusta','fecha','evento_id','n_importacion','ganador','created_at','updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['created_at','updated_at'];

}
