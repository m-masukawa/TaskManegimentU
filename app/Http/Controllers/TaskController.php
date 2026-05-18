<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * 5. タスク一覧表示
     */
    public function index()
    {
        // 全件(Task::all())ではなく、ログインユーザーに紐づくタスクのみ取得
        $tasks = auth()->user()
            ->tasks()
            ->latest() // 作成日時が新しい順
            ->paginate(10); // 1ページ10件表示

        return view('tasks.index', compact('tasks'));
    }

    /**
     * 6-1. 登録画面表示
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * 6-2. 登録処理
     */
    public function store(Request $request)
    {
        // バリデーションルール
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        // ログインユーザーのタスクとして保存（user_idが自動で入る）
        auth()->user()->tasks()->create($validated);

        // 一覧画面にリダイレクト（フラッシュメッセージ付き）
        return redirect()
            ->route('tasks.index')
            ->with('success', '新しいタスクを登録しました。');
    }

    /**
     * 7. 詳細表示
     */
    public function show(Task $task)
    {
        // ルートモデルバインディングにより $task に自動で対象データが入る
        return view('tasks.show', compact('task'));
    }

    /**
     * 8-1. 編集画面表示
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * 8-2. 更新処理
     */
    public function update(Request $request, Task $task)
    {
        // 登録時と同様のバリデーション
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:todo,doing,done'],
            'due_date' => ['nullable', 'date'],
        ]);

        // 既存タスクを上書き更新
        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを更新しました。');
    }

    /**
     * 9. 削除処理
     */
    public function destroy(Task $task)
    {
        // データを削除
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'タスクを削除しました。');
    }
}