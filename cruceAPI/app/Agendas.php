<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agendas extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agendas';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var arrayName
        E-mail 1 - Value
        Phone 1 - Value
        IM 1 - Service
        IM 1 - Value
     */
    //protected $fillable = ['id','nombre','telefono','email','servicio','valor'];
    protected $fillable = ['id','nombre','descripcion'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['created_at','updated_at'];

    public function registros()
    {
        // Un cliente puede tener varios telefonos
        return $this->hasMany('App\AgendasEventos','agenda_id');
    }

}
