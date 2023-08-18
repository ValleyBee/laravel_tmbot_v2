<?php

use App\Http\Controllers\Aibots as AibotController;
use App\Http\Controllers\Botusers;
use App\Http\Controllers\BotusersAdminPanel;
use App\Http\Helpers\Messages;
use Illuminate\Support\Facades\Route;

// use App\Models\Botuser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});



//Route::get('/tm2', [TmbotController::class, 'start'])->name('tm2.start');

//Route::get('/tm-test', function () {
//    App\Jobs\StarterMethods::dispatch()->delay(1);
//});


Route::get('/sendmsg', [BotusersAdminPanel::class, 'sendMessage'])->name('sendmsg.sendMessage');
Route::put('/sendmsg-auth', [BotusersAdminPanel::class, 'sendMessageAuth'])->name('sendmsg.sendMessageAuth');
Route::put('/sendmenu', [BotusersAdminPanel::class, 'sendMenu'])->name('sendmenu.sendMenu');
Route::get('/send-photo', [BotusersAdminPanel::class, 'sendPhoto'])->name('sendpht.sendPhoto');
Route::get('/updated-activity', [BotusersAdminPanel::class, 'updatedActivity'])->name('updates');
Route::get('/show-all-users', [BotusersAdminPanel::class, 'showAllUsers'])->name('showallusers.all');
Route::get('/show-users-msg/{id}', [BotusersAdminPanel::class, 'userAllMessages'])->name('userallmsg.messages');
Route::get('/edit-user/{id}', [BotusersAdminPanel::class, 'editUser'])->name('user.edit');
Route::get('/edit-msg/{id}', [BotusersAdminPanel::class, 'editMessage'])->name('message.edit');
Route::delete('/delete-msg/{id}', [BotusersAdminPanel::class, 'deleteMsg'])->name('message.delete');
Route::put('/update-msg', [BotusersAdminPanel::class, 'updateMsg'])->name('message.update');
Route::put('/update-user', [BotusersAdminPanel::class, 'updateUser'])->name('users.update');

Route::post('/store-photo', [BotusersAdminPanel::class, 'storePhoto'])->name('users.photo');

