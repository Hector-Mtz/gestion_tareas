<?php

use App\Http\Controllers\TareaController;
use App\Models\statu;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () 
{

    return Inertia::render('Auth/Login', 
    [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () 
{

    Route::get('/dashboard', function () 
    {   $status = statu::all();
        return Inertia::render('Dashboard',[
            'status' => $status
        ]);
    })->name('dashboard');

    //route to create task
    Route::post('/newTask',[TareaController::class,'store'])->name('saveTask');
    //route to get tasks
    Route::get('/getTasks',[TareaController::class,'index'])->name('getTasks');
    //delete tasks
    Route::post('/deleteTasks',[TareaController::class,'destroy'])->name('deleteTasks');
    //edit tasks
    Route::post('/saveEditTask',[TareaController::class,'update'])->name('saveEditTask');
});
