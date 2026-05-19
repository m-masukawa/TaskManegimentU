<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

use App\Models\User;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        //クエリの分岐
        if ($user->is_admin) {
            // 管理者がタスクを監視
            $query = Task::query();
        } else {
            // 立案したタスク　割り当てられたタスク
            $query = Task::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('assigned_to', $user->id);
            });
        }

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%')
                    ->orWhereHas('user', function ($userQuery) use ($keyword) {
                        $userQuery->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // ステータス絞り込み
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 最新順に並び替えて取得
        $tasks = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    // 特命立案画面
    public function create(Request $request)
    {
        if ($request->user()->is_admin) {
            // アース様なら全ユーザーを選択可能
            $heroes = User::all();
        } else {
            // ヒーローならアース様以外の全ヒーローを選択可能
            $heroes = User::where('is_admin', false)->get();
        }

        return view('tasks.create', compact('heroes'));
    }


    public function store(Request $request)
    {
        // バリデーション
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ];

        $validated = $request->validate($rules);

        if (!$request->user()->is_admin && $request->filled('assigned_to')) {
            $assignedUser = User::find($request->input('assigned_to'));

            if ($assignedUser && $assignedUser->is_admin) {
                // 名前を動的に取得
                $attackerName = $request->user()->name;

                // 強制的にエラーを返す
                return back()->withErrors([
                    'assigned_to' => "「私は地球の創造主アースである。{$attackerName}よ、私に命令を下すとは100年早い！…いや、1億年早い！」"
                ])->withInput();
            }
        }

        // 保存処理
        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('status', '特命が伝達されました。');
    }


    public function show(Task $task)
    {
        $this->authorize('view', $task); // 認可

        return view('tasks.show', compact('task'));
    }


    // 特命修正画面
    public function edit(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        if ($request->user()->is_admin) {
            // 管理者は全員選択可能
            $heroes = User::all();
        } else {
            // 一般ヒーローは管理者以外を選択可能
            $heroes = User::where('is_admin', false)->get();
        }

        return view('tasks.edit', compact('task', 'heroes'));
    }

    public function update(Request $request, Task $task)
    {
        // Policy等による認可チェック
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if (!$request->user()->is_admin && $request->filled('assigned_to')) {
            $assignedUser = User::find($request->input('assigned_to'));

            if ($assignedUser && $assignedUser->is_admin) {
                // 名前を取得
                $attackerName = $request->user()->name;

                return back()->withErrors([
                    'assigned_to' => "「私は地球の創造主アースである。{$attackerName}よ、私に命令を下すとは100年早い！…いや、1億年早い！」"
                ])->withInput();
            }
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('status', '特命が書き換えられました。');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task); //  認可

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました。');
    }
}
