<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Twitter_tweets extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'twitter_tweets';

    // Eloquent asume que cada tabla tiene una clave primaria con una columna llamada id.
    // Si éste no fuera el caso entonces hay que indicar cuál es nuestra clave primaria en la tabla:
    //protected $primaryKey = 'id';

    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['entities', 'favorite_count', 'retweet_count', 'text', 'tweet_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = [];
}
