<?php
namespace App\Repositories;

use App\Icd;

class DiseaseRepository
{
    protected $model;
    public function __construct(Icd $icd)
    {
        $this->model = $icd;
    }

    public function getDiseasesByName($name)
    {
        return $this->model->diseasesByName($name)->get();
    }

    public function getDiseasesByIcd($icd)
    {
        return $this->model->diseasesByIcd($icd)->get();
    }
}
