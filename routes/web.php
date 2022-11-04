
<?php

use App\Models\Facturation\Catalogue;
use Illuminate\Support\Facades\Auth;
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
Route::group(['middleware' => 'preventBackHistory'],function(){


    Auth::routes();

    Route::view('/', 'auth.login');

    // Route::view('home', 'dashboard');


    Route::middleware(['auth'])->group(function () {
        // GESTION ACCES
        Route::resource('permissions', '\App\Http\Controllers\Securite\PermissionController');
        Route::resource('users', '\App\Http\Controllers\Securite\UserController');
        Route::resource('interim', '\App\Http\Controllers\Securite\InterimController');
        Route::resource('catalogue', '\App\Http\Controllers\Facturation\CatalogueController'); 
        Route::resource('facturation_envalidation', '\App\Http\Controllers\Facturation\FacturationValidationController');
        Route::post('facturation_envalidation/search', '\App\Http\Controllers\Facturation\FacturationValidationController@search')->name('facturation_envalidation.search');
        Route::post('facturation_envalidation/rejet', '\App\Http\Controllers\Facturation\FacturationValidationController@rejet')->name('facturation_envalidation.rejet');

        Route::resource('facturation_valide', '\App\Http\Controllers\Facturation\FacturationValideController');
        Route::post('facturation_valide/search', '\App\Http\Controllers\Facturation\FacturationValideController@search')->name('facturation_valide.search');

        Route::resource('facturation_rejetee', '\App\Http\Controllers\Facturation\FacturationRejeteController');
        Route::resource('recyclage_uv', '\App\Http\Controllers\Facturation\RecyclageUVController');
        Route::resource('hors_catalogue', '\App\Http\Controllers\Facturation\HorsCatalogueController');

        Route::post('facturation_valide/export_pdf', '\App\Http\Controllers\Facturation\FacturationValideController@export_pdf')->name('facturation_valide.export_pdf');

        // Download C2C ET OW
        Route::get('download_file_action','ExportFile@download_file_action');
        Route::get('download_zip_file_action','ExportFile@download_zip_file_action');

        // user status update
        Route::get('user/update-status', '\App\Http\Controllers\Securite\UserController@updateStatus')->name('update.user.status');
        Route::resource('roles', '\App\Http\Controllers\Securite\RoleController');

        // Structure OFMS
        Route::resource('structures', '\App\Http\Controllers\StructureOFMS\StructureController');

        ////////////////////////////////////////////SECURITE////////////////////////////////////////////////

        // Tracking routes
        Route::resource('trackings', '\App\Http\Controllers\Securite\TrackingController');

        // Render perticular view file by foldername and filename and all passed in only one controller at a time
        Route::get('{folder}/{file}', 'MetricaController@indexWithOneFolder');
        // Render when Route Have 2 folder
        Route::get('{folder1}/{folder2}/{file}', 'MetricaController@indexWithTwoFolder');
        Route::get('/logout', 'MetricaController@logout');
    });
});
