<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($tasks);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', 'in:low,medium,high,critical'],
            'status' => ['nullable' ,'in:todo,in_progress,review,done'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'assignee' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'subtasks' => ['nullable', 'array'],
            'dependencies' => ['nullable', 'array'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'project_id' => ['nullable', 'exists:projects,id'],
        ]);
       $validated['user_id'] = Auth::id();
        $task = Task::create($validated);
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }
    public function show(task $task)
    {
        $this->checkOwner('view', $task);
        return response()->json($task);
    }
    public function update(Request $request, task $task)
    {
        $this->checkOwner('update', $task);
        $validated = $request->validated([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', 'in:low,medium,high,critical'],
            'status' => ['nullable' ,'in:todo,in_progress,review,done'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'assignee' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'subtasks' => ['nullable', 'array'],
            'dependencies' => ['nullable', 'array'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'project_id' => ['nullable', 'exists:projects,id'],
        ]);
        $task->update($validated);
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task,
        ]);
    }
    public function destroy(Task $task)
    {
        $this->checkOwner($task);
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
    public function checkOwner(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
