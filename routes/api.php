<?php

use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\API\ExameController;
use App\Http\Controllers\API\LeactureController;
use App\Http\Controllers\API\PdfController;
use App\Http\Controllers\API\RecordController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SkillController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\SuportController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\API\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


    Route::controller(SkillController::class)->group(function(){
        Route::get('skill', 'index');
        Route::post('add-skill', 'store');
    });

    Route::controller(CountryController::class)->group(function(){
        Route::get('country', 'index');
        Route::post('add-country', 'store');
    });

    Route::controller(RegisterController::class)->group(function(){
        // Route::get('country', 'index');
        Route::post('register-teacher', 'registerTeacher');
        Route::post('verfiy-teacher','teacherVerifyOTP');
        Route::post('email-teacher', 'teacherEmail');
        Route::post('login-teacher', 'loginTeacher');
        Route::post('register-student', 'registerStudent');
        Route::post('email-student','studentEmail');
        Route::post('verfiy-student',  'studentVerifyOTP');
        Route::post('login-student', 'loginStudent');
    });

    Route::controller(LeactureController::class)->group(function(){
        Route::get('all-leacture', 'index');
   
    });

    Route::controller(ExameController::class)->group(function(){
        Route::get('all-exame', 'index');
   
    });
    Route::controller(TeacherController::class)->group(function(){
        Route::post('admin-check-teacher/{id}', 'adminCheckTeacher');
        Route::get('all-teacher', 'index');
        Route::delete('delete-teacher/{id}', 'destroy');
    
   
    });


    Route::controller(PdfController::class)->group(function(){
        Route::get('all-pdfs', 'index');
    });

    Route::controller(VideoController::class)->group(function(){
        Route::get('all-videos', 'index');
    });

    Route::controller(SuportController::class)->group(function(){
        // Route::get('all-suport', 'index');
        Route::post('add-suport/{id}', 'store');
    });

    Route::controller(StudentController::class)->group(function(){
        Route::get('all-student', 'index');
        Route::delete('delete-student/{id}', 'destroy');
      
    });

    Route::controller(RecordController::class)->group(function(){
        Route::get('all-courses', 'index'); 
     

    });

    Route::middleware('auth:sanctum')->controller(RegisterController::class)->group(function(){
        Route::post('change-password-teacher','changePasswordTeacher');
        Route::post('change-password-student','changePasswordStudent');

    });

    Route::middleware('auth:sanctum')->controller(LeactureController::class)->group(function(){
        Route::post('store-leacture','store');
        Route::get('teacher-leacture','getTeacherLeacture');
        Route::get('count-leacture','countLeacture');
        
    });

    Route::middleware('auth:sanctum')->controller(ExameController::class)->group(function(){
        Route::post('store-exame','store');
        Route::get('teacher-exame','getTeacherExame');
    });

    Route::middleware('auth:sanctum')->controller(PdfController::class)->group(function(){
        Route::post('store-pdf','store');
        Route::get('teacher-pdf','getTeacherPdf');
    });

    Route::middleware('auth:sanctum')->controller(VideoController::class)->group(function(){
        Route::post('store-video','store');
        Route::get('teacher-video','getTeacherVideo');
    });


    Route::middleware('auth:sanctum')->controller(TeacherController::class)->group(function(){
        Route::post('update-teacher','updateTeacher');
    });

    Route::middleware('auth:sanctum')->controller(StudentController::class)->group(function(){
        Route::post('update-student','updateStudent');
    });

    Route::middleware('auth:sanctum')->controller(RecordController::class)->group(function(){
        Route::post('follow-course/{id}','store');
        Route::post('unfollow-course/{id}','unfollow');
        Route::get('show-student-courses-record','show');
    });

    