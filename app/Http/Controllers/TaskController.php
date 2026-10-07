<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // 1. Začneme pripravovať dotaz (ešte sa nespúšťa do DB)
        $query = Task::with(['creator', 'assignee'])->latest();

        // 2. Ak používateľ vybral status, pridáme podmienku WHERE
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //dalsi filter zalozky $request->view Vsetko co je za otaznikom viem k tomu pristupit cez -> napr. /tasks?view=created
        if($request->view === 'created')
        {
            $query->createdBy(auth()->id());
        }elseif($request->view === 'assigned')
            {
                $query->assignedTo(auth()->id());
            }


        // 3. Spustíme stránkovanie a pridáme kúzlo withQueryString()
        $tasks = $query->paginate(5)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }


    public function show(Task $task)
    {
        // mame $task, ale nemame autora a ani riesitela potrebujeme dotahat relacie

        $task->load(['creator', 'assignee', 'comments.user']);

        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        $users = User::all();

        return view('tasks.create', compact('users'));
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        // nemama este prihlasenie tak pouyijem prveho uzivatela z databazy

        $validated['creator_id'] = auth()->id();

        // ulozenie do databazy

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Uloha bola vytvorena!');

    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        $users = User::all();

        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Uloha uspesne upravena!!!');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Uloha bola zmazana!!!!');
    }

    public function changeStatus(Request $request, Task $task)
    {
        Gate::authorize('changeStatus', $task);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return back()->with('success', 'Stav ulohy bol aktualizovany!!!');
    }

    public function assign(Task $task)
    {
        Gate::authorize('assign', $task);

        $task->update([
            'assigned_to_id' => auth()->id(),
        ]);

        return back()->with('success', 'Uloha ti bola uspesne pridelena!!!');
    }
}
