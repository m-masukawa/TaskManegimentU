<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        // is_admin が true
        if ($request->user()->is_admin) {
            // 管理者用
            $query = Task::query();
        } else {
            // 一般ユーザーの場合は、自分のタスクだけを対象にする
            $query = $request->user()->tasks();
        }

        // 2. キーワード検索（タスクのタイトル・説明 ＋ ユーザー名も対象に！）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                // ① タスクのタイトルで検索
                $q->where('title', 'like', '%' . $keyword . '%')
                    // ② タスクの詳細説明で検索
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    // ③ リレーション先（usersテーブル）のnameで検索
                    ->orWhereHas('user', function ($userQuery) use ($keyword) {
                        $userQuery->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // 絞り込み
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 並び替え
        $tasks = $query->latest()
            ->paginate(10)
            // クエリパラメータ維持のため withQueryString()
            ->withQueryString();

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
