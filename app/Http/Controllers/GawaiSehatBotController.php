<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Icd;

class GawaiSehatBotController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    public function getIcd(Botman $botman, $disease)
    {
        $data_icd = Icd::where('KD_PENYAKIT', 'like', "%$disease%")->get();

        if ($data_icd->count() > 5) {
            $botman->reply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
        } elseif ($data_icd->count() == 0) {
            $botman->reply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
        } else {
            $botman->reply("Hasil pencarian yang sesuai");

            foreach ($data_icd as $data) {
                $botman->reply(
                    "Kode ICD10 : $data->KD_PENYAKIT \r\n".
                    "Kode ICD10 induk : $data->KD_ICD_INDUK \r\n".
                    "Penyakit : $data->PENYAKIT \r\n".
                    "Deskripsi : $data->DESCRIPTION"
                );
            }
        }
    }

    public function getDisease(Botman $botman, $disease)
    {
        $data_icd = Icd::where('PENYAKIT', 'like', "%$disease%")->get();

        if ($data_icd->count() > 5) {
            $botman->reply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
        } elseif ($data_icd->count() == 0) {
            $botman->reply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
        } else {
            $botman->reply("Hasil pencarian yang sesuai");

            foreach ($data_icd as $data) {
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
