<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecExtintor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_extintores';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['serie', 'interno', 'id_marca', 'id_capacidad',
     'tipo', 'pruebahidraulica', 'codigocliente', 'fecha', 'id_empresa', 
     'id_primaria', 'id_secundaria', 'id_yacimiento', 'id_ubicacion', 
     'referencia', 'id_localidad', 'anio', 'estado', 'ubicacion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecExtintor con TecMarcaExtintor:
	public function tecmarcaextintor()
	{
		// Un extintor tiene una marca
		return $this->belongsTo('App\TecMarcaExtintor','id_marca');
	}

	// Relación de TecExtintor con TecUbicacion:
	public function tecubicacion()
	{
		// Un extintor esta en una ubicación 
		return $this->belongsTo('App\TecUbicacion', 'id_ubicacion');
	}

	// Relación de TecExtintor con TecTipoExtintor:
	public function tectipoextintor()
	{
		// Un extintor debe ser de un tipo 
		return $this->belongsTo('App\TecTipoExtintor','tipo');
	}

	// Relación de TecExtintor con TecLocalidad:
	public function teclocalidad()
	{
		// Un extintor esta en una localidad 
		return $this->belongsTo('App\TecLocalidad', 'id_localidad');
	}

	// Relación de TecExtintor con TecEmpresa:
	public function tecempresa()
	{
		// Un extintor pertenece a una empresa 
		return $this->belongsTo('App\TecEmpresa', 'id_empresa');
	}

	// Relación de TecExtintor con TecCapExtintor:
	public function teccapextintor()
	{
		//Un extintor tiene una capacidad 
		return $this->belongsTo('App\TecCapExtintor', 'id_capacidad');
	}

	// Relación de TecExtintor con TecYacimiento:
	public function tecyacimiento()
	{
		//Un extintor esta en un yacimiento 
		return $this->belongsTo('App\TecYacimiento', 'id_yacimiento');
	}

	// Relación de TecExtintor con InspInspeccion:
	public function inspinspecciones()
	{
		//Un extintor puede tener asignadas varias inspecciones 
		return $this->hasMany('App\InspInspeccion', 'id_extintor');
	}

    // Relación de TecExtintor con TecOTExtintor:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxotextintores()
    {
        // Un extintor puede tener varias ordenes de trabajo
        //Nota: y una sola en estado abierto --> VERIFICAR ESTO
        return $this->hasMany('App\TecOTExtintor','id_extintor');
    }

	// Relación de TecExtintor con ViewExtUltMov :
	public function viewextultmov()
	{
		// Un extintor tiene un ultimo movimiento
		return $this->hasOne('App\ViewExtUltMov', 'id_extintor');
	}
}
