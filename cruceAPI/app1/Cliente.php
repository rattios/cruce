<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

    // Relación de Cliente con Cliente_Telefono:
    public function telefonos()
    {
        // Un cliente puede tener varios telefonos
        return $this->hasMany('App\Cliente_Telefono','cliente_id');
    }

    // Relación de Cliente con Cliente_Nombre:
    public function nombres()
    {
        // Un cliente puede estar registrado con distintos nombres
        return $this->hasMany('App\Cliente_Nombre','cliente_id');
    }
}
