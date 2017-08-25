<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecLocalidad extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_localidad';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_empresa', 'nom_localidad'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecLocalidad con TecExtintor:
	public function tecextintores()
	{
		// En una localidad pueden haber varios extintores
		return $this->hasMany('App\TecExtintor', 'id_localidad');
	}

    // Relación de TecLocalidad con TecEmpresa:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxempresas()
    {
        // En una localidad pueden haber varias empresas
        return $this->belongsTo('App\TecEmpresa','id_empresa');
            
    }
}
