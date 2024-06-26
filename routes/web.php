<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\RawDBController;
use App\Http\Controllers\SteamGamesController;
use App\Http\Controllers\SteamLibraryController;
use App\Http\Controllers\CSVReader_SteamFillable;
use App\Http\Controllers\CSVReader_PurchaseRecords;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DebugPage; 

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/csrf-token', function (Request $request) {
    return response()->json(['_token' => csrf_token()]);
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

    
Route::resource('db_backup', RawDBController::class) // renamed from rawdb
    ->only(['index'])
    ->middleware(['auth', 'verified']); // so that this is not so easily accessible

// Route::resource('steamlib', SteamGameController::class)
//     ->only(['index', 'store', 'update'])
//     ->middleware(['auth', 'verified']);

Route::resource('steamlib', SteamLibraryController::class)
    ->only(['index', 'update'])
    ->middleware(['auth', 'verified']);

Route::get('games/{game:appid}', [SteamGamesController::class, 'show'])
     ->middleware(['auth', 'verified']);

Route::resource('games', SteamGamesController::class)
    ->middleware(['auth', 'verified']);

Route::get('/refreshsteamlib', [SteamLibraryController::class, 'updateLibraryThroughLink']);

Route::resource('csv/fillables', CSVReader_SteamFillable::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

Route::resource('csv/purchases', CSVReader_PurchaseRecords::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);
    
// for debugging
Route::get('/debug', [DebugPage::class, 'debugCheck']);


require __DIR__.'/auth.php';
