<?php

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

Route::get('/db-dump', function () {
    \Spatie\DbDumper\Databases\MySql::create()
        ->setDbName('trello')
        ->setUserName('root')
        ->setPassword('')
        ->dumpToFile('dump.sql');
});

Route::any('/', function () {
    return view('trello-board');
});
