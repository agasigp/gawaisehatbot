<?php

namespace Tests\BotMan;

use Tests\TestCase;
use App\Icd;
use App\Repositories\DiseaseRepository;

class GawaiSehatTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function startBotTest()
    {
        $this->bot
            ->receives('/start')
            ->assertReplies([
                'Selamat datang di gawaisehat bot. Berikut ini adalah perintah yang dikenali oleh gawaisehat :',
                '1. Kode ICD 10 : {kode_icd}',
                '2. Penyakit : {nama_penyakit}',
            ]);
    }

    /**
     * A conversation test example.
     *
     * @return void
     * @test
     */
    public function fallbackReplyIfCommandIsNotRecognized()
    {
        $this->bot
            ->receives(str_random(5))
            ->assertReplies([
                'Maaf, perintah tidak dikenali. Berikut ini adalah perintah yang dikenali :',
                '1. Kode ICD 10 : {kode_icd}',
                '2. Penyakit : {nama_penyakit}',
            ]);
    }

    /**
     * @test
     */
    public function replyWhenResultIsNotFound()
    {
        $this->bot
            ->receives('Penyakit : abc')
            ->assertReply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.')
            ->receives('Kode ICD 10 : abc')
            ->assertReply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
    }

    /**
     * @test
     */
    public function replyWhenResultIsToMany()
    {
        $this->bot
            ->receives('Penyakit : a')
            ->assertReply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.')
            ->receives('Kode ICD 10 : a')
            ->assertReply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
    }

    /**
     * @test
     */
    public function replyWhenResultIsFound()
    {
        $diseaseRepository = new DiseaseRepository(new Icd());
        $this->bot
            ->receives('Penyakit : batuk')
            ->assertReply('Hasil pencarian yang sesuai');

        $diseases = $diseaseRepository->getDiseasesByName('batuk');

        foreach ($diseases as $disease) {
            $this->bot
                ->assertReply(
                    "Kode ICD10 : $disease->KD_PENYAKIT \r\n" .
                    "Kode ICD10 induk : $disease->KD_ICD_INDUK \r\n" .
                    "Penyakit : $disease->PENYAKIT \r\n" .
                    "Deskripsi : $disease->DESCRIPTION"
                );
        }

        $this->bot
            ->receives('Kode ICD 10 : A00')
            ->assertReply('Hasil pencarian yang sesuai');

        $diseases = $diseaseRepository->getDiseasesByIcd('A00');

        foreach ($diseases as $disease) {
            $this->bot
                ->assertReply(
                    "Kode ICD10 : $disease->KD_PENYAKIT \r\n" .
                    "Kode ICD10 induk : $disease->KD_ICD_INDUK \r\n" .
                    "Penyakit : $disease->PENYAKIT \r\n" .
                    "Deskripsi : $disease->DESCRIPTION"
                );
        }
    }
}
