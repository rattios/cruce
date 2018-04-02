<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TecOtExtintor extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tec_ot_extintores';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_ot', 'id_extintor', 
    		'observaciones', 'mantenimiento',
    		 'hidraulica', 'baja', 'fecha_man',
    		  'fecha_hid', 'change_time', 'force_ph'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];

    // Relación de TecOTExtintor con TecExtintor:
    //Nota: Esta es una relacion auxiliar 1-N porque 
        //originalmente la relacion es N-N.
    public function auxextintores()
    {
        // Una orden de trabajo es emitida para varios extintores
        return $this->belongsTo('App\TecExtintor','id_extintor');
            
    }
}
