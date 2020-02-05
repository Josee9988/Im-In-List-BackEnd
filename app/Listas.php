<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{   
    /**
     * @var string
     */
    protected $table = 'listas';
    // - Ahorras codigo == al fillable
    protected $guarded = [];
}
