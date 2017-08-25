<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecEmpresa extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_empresas';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom_empresa', 'particular', 'cuit', 'email', 'telefono', 'estado', 'offline_export'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecEmpresa con TecExtintor:
	public function tecextintores()
	{
		// Una empresa puede tener varios extintores
		return $this->hasMany('App\TecExtintor', 'id_empresa');
	}

    // Relación de TecEmpresa con TecOt:
    public function tecot()
    {
        // Una empresa se asocia con una ot 
        return $this->hasOne('App\TecOt', 'id_empresa');
    }

    // Relación de TecEmpresa con TecYacimiento:
    /*public function tecyacimientos()
    {
        // Una empresa puede tener sucursales en varios yacimientos
        return $this->belongsToMany('App\TecYacimiento', 'tec_empresas_tec_yacimientos', 'id_empresa', 'id_yacimiento');
            //->withPivot('id_empresa', 'id_yacimiento');
    }*/

    // Relación de TecEmpresa con TecYacimiento:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxyacimientos()
    {
        // Una empresa puede tener sucursales en varios yacimientos
        return $this->hasMany('App\TecYacimiento','id_empresa');
    }

    // Relación de TecEmpresa con TecLocalidad:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxlocalidades()
    {
        // Una empresa puede tener sucursales en varias localidades
        return $this->hasMany('App\TecLocalidad','id_empresa');
    }
            


}
