<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\GawaiSehatBotController;

// Botman
$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears("My name is {name}", BotManController::class.'@getName');
$botman->hears('Start conversation', BotManController::class.'@startConversation');

// Gawaisehat Bot
$botman->hears('/start', function ($bot) {
    $bot->reply('Selamat datang di gawaisehat bot. Berikut ini adalah perintah yang dikenali oleh gawaisehat :');
    $bot->reply('1. cari penyakit dengan kode ICD {kode_icd}');
    $bot->reply('2. cari kode ICD dengan penyakit {nama_penyakit}');
});
$botman->hears('cari penyakit dengan kode ICD {icd}', GawaiSehatBotController::class.'@getIcd');
$botman->hears('cari kode ICD dengan penyakit {disease}', GawaiSehatBotController::class.'@getDisease');
$botman->fallback(function ($bot) {
    $bot->reply('Maaf, perintah tidak dikenali. Berikut ini adalah perintah yang dikenali :');
    $bot->reply('1. cari penyakit dengan kode ICD {kode_icd}');
    $bot->reply('2. cari kode ICD dengan penyakit {nama_penyakit}');
});
