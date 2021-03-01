<?php

use App\Models\ConvertedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('short-url/{shortUrl}', function (Request $request, $shortUrl) {
    $convertedUrl = ConvertedUrl::where('short_url', $shortUrl)->first();

    if (!$convertedUrl) {
        abort(404);
    }

    return redirect($convertedUrl->original_url);
});
