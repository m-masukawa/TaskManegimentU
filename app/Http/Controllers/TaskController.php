<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class); // 認可

        // 一覧取得を自分のタスクだけにする
        $tasks = $request->user()
            ->tasks()
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }


    public function create()
    {
        $this->authorize('create', Task::class);

        return view('tasks.create');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Task::class); // 認可

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを登録しました。');
    }


    public function show(Task $task)
    {
        $this->authorize('view', $task); // 👈 認可チェック（他人のタスクならここで403エラーになる）

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task); // 👈 認可チェック

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task); // 👈 認可チェック

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました。');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task); //  認可

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました。');
    }
}
