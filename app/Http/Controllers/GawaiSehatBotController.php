<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Icd;

class GawaiSehatBotController extends Controller
{
    public function getDiseasesByIcd(Botman $botman, $icd)
    {
        $diseases = Icd::diseasesByIcd($icd)->get();
        $this->showResult($botman, $diseases);
    }

    public function getDiseasesByName(Botman $botman, $name)
    {
        $diseases = Icd::diseasesByName($name)->get();
        $this->showResult($botman, $diseases);
    }

    private function showResult(Botman $botman, $diseases)
    {
        if ($diseases->count() > 5) {
            $botman->reply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
        } elseif ($diseases->count() == 0) {
            $botman->reply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
        } else {
            $botman->reply("Hasil pencarian yang sesuai");

            foreach ($diseases as $data) {
                $botman->reply(
                    "Kode ICD10 : $data->KD_PENYAKIT \r\n" .
                    "Kode ICD10 induk : $data->KD_ICD_INDUK \r\n" .
                    "Penyakit : $data->PENYAKIT \r\n" .
                    "Deskripsi : $data->DESCRIPTION"
                );
            }
        }
    }
}
