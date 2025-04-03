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
    // Retorna a view diretamente em vez de redirecionar
    $contacts = App\Models\Contact::orderBy('name')->paginate(10);
    return view('contacts.index', compact('contacts'));
});

// Rotas de autenticação
Auth::routes();

// Rotas de contatos
Route::resource('contacts', ContactController::class);