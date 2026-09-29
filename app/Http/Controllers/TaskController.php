<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;

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
}
