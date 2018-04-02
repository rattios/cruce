<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecYacimiento extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_yacimientos';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['yacimiento', 'nom_empresa', 'id_empresa'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecYacimiento con TecExtintor:
	public function tecextintores()
	{
		// Un yacimineto puede tener varios extintores
		return $this->hasMany('App\TecExtintor', 'id_yacimiento');
	}

    // Relación de TecYacimiento con TecEmpresa:
    public function tecempresas()
    {
        // En un yacimiento pueden haber varias empresas
        return $this->belongsToMany('App\TecEmpresa', 'tec_empresas_tec_yacimientos', 'id_yacimiento','id_empresa');
            //->withPivot('id_empresa', 'id_yacimiento');
    }

    // Relación de TecYacimiento con TecEmpresa:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxempresas()
    {
        // En un yacimiento pueden haber varias empresas
        return $this->belongsTo('App\TecEmpresa','id_empresa');
            
    }

}
