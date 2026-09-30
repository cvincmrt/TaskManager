<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // $tasks = Task::all(); kvoli relacii pouzijeme with() a nie all()

        $tasks = Task::with(['creator', 'assignee'])->get();

        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        // mame $task, ale nemame autora a ani riesitela potrebujeme dotahat relacie

        $task->load(['creator', 'assignee']);

        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        $users = User::all();

        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'deadline' => 'required|date',
        ]);

        // nemama este prihlasenie tak pouyijem prveho uzivatela z databazy

        $validated['creator_id'] = User::first()->id;

        // ulozenie do databazy

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Uloha bola vytvorena!');

    }

    public function edit(Task $task)
    {
        $users = User::all();

        return view('tasks.edit', compact('task', 'users'));
    }
}
