<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        $query = Task::query();

        if($req->status) {
            $query->where('status', $req->status);
        }

        if($req->due_date) {
            $query->whereDate('due_date', $req->due_date);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
         $request->validate([
        'title' => 'required|max:50',
        'description' => 'nullable|max:300',
        'status' => 'required|in:pending,in_progress,completed',
        'due_date' => 'nullable|date|after_or_equal:today',
    ]);

        Task::create($request->all());

        return redirect('/tasks')->with('success','Task Created');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
        'title' => 'required|max:50',
        'description' => 'nullable|max:300',
        'status' => 'required|in:pending,in_progress,completed',
        'due_date' => 'nullable|date|after_or_equal:today',
    ]);

        $task->update($request->all());

        return redirect('/tasks')->with('success','Task Updated');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success','Task Deleted');
    }
}