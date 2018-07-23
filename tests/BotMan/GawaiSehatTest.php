<?php

namespace Tests\BotMan;

use Illuminate\Foundation\Inspiring;
use Tests\TestCase;
use App\Icd;

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
            ->receives('hallo')
            ->assertReplies([
                'Maaf, perintah tidak dikenali. Berikut ini adalah perintah yang dikenali :',
                '1. Kode ICD 10 : {kode_icd}',
                '2. Penyakit : {nama_penyakit}',
            ]);
    }

    /**
     * @test
     */
    public function replyWhenResultDiseaseNotFound()
    {
        $this->bot
            ->receives('Penyakit : abc')
            ->assertReply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
    }

    /**
     * @test
     */
    public function replyWhenResultDiseaseToMany()
    {
        $this->bot
            ->receives('Penyakit : a')
            ->assertReply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
    }

    /**
     * @test
     */
    public function replyWhenResultIcdNotFound()
    {
        $this->bot
            ->receives('Kode ICD 10 : abc')
            ->assertReply('Data tidak ditemukan. Silahkan melakukan pencarian ulang.');
    }

    /**
     * @test
     */
    public function replyWhenResultIcdToMany()
    {
        $this->bot
            ->receives('Kode ICD 10 : 1')
            ->assertReply('Hasil pencarian terlalu banyak. Perkecil hasil pencarian dengan melakukan pencarian ulang.');
    }
}
