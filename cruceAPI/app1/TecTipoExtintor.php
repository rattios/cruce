<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecTipoExtintor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_tipo_extintor';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo', 'vidautil', 'periodo', 'unidad', 'items_por_defecto'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecTipoExtintor con TecExtintor:
	public function tecextintores()
	{
		// Pueden existir varios extintores de un mismo tipo
		return $this->hasMany('App\TecExtintor', 'tipo');
	}
}
