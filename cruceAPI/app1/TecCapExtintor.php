<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecCapExtintor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_cap_extintor';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['capacidad', 'unidad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecCapExtintor con TecExtintor:
	public function tecextintores()
	{
		// Una capacidad puede tener varios extintores
		// (Diferentes extintores pueden tener la misma capacidad)
		return $this->hasMany('App\TecExtintor', 'id_capacidad');
	}

}
