<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecMarcaExtintor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_marca_extintor';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cod_marca', 'marca'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecMarcaExtintor con TecExtintor:
	public function tecextintores()
	{
		// De una misma marca pueden existir varios extintores
		return $this->hasMany('App\TecExtintor', 'id_marca');
	}
}
