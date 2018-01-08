<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icd extends Model
{
    protected $table = 'mst_icd';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
