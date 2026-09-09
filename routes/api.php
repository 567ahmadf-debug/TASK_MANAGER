<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\usersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register', [usersController::class, 'register']);
Route::post('login', [usersController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {


    Route::post('logout', [usersController::class, 'logout']);


    Route::prefix('/users/{id}')->group(function () {

        Route::get('', [usersController::class, "print"]);
        Route::get('/profile', [usersController::class, "getProfile"]);
        Route::get('/tasks', [usersController::class, "getUserTask"]) ; 
        
    });

    Route::get('/tasks/ordered', [TaskController::class, "getUserTaskpriority"]);


    Route::prefix('/tasks')->group(function () {

        Route::apiResource('tasks', TaskController::class);
        Route::post('/{id}/categories', [TaskController::class, 'addCategoryToTask']);
        Route::get('/{id}/categories', [TaskController::class, 'getCategoriesTask']);
        Route::get('/all' , [TaskController::class , 'getAllTasks'])->middleware('isAdmin'); 
        Route::get('/all' , [TaskController::class , 'getAllTasks'])->middleware('ahmad'); 
        Route::post('/{id}/favorite' , [TaskController::class , 'addTaskToFavorite']); 
        Route::delete('/{id}/favorite' , [TaskController::class , 'removeTaskToFavorite']); 
        Route::get('/favorites' , [usersController::class , 'getFavoritesTasks']); 

    });

    

    // جلب مستخدم مهمة معينة
    Route::get('/tasks/{id}/user', [TaskController::class, "getTaskUser"]);

    // جلب مهام تصنيف معين
    Route::get('/categories/{id}/tasks', [TaskController::class, 'getTasksCategory']);

    // Routes الخاصة بالبروفايل (إذا كانت تحتاج مصادقة)
Route::apiResource('/profile', ProfileController::class);


});


    
