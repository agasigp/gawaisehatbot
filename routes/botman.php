<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\GawaiSehatBotController;

// Botman
$botman = resolve('botman');

// Gawaisehat Bot
$botman->hears('/start', function ($bot) {
    $bot->reply('Selamat datang di gawaisehat bot. Berikut ini adalah perintah yang dikenali oleh gawaisehat :');
    $bot->reply('1. Kode ICD 10 : {kode_icd}');
    $bot->reply('2. Penyakit : {nama_penyakit}');
});
$botman->hears('Kode ICD 10 : {icd}', GawaiSehatBotController::class.'@getIcd');
$botman->hears('Penyakit : {disease}', GawaiSehatBotController::class.'@getDisease');
$botman->fallback(function ($bot) {
    $bot->reply('Maaf, perintah tidak dikenali. Berikut ini adalah perintah yang dikenali :');
    $bot->reply('1. Kode ICD 10 : {kode_icd}');
    $bot->reply('2. Penyakit : {nama_penyakit}');
});
