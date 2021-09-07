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
    


// Roles 
    Route::group(['middleware' => 'roles_permission:Users,view' ], function() {
        Route::get('/user-roles', [App\Http\Controllers\RoleController::class, 'index'])->name('user-roles')->middleware('roles_permission:Users,read');
        Route::get('/system-users', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('roles_permission:Users,read');
        Route::post('/save-user', [App\Http\Controllers\UserController::class, 'saveUser'])->name('save-user')->middleware('roles_permission:Users,create');
        Route::post('/delete-user', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('delete-user')->middleware('roles_permission:Users,delete');
    });

// Dashboard 
    Route::group(['middleware' => 'roles_permission:Dashboard,view' ], function() {
        Route::get('/dashboard-cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'getCSOIndicatorListDashboard'])->name('dashboard-cso-indicator')->middleware('roles_permission:Dashboard,view');
        Route::get('/dashboard-cso-profile', [App\Http\Controllers\CSOProfileController::class, 'getCSOProfile'])->name('dashboard-cso-profile')->middleware('roles_permission:Dashboard,view');
    });
    
    
// CSO2 INDICATOR
    Route::group(['middleware' => 'roles_permission:CSOIndicator,view' ], function() {
        Route::get('/cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'getCSOIndicator'])->name('cso-indicator')->middleware('roles_permission:CSOIndicator,view');
        Route::post('/cso-indicator-list', [App\Http\Controllers\CSOIndicatorController::class, 'getCSOIndicatorList'])->name('cso-indicator-list')->middleware('roles_permission:CSOIndicator,view');
        Route::post('/save-cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'saveCSOIndicator'])->name('save-cso-indicator')->middleware('roles_permission:CSOIndicator,create');
        Route::post('/save-cso-indicator-details', [App\Http\Controllers\CSOIndicatorController::class, 'saveCSOIndicatorDetails'])->name('save-cso-indicator-details')->middleware('roles_permission:CSOIndicator,create');
        Route::post('/delete-cso-indicator', [App\Http\Controllers\CSOIndicatorController::class, 'deleteCSOIndicator'])->name('delete-cso-indicator')->middleware('roles_permission:CSOIndicator,delete');
        Route::post('/delete-cso-indicator-details', [App\Http\Controllers\CSOIndicatorController::class, 'deleteCSOIndicatorDetails'])->name('delete-cso-indicator-details')->middleware('roles_permission:CSOIndicator,delete');
        Route::get('/downloadMov', [App\Http\Controllers\CSOIndicatorController::class, 'downloadMov'])->name('downloadMov')->middleware('roles_permission:CSOIndicator,download');
        Route::get('/downloadCSOMov', [App\Http\Controllers\CSOIndicatorController::class, 'downloadCSOMov'])->name('downloadCSOMov')->middleware('roles_permission:CSOIndicator,download');

    });

// CSO PROFILE
    Route::group(['middleware' => 'roles_permission:CSOProfile,view' ], function() {
        Route::get('/cso-profile', [App\Http\Controllers\CSOProfileController::class, 'getCSOProfile'])->name('cso-profile')->middleware('roles_permission:CSOProfile,view');
        Route::get('/cso-name-list', [App\Http\Controllers\CSOProfileController::class, 'getCSONameList'])->name('cso-name-list')->middleware('roles_permission:CSOProfile,view');
        Route::post('/save-cso-profile', [App\Http\Controllers\CSOProfileController::class,'saveCSOProfile'])->name('save-cso-profile')->middleware('roles_permission:CSOProfile,create');
        Route::post('/delete-cso-profile', [App\Http\Controllers\CSOProfileController::class,'deleteCSOProfile'])->name('delete-cso-profile')->middleware('roles_permission:CSOProfile,delete');
    }); 
// LRO ASSESSMENT
    Route::group(['middleware' => 'roles_permission:Assessment,view' ], function() {
        Route::get('/lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'getLROAssessment'])->name('lro-assessment')->middleware('roles_permission:Assessment,view');
        Route::post('/save-lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'saveLROAssessment'])->name('save-lro-assessment')->middleware('roles_permission:Assessment,create');
        Route::post('/delete-lro-assessment', [App\Http\Controllers\LROAssessmentController::class,'deleteLROAssessment'])->name('delete-lro-assessment')->middleware('roles_permission:Assessment,delete');
        Route::post('/save-lro-sub-assessment', [App\Http\Controllers\LROAssessmentController::class,'saveLROAssessmentSub'])->name('save-lro-sub-assessment')->middleware('roles_permission:Assessment,create');
        Route::post('/delete-lro-sub-assessment', [App\Http\Controllers\LROAssessmentController::class,'deleteLROAssessmenSub'])->name('delete-lro-sub-assessment')->middleware('roles_permission:Assessment,delete');
        Route::get('/downloadAssessMov', [App\Http\Controllers\LROAssessmentController::class, 'downloadMov'])->name('downloadAssessMov')->middleware('roles_permission:Assessment,download');
    });
// FINANCE TRACKER
    Route::group(['middleware' => 'roles_permission:FinanceTracker,view' ], function() {
        Route::get('/finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'getFinanceTracker'])->name('finance-tracker')->middleware('roles_permission:FinanceTracker,view');
        Route::post('/save-finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'saveFinanceTracker'])->name('save-finance-tracker')->middleware('roles_permission:FinanceTracker,create');
        Route::post('/delete-finance-tracker', [App\Http\Controllers\FinanceTrackerController::class,'deleteFinanceTracker'])->name('delete-finance-tracker')->middleware('roles_permission:FinanceTracker,delete');
    });
// PROJECT DOCUMENT
    Route::group(['middleware' => 'roles_permission:ProjectTrackingDocuments,view' ], function() {
        Route::get('/document', [App\Http\Controllers\ProjectDocumentController::class,'getDocument'])->name('document')->middleware('roles_permission:ProjectTrackingDocuments,view');
        Route::post('/save-document', [App\Http\Controllers\ProjectDocumentController::class,'saveDocument'])->name('save-document')->middleware('roles_permission:ProjectTrackingDocuments,create');
        Route::post('/delete-document', [App\Http\Controllers\ProjectDocumentController::class,'deleteDocument'])->name('delete-document')->middleware('roles_permission:ProjectTrackingDocuments,delete');
        Route::get('/get-project-tracking-document', [App\Http\Controllers\ProjectDocumentController::class,'getProjectTrackingDocument'])->name('get-project-tracking-document')->middleware('roles_permission:ProjectTrackingDocuments,view');
        Route::post('/save-project-tracking-document', [App\Http\Controllers\ProjectDocumentController::class,'saveProjectTrackingDocument'])->name('save-project-tracking-document')->middleware('roles_permission:ProjectTrackingDocuments,create');
    });

// LMS
    Route::group(['middleware' => 'roles_permission:LMS,view' ], function() {
        Route::get('/participants-profile', [App\Http\Controllers\LMSController::class,'getParticipantsProfile'])->name('participants-profile')->middleware('roles_permission:LMS,view');
        Route::post('/save-participants-profile', [App\Http\Controllers\LMSController::class,'saveParticipantsProfile'])->name('save-participants-profile')->middleware('roles_permission:LMS,create');
        Route::post('/delete-participants-profile', [App\Http\Controllers\LMSController::class,'deleteParticipantsProfile'])->name('delete-participants-profile')->middleware('roles_permission:LMS,delete');

        Route::get('/courses', [App\Http\Controllers\LMSController::class,'getCourses'])->name('courses')->middleware('roles_permission:LMS,view');
        Route::post('/save-courses', [App\Http\Controllers\LMSController::class,'saveCourses'])->name('save-courses')->middleware('roles_permission:LMS,save');
        Route::post('/delete-courses', [App\Http\Controllers\LMSController::class,'deleteCourses'])->name('delete-courses')->middleware('roles_permission:LMS,delete');

        Route::get('/training-attendees', [App\Http\Controllers\LMSController::class,'getTrainingAttendees'])->name('training-attendees')->middleware('roles_permission:LMS,view');
        Route::post('/save-training-attendees', [App\Http\Controllers\LMSController::class,'saveTrainingAttendees'])->name('save-training-attendees')->middleware('roles_permission:LMS,save');
        Route::post('/delete-training-attendees', [App\Http\Controllers\LMSController::class,'deleteTrainingAttendees'])->name('delete-training-attendees')->middleware('roles_permission:LMS,delete');
    });
// COMMON
    Route::get('/lro-status', [App\Http\Controllers\commonController::class,'getLROStatus'])->name('lro-status');
    Route::get('/document-type', [App\Http\Controllers\commonController::class,'getDocumentType'])->name('document-type');
    Route::get('/document-owner', [App\Http\Controllers\commonController::class,'getDocumentOwner'])->name('document-owner');
    Route::get('/user-roles-permission', [App\Http\Controllers\RoleController::class, 'getUserRolesPermission'])->name('user-roles-permission');
    Route::get('/get-categories', [App\Http\Controllers\commonController::class,'getCategories'])->name('get-categories');
    Route::get('/get-indicator-type', [App\Http\Controllers\commonController::class,'getIndicatorType'])->name('get-indicator-type');
    Route::get('/get-indicator-status', [App\Http\Controllers\commonController::class,'getIndicatorStatus'])->name('get-indicator-status');
    Route::get('/get-frequencies', [App\Http\Controllers\commonController::class,'getFrequencies'])->name('get-frequencies');
    Route::get('/get-participants', [App\Http\Controllers\commonController::class,'getParticipants'])->name('get-participants');
    Route::get('/get-courses', [App\Http\Controllers\commonController::class,'getCourses'])->name('get-courses');
    Route::post('/export-excel', [App\Http\Controllers\commonController::class,'exportExcel'])->name('export-excel');
    Route::get('/get-lead-organization', [App\Http\Controllers\commonController::class,'getLeadOrgs'])->name('get-lead-organization');

});

Route::get('/download/{file}', function ($file='') {
    return response()->download(storage_path('app/public/'.$file));
});
