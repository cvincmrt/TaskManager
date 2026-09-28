<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        // $tasks = Task::all(); kvoli relaci pouzijeme with() a nie all()
        
        $tasks = Task::with(['creator', 'assignee'])->get();

        return view('tasks.index', compact('tasks'));
    }
}
