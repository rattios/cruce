<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SorteoWeb extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'participante_sorteo_web';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];
}
