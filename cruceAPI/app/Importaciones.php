<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importaciones extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'importaciones_bds';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','fecha','cant'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

    // Relación de Cliente con Cliente_Telefono:
    public function parse()
    {
        // Un cliente puede tener varios telefonos
        return $this->hasMany('App\Parse','importaciones_id');
    }

}