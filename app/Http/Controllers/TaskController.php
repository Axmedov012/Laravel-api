<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder; // query bilder package
class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done','id') // filter lash
            ->defaultSort('-created_at') // - oxirgi ni chiqarish
            ->paginate();


        return new TaskCollection($tasks);
    }

    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();  // validate qilish
        $task = Auth::user()->tasks()->create($validated); // Userning validate dan o'tgan  request ni yaratish
        return new TaskResource($task); // Yangi TaskResource qaytarish
    }

    public function update(UpdateTaskRequest $request,Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return new TaskResource($task);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
