<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [

        'cityOrigin_certificate',
        'number_certificate',
        'cityDestination_certificate', 
        'placabike_certificate',
        'placaCar_certificate', 
        'adults_certificate', 
        'children_certificate',
        'entry_certificate', 
        'exit_certificate', 
        'observation_certificate'

    ];
}
