<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icd extends Model
{
    protected $table = 'mst_icd';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function scopeDiseasesByIcd($query, $icd)
    {
        return $query->where('KD_PENYAKIT', 'like', "%$icd%");
    }

    public function scopeDiseasesByName($query, $name)
    {
        return $query->where('PENYAKIT', 'like', "%$name%");
    }
}
