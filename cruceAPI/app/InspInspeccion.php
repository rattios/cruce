<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspInspeccion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'insp_inspecciones';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    protected $primaryKey = 'id_inspeccion';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['insp_anio', 'insp_periodo', 'id_extintor', 'fecha_insp',
                         'insp_estado', 'id_operador', 'fecha_envio', 'insp_optativa',
                         'insp_remito'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de InspInspeccion con TecExtintor:
	public function tecextintor()
	{
		// Una inspección es aplicada a un extintor
		return $this->belongsTo('App\TecExtintor', 'id_extintor');
	}

    // Relación de InspInspeccion con InspDetalleInspeccion:
    public function detalleinspeccion()
    {
        // Una inspeccion tiene un detalle inspeccion 
        return $this->hasOne('App\InspDetalleInspeccion', 'id_inspeccion');
    }

    // Relación de InspInspeccion con ViewExtUltMov:
    public function viewextultmov()
    {
        // Una inspección se asocia con un ultimo moviminto
        return $this->belongsTo('App\ViewExtUltMov', 'id_extintor');
    }

}
