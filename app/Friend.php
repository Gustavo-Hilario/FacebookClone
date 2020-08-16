<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /* mass assigment error on test */
    protected $guarded = [];

    /* confirmed_at should be a Carbon instance */
    protected $dates = ['confirmed_at'];
}
