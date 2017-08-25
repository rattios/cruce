<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecOt extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_ot';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['num_ot', 'id_empresa', 'estado', 'fecha', 'id_secundaria', 'id_primaria', 'codeorden'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

	// Relación de TecOt con TecEmpresa:
	public function tecempresa()
	{
		// Una ot  se genera para una única empresa 
		return $this->belongsTo('App\TecEmpresa', 'id_empresa');
	}
}
