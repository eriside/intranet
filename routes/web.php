<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Middleware\LogIpMiddleware;

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




Route::get('/pages/pages/Verwaltungsbereich/Scripts/stempeluhr.php', function () {
    $query = request()->getQueryString();
    error_log('fotze');
    return redirect()->away('https://intranet.berufsfeuerwehrrheinstadt.de/pages/pages/Verwaltungsbereich/Scripts/stempeluhr.php' . ($query ? '?' . $query : ''));
});

Route::get('/stempeluhr/{id?}/{id2?}', [\App\Http\Controllers\stemepluhr::class, 'handletimer']);
Route::get('/stempeluh/wegmitalle', [\App\Http\Controllers\stemepluhr::class, 'wegmitalle']);




Route::middleware(['auth', LogIpMiddleware::class])->group(function () {
    Route::get('/', function (){
        return view('intranet.main');
    });
    Route::get('/intranet', function () {
        return view('intranet.main');
    });
    Route::get('/intranet/todo', [\App\Http\Controllers\intranet::class, 'todo']);
    Route::get('/intranet/changelog', [\App\Http\Controllers\intranet::class, 'changelog']);
    Route::post('/intranet/changelog/new', [\App\Http\Controllers\intranet::class, 'changelognew']);
    Route::post('/intranet/todo/new', [\App\Http\Controllers\intranet::class, 'todonew']);
    Route::post('/intranet/todo/delete/{id?}', [\App\Http\Controllers\intranet::class, 'tododelete']);
    Route::post('/intranet/todo/update/{id?}', [\App\Http\Controllers\intranet::class, 'todoupdate']);
    Route::post('/intranet/todo/reorder', [\App\Http\Controllers\intranet::class, 'todoreorder']);
    Route::get('/intranet/admin/berechtigungen', [\App\Http\Controllers\intranet::class, 'berechtigungen']);
    Route::post('/intranet/admin/berechtigung/edit/{id?}', [\App\Http\Controllers\intranet::class, 'edituserroles']);
    Route::get('/intranet/admin/raenge', [\App\Http\Controllers\intranet::class, 'raenge']);
    Route::get('/intranet/admin/stempeluhr', [\App\Http\Controllers\stemepluhr::class, 'log']);
    Route::get('/intranet/admin/rollen', [\App\Http\Controllers\roles::class, 'rollen']);
    Route::get('/intranet/verwaltung/eingestempelt', [\App\Http\Controllers\stemepluhr::class, 'eingestempelt']);
    Route::get('/intranet/admin/dokumententyp', [\App\Http\Controllers\intranet::class, 'dokumententyp']);
    Route::get('/intranet/verwaltung/mitarbeiter', [\App\Http\Controllers\mitarbeiter::class, 'mitarbeiter']);
    Route::get('/intranet/verwaltung/mitarbeiter/archiv', [\App\Http\Controllers\mitarbeiter::class, 'archiv']);
    Route::get('/intranet/verwaltung/mitarbeiter/inaktiv', [\App\Http\Controllers\mitarbeiter::class, 'inaktiv']);
    Route::get('/intranet/verwaltung/mitarbeiter/view/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'view']);
    Route::get('/intranet/verwaltung/mitarbeiter/dokument/download/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'downloaddokument']);
    Route::get('/intranet/verwaltung/mitarbeiter/edit/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'edit']);
    Route::get('/intranet/verwaltung/mitarbeiter/new', [\App\Http\Controllers\mitarbeiter::class, 'new']);
    Route::get('/intranet/kats/mitarbeiter', [\App\Http\Controllers\mitarbeiterkats::class, 'mitarbeiter']);
    Route::get('/intranet/kats/mitarbeiter/view/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'view']);
    Route::get('/intranet/kats/mitarbeiter/dokument/download/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'downloaddokument']);
    Route::get('/intranet/kats/mitarbeiter/edit/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'edit']);
    Route::get('/intranet/kats/mitarbeiter/new', [\App\Http\Controllers\mitarbeiterkats::class, 'new']);
    Route::get('/intranet/verwaltung/befoerderung/', [\App\Http\Controllers\mitarbeiter::class, 'bef']);
    Route::get('/landesschule/ausbildungen/', [\App\Http\Controllers\landesschule::class, 'ausbildungen']);
    Route::get('/landesschule/ausbildungen/new', [\App\Http\Controllers\landesschule::class, 'newausbildungen']);
    Route::get('/landesschule/ausbildungen/edit/{id?}', [\App\Http\Controllers\landesschule::class, 'editausbildungen']);
    Route::get('/landesschule/ausbildungen/delete/{id?}', [\App\Http\Controllers\landesschule::class, 'deleteausbildungen']);
    Route::get('/landesschule/ausbilder/', [\App\Http\Controllers\landesschule::class, 'ausbilder']);
    Route::get('/landesschule/ausbilder/new', [\App\Http\Controllers\landesschule::class, 'newausbilder']);
    Route::get('/landesschule/ausbilder/edit/{id?}', [\App\Http\Controllers\landesschule::class, 'editausbilder']);
    Route::get('/landesschule/ausbilder/delete/{id?}', [\App\Http\Controllers\landesschule::class, 'deleteausbilder']);
    Route::get('landesschule/ausbildungsangebote', [\App\Http\Controllers\landesschule::class, 'allausbildungsangebote']);
    Route::get('landesschule/zeugnisse', [\App\Http\Controllers\landesschule::class, 'zeugnisse']);
    Route::get('/landesschule/ausbildungsangebote/view/{id?}', [\App\Http\Controllers\landesschule::class, 'viewausbildungsangebot']);
    Route::get('/landesschule/ausbildungsangebote/pass/{id?}/{id2?}', [\App\Http\Controllers\landesschule::class, 'pass']);
    Route::get('/landesschule/ausbildungsangebote/fail/{id?}/{id2?}', [\App\Http\Controllers\landesschule::class, 'fail']);
    Route::get('/landesschule/sign/', [\App\Http\Controllers\landesschule::class, 'sign']);
    Route::get('/landesschule/zeugnis/create/', [\App\Http\Controllers\landesschule::class, 'createZeugnis']);

});
Route::middleware([LogIpMiddleware::class])->group(function () {
    Route::get('/intranet/mitarbeiter/addurlaub', [\App\Http\Controllers\mitarbeiter::class, 'addurlaub']);
    Route::get('landesschule/get/ausbildungen', [\App\Http\Controllers\landesschule::class, 'getausbildungen']);
    Route::get('landesschule/upload/zeugniss', [\App\Http\Controllers\landesschule::class, 'upload']);
    Route::get('landesschule/ausbildungsangebot/create', [\App\Http\Controllers\landesschule::class, 'createausbildungsangebot']);
    Route::get('landesschule/ausbildungsangebot/close', [\App\Http\Controllers\landesschule::class, 'closeausbildungsangebot']);
    Route::get('landesschule/ausbildungsangebot/adduser', [\App\Http\Controllers\landesschule::class, 'adduserausbildungsangebot']);
    Route::get('/intranet/verwaltung/befoerderung/new', [\App\Http\Controllers\mitarbeiter::class, 'befnew']);
    Route::get('/intranet/verwaltung/mitarbeiter/dokument/view/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'viewdokument']);
    Route::get('/file/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'viewdoc']);
    Route::get('/intranet/create/arbeitsvertrag/', [\App\Http\Controllers\filecreate::class, 'generiereVertrag']);
    Route::get('/intranet/create/einstellung/', [\App\Http\Controllers\filecreate::class, 'einstellung']);
    Route::get('/intranet/get/freie_dienstnummer/', [\App\Http\Controllers\filecreate::class, 'freie_dienstnummer']);
    Route::get('/intranet/create/arbeitsvertragohne/', [\App\Http\Controllers\filecreate::class, 'generiereVertragohne']);
    Route::get('/intranet/create/notarztvertrag/', [\App\Http\Controllers\filecreate::class, 'navertrag']);
    Route::get('/intranet/create/notarztvertragohne/', [\App\Http\Controllers\filecreate::class, 'navertragohne']);
    Route::get('/intranet/create/aufhebungohne/', [\App\Http\Controllers\filecreate::class, 'aufhebungohne']);
    Route::get('/intranet/create/aufhebung/', [\App\Http\Controllers\filecreate::class, 'aufhebung']);
    Route::get('/intranet/create/kundigung/', [\App\Http\Controllers\filecreate::class, 'kundigung']);
    Route::get('/intranet/create/kundigungohne/', [\App\Http\Controllers\filecreate::class, 'kundigungohne']);
    Route::get('/intranet/create/fristloskundigung/', [\App\Http\Controllers\filecreate::class, 'fristloskundigung']);
    Route::get('/intranet/create/fristloskundigungohne/', [\App\Http\Controllers\filecreate::class, 'fristloskundigungohne']);
    Route::get('/intranet/create/befoerderung', [\App\Http\Controllers\filecreate::class, 'befoerderung']);
    Route::get('/intranet/create/degradierung', [\App\Http\Controllers\filecreate::class, 'degradierung']);
    Route::get('/intranet/create/zweitjobohne', [\App\Http\Controllers\filecreate::class, 'zweitjobohne']);
    Route::get('/intranet/create/zweitjob', [\App\Http\Controllers\filecreate::class, 'zweitjob']);
    Route::get('/intranet/create/abmahnungohne', [\App\Http\Controllers\filecreate::class, 'abmahnungohne']);
    Route::get('/intranet/create/abmahnung', [\App\Http\Controllers\filecreate::class, 'abmahnung']);
    Route::get('/intranet/get/raenge', [\App\Http\Controllers\filecreate::class, 'getraenge']);
    Route::get('/lager/log/{id?}/{id2?}/{id3?}', [\App\Http\Controllers\stemepluhr::class, 'logg']);
    Route::get('/intranet/get/genehmigung', [\App\Http\Controllers\filecreate::class, 'getgenehmigung']);
    Route::post('/intranet/admin/raenge/new', [\App\Http\Controllers\intranet::class, 'raengenew']);
    Route::post('/intranet/admin/raenge/edit/{id?}', [\App\Http\Controllers\intranet::class, 'editraenge']);
    Route::post('/intranet/admin/raenge/delete/{id?}', [\App\Http\Controllers\intranet::class, 'deleteraenge']);
    Route::post('/intranet/admin/dokumententyp/new', [\App\Http\Controllers\intranet::class, 'dokumententypnew']);
    Route::post('/intranet/admin/dokumententyp/edit/{id?}', [\App\Http\Controllers\intranet::class, 'editdokumententyp']);
    Route::post('/intranet/admin/dokumententyp/delete/{id?}', [\App\Http\Controllers\intranet::class, 'deletedokumententyp']);
    Route::get('/intranet/admin/berechtigung/adduser/', [\App\Http\Controllers\intranet::class, 'adduser']);
    Route::post('/intranet/verwaltung/mitarbeiter/eintrag/new/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'neweintrag']);
    Route::post('/intranet/verwaltung/mitarbeiter/eintrag/delete/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'deleteeintrag']);
    Route::post('/intranet/verwaltung/mitarbeiter/eintrag/edit/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'editeintrag']);
    Route::post('/intranet/verwaltung/mitarbeiter/dokument/new/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'newdokument']);
    Route::post('/intranet/verwaltung/mitarbeiter/dokument/delete/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'deletedokument']);
    Route::post('/intranet/kats/mitarbeiter/dokument/new/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'newdokument']);
    Route::post('/intranet/kats/mitarbeiter/dokument/delete/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'deletedokument']);
    Route::get('/intranet/verwaltung/mitarbeiter/newm', [\App\Http\Controllers\mitarbeiter::class, 'newm']);
    Route::post('/intranet/verwaltung/mitarbeiter/delete/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'deletem']);
    Route::post('/intranet/verwaltung/mitarbeiter/edit/change/{id?}', [\App\Http\Controllers\mitarbeiter::class, 'change']);
    Route::get('/intranet/kats/mitarbeiter/newm', [\App\Http\Controllers\mitarbeiterkats::class, 'newm']);
    Route::post('/intranet/kats/mitarbeiter/delete/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'deletem']);
    Route::post('/intranet/kats/mitarbeiter/edit/change/{id?}', [\App\Http\Controllers\mitarbeiterkats::class, 'change']);
    Route::post('/intranet/todo/new', [\App\Http\Controllers\intranet::class, 'todonew']);
    Route::get('/intranet/kats/vertrag', [\App\Http\Controllers\mitarbeiterkats::class, 'vertrag']);
    //Route::get('/leitung', [\App\Http\Controllers\homeController::class, 'leitung']);
    //Route::get('/fuhrpark', [\App\Http\Controllers\homeController::class, 'fuhrpark']);
    //Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
    //Route::get('/dashboard/leitung', [\App\Http\Controllers\DashboardController::class, 'leitung'])->middleware(['auth'])->name('dashboard');
    //Route::get('/dashboard/fuhrpark', [\App\Http\Controllers\DashboardController::class, 'fuhrpark'])->middleware(['auth'])->name('dashboard');
    //Route::post('/dashboard/fuhrpark/edit/{id?}', [\App\Http\Controllers\DashboardController::class, 'editFuhrpark'], $id = null);
    //Route::post('/dashboard/fuhrpark/delete/{id?}', [\App\Http\Controllers\DashboardController::class, 'deleteFuhrpark'], $id = null);
    //Route::post('/dashboard/fuhrpark/new', [\App\Http\Controllers\DashboardController::class, 'newFahrzeug']);
    //Route::get('/dashboard/berichte', [\App\Http\Controllers\DashboardController::class, 'berichte'])->middleware(['auth'])->name('dashboard');
    //Route::post('/dashboard/berichte/new/', [\App\Http\Controllers\DashboardController::class, 'newBerichte']);
    //Route::post('/dashboard/berichte/newFahrzeug/', [\App\Http\Controllers\DashboardController::class, 'newBerichteFahrzeug']);
    //Route::post('/dashboard/berichte/deleteFahrzeug/{id?}', [\App\Http\Controllers\DashboardController::class, 'deleteBerichteFahrzeug'], $id = null);
    //Route::post('/dashboard/berichte/deleteBericht/{id?}', [\App\Http\Controllers\DashboardController::class, 'deleteBerichte'], $id = null);
    //Route::post('/dashboard/leitung/new', [\App\Http\Controllers\DashboardController::class, 'newLeitung']);
    //Route::post('/dashboard/leitung/delete/{id?}', [\App\Http\Controllers\DashboardController::class, 'deleteLeitung'], $id = null);
    //Route::post('/dashboard/leitung/edit/{id?}', [\App\Http\Controllers\DashboardController::class, 'editLeitung'], $id = null);
    Route::get('image/{filename}', [\App\Http\Controllers\DashboardController::class, 'displayImage'])->name('image.displayImage');
    Route::get('/intranet/admin/rollen/addrole/', [\App\Http\Controllers\roles::class, 'addrole']);
    Route::get('/intranet/admin/rollen/update/{id?}', [\App\Http\Controllers\roles::class,'editrole']);
    Route::get('/intranet/admin/rollen/delete/{id?}', [\App\Http\Controllers\roles::class,'deleterole']);
});


