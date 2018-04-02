<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente_Nombre extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clientes_nombres';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cliente_id','nombre'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

    // Relación de Cliente_Nombre con Cliente:
	public function cliente()
	{
		// Un nombre pertenece a un cliente
		return $this->belongsTo('App\Cliente','cliente_id');
	}

    
}
