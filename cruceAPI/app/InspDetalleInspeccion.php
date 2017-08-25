<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspDetalleInspeccion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'insp_detalle_inspecciones';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    protected $primaryKey = 'id_inspeccion';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_inspeccion','manguera', 'manguera_observaciones',
    		 'ruedas', 'ruedas_observaciones', 'manometro', 'manometro_observaciones',
    		 'etiquetas', 'etiquetas_observaciones', 'vencimientos', 'vencimientos_observaciones',
    		 'accesibilidad', 'accesibilidad_observaciones', 'baliza', 'baliza_observaciones',
             'imagen', 'lat', 'lng'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id_inspeccion'];

    // Relación de InspDetalleInspeccion con InspInspeccion:
    public function inspinspeccion()
    {
        // Un detalle de inspeccion pertenece a una inspeccion 
        return $this->belongsTo('App\InspInspeccion', 'id_inspeccion');
    }
}
