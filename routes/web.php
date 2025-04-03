<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('contacts.index');
});

// Rotas de autenticação
Auth::routes();

// Rotas de contatos
Route::resource('contacts', ContactController::class);