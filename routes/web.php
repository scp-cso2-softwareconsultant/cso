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

Auth::routes();

Route::group(['middleware'=> ['auth']], function (){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/system-users', [App\Http\Controllers\UserController::class, 'index'])->name('user');
    Route::post('/save-user', [App\Http\Controllers\UserController::class, 'saveUser'])->name('save-user');

// Roles 
    Route::get('/user-roles', [App\Http\Controllers\RoleController::class, 'index'])->name('user-roles');

// CSO2 INDICATOR
    Route::get('/cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'getCSOIndicator'])->name('cso-indicator');
    Route::post('/cso-indicator-list', [App\Http\Controllers\CSOIndicatorController::class, 'getCSOIndicatorList'])->name('cso-indicator-list');
    Route::post('/save-cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'saveCSOIndicator'])->name('save-cso-indicator');
    Route::post('/save-cso-indicator-details', [App\Http\Controllers\CSOIndicatorController::class, 'saveCSOIndicatorDetails'])->name('save-cso-indicator-details');
    Route::post('/delete-cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'deleteCSOIndicator'])->name('delete-cso-indicator');
    Route::post('/delete-cso-indicator-details', [App\Http\Controllers\CSOIndicatorController::class, 'deleteCSOIndicatorDetails'])->name('delete-cso-indicator-details');
   
// CSO PROFILE
    Route::get('/cso-profile', [App\Http\Controllers\CSOProfileController::class, 'getCSOProfile'])->name('cso-profile');
    Route::get('/cso-name-list', [App\Http\Controllers\CSOProfileController::class, 'getCSONameList'])->name('cso-name-list');
    Route::post('/save-cso-profile', [App\Http\Controllers\CSOProfileController::class,'saveCSOProfile'])->name('save-cso-profile');
    Route::post('/delete-cso-profile', [App\Http\Controllers\CSOProfileController::class,'deleteCSOProfile'])->name('delete-cso-profile');
 
// LRO ASSESSMENT
    Route::get('/lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'getLROAssessment'])->name('lro-assessment');
    Route::post('/save-lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'saveLROAssessment'])->name('save-lro-assessment');
    Route::post('/delete-lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'deleteLROAssessment'])->name('delete-lro-assessment');

    Route::post('/save-lro-sub-assessment', [App\Http\Controllers\LROAssessmentController::class,'saveLROAssessmentSub'])->name('save-lro-sub-assessment');
    Route::post('/delete-lro-sub-assessment', [App\Http\Controllers\LROAssessmentController::class,'deleteLROAssessmenSub'])->name('delete-lro-sub-assessment');

// FINANCE TRACKER
    Route::get('/finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'getFinanceTracker'])->name('finance-tracker');
    Route::post('/save-finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'saveFinanceTracker'])->name('save-finance-tracker');
    Route::post('/delete-finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'deleteFinanceTracker'])->name('delete-finance-tracker');

// PROJECT DOCUMENT
    Route::get('/document', [App\Http\Controllers\ProjectDocumentController::class,'getDocument'])->name('document');
    Route::post('/save-document', [App\Http\Controllers\ProjectDocumentController::class,'saveDocument'])->name('save-document');
    Route::post('/delete-document', [App\Http\Controllers\ProjectDocumentController::class,'deleteDocument'])->name('delete-document');

// LMS
    Route::get('/participants-profile', [App\Http\Controllers\LMSController::class,'getParticipantsProfile'])->name('participants-profile');
    Route::post('/save-participants-profile', [App\Http\Controllers\LMSController::class,'saveParticipantsProfile'])->name('save-participants-profile');
    Route::post('/delete-participants-profile', [App\Http\Controllers\LMSController::class,'deleteParticipantsProfile'])->name('delete-participants-profile');

    Route::get('/courses', [App\Http\Controllers\LMSController::class,'getCourses'])->name('courses');
    Route::post('/save-courses', [App\Http\Controllers\LMSController::class,'saveCourses'])->name('save-courses');
    Route::post('/delete-courses', [App\Http\Controllers\LMSController::class,'deleteCourses'])->name('delete-courses');

    Route::get('/training-attendees', [App\Http\Controllers\LMSController::class,'getTrainingAttendees'])->name('training-attendees');
    Route::post('/save-training-attendees', [App\Http\Controllers\LMSController::class,'saveTrainingAttendees'])->name('save-training-attendees');
    Route::post('/delete-training-attendees', [App\Http\Controllers\LMSController::class,'deleteTrainingAttendees'])->name('delete-training-attendees');

// COMMON
    Route::get('/lro-status', [App\Http\Controllers\commonController::class,'getLROStatus'])->name('lro-status');
    Route::get('/document-type', [App\Http\Controllers\commonController::class,'getDocumentType'])->name('document-type');
    Route::get('/document-owner', [App\Http\Controllers\commonController::class,'getDocumentOwner'])->name('document-owner');
    Route::post('/get-permission', [App\Http\Controllers\commonController::class,'getPermission'])->name('get-permission');
    Route::get('/get-categories', [App\Http\Controllers\commonController::class,'getCategories'])->name('get-categories');
    Route::get('/get-indicator-type', [App\Http\Controllers\commonController::class,'getIndicatorType'])->name('get-indicator-type');
    Route::get('/get-indicator-status', [App\Http\Controllers\commonController::class,'getIndicatorStatus'])->name('get-indicator-status');
    Route::get('/get-frequencies', [App\Http\Controllers\commonController::class,'getFrequencies'])->name('get-frequencies');
    Route::get('/get-participants', [App\Http\Controllers\commonController::class,'getParticipants'])->name('get-participants');
    Route::get('/get-courses', [App\Http\Controllers\commonController::class,'getCourses'])->name('get-courses');
    Route::post('/export-excel', [App\Http\Controllers\commonController::class,'exportExcel'])->name('export-excel');

});

Route::get('/download/{file}', function ($file='') {
    return response()->download(storage_path('app/public/'.$file));
});
