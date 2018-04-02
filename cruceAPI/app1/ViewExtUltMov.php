<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewExtUltMov extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'view_extintor_ultimo_movimiento';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    protected $primaryKey = 'id_extintor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_extintor', 'serie', 'estado',
    	 'ultimo_mov', 'tipo_mov'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de ViewExtUltMov con TecExtintor:
	public function tecextintor()
	{
		// Un ultimo movimineto pertenece a un extintor
		return $this->belongsTo('App\TecExtintor', 'id_extintor');
	}
   
    // Relación de ViewExtUltMov con InspInspeccion:
    public function inspeccion()
    {
        // Un ultimo movimineto se asocia con una inspeaccion
        return $this->hasOne('App\InspInspeccion', 'id_extintor');
    }   

}
