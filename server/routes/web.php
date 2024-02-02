<?php

use App\Http\Controllers\FormController;
use App\Models\FAQ;
use App\Models\Methodology;
use App\Models\News;
use App\Models\Team;
use App\Models\Article;
use App\Models\Highlight;

use App\Models\UserAuthorized;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Client\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/form/upload', [FormController::class, 'store']);

Route::get('/api/form/downlaod', [FormController::class, 'download']);

Route::get('/api/news/{lang}', function (string $lang) {
    return News::getTranslate($lang);
});

Route::get('/api/highlights/{lang}', function (string $lang) {
    return Highlight::getTranslate($lang);
});

Route::get('/api/team/{lang}', function (string $lang) {
    return Team::getTranslate($lang);
});

Route::get('/api/articles/{lang}', function (string $lang) {
    return Article::getTranslate($lang);
});

Route::get('/api/methodologies/{lang}', function (string $lang) {
    return Methodology::getTranslate($lang);
});

Route::get('/api/popup/{lang}', function (string $lang) {
    return FAQ::getTranslate($lang);
});

Route::get('/api/faq/{lang}', function (string $lang) {
    return FAQ::getTranslate($lang);
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
