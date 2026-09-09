<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{

    public function addTaskToFavorite($taskId) {

        Task::findOrFail($taskId) ; 
        Auth::user()->favoritestasks()->syncWithoutDetaching($taskId) ; 
        return response()->json(['message'=>'task added to favorite'] ,200) ; 
    }

    public function removeTaskToFavorite($taskId) {

        Task::findOrFail($taskId) ; 
        Auth::user()->favoritestasks()->detach($taskId) ; 
        return response()->json(['message'=>'task remove from favorite'] ,200) ; 
    }




    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json($tasks, 200);
    }


    public function getUserTaskpriority(Request $request)
    {
        $typeOrder = $request->query('sort')  ; 

        if($typeOrder === 'up')$typeOrder = 'asc' ; 
        else if($typeOrder === 'down')$typeOrder = 'desc' ; 
       
        $tasks = Auth::user()->tasks()
            ->orderByRaw("FIELD(priority, 'high', 'mid', 'low') {$typeOrder}")
            ->get();

        return response()->json($tasks, 200);
    }

    public function store(StoreTaskRequest $request){
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;

        $task = Task::create($validatedData);
        return response()->json(['message' => "Successfully created!", 'task' => $task], 201);
    }


    public function show(int $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);

        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($task, 200);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id); // التأكد من وجود المهمة

        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->update($request->validated());

        return response()->json($task, 200);
    }


    public function destroy(int $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);

        if ($task->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(null, 204);
    }

    // جلب المستخدم المرتبط بمهمة معينة
    public function getTaskUser(int $id)
    {

        $task = Task::findOrFail($id);
        return response()->json($task->user, 200);
    }


    public function addCategoryToTask(Request $request, int $taskId)
    {

        $task = Task::findOrFail($taskId);

        $categoryId = $request->input('category_id');

        Category::findOrFail($categoryId);

        $task->categories()->syncWithoutDetaching($categoryId);

        return response()->json(['message' => 'Category attached successfully'], 200);
    }

    // جلب جميع التصنيفات المرتبطة بمهمة
    public function getCategoriesTask(int $id)
    {
        $task = Task::findOrFail($id);
        return response()->json([
            'categories' => $task->categories
        ], 200);
    }

    // جلب جميع المهام المرتبطة بتصنيف معين
    public function getTasksCategory(int $id){
        $category = Category::findOrFail($id);
        return response()->json([
            'tasks' => $category->tasks
        ], 200);
    }

    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }
}
