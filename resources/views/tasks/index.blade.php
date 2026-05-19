<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">マイタスク一覧</h2>
            <a href="{{ route('tasks.create') }}" style="background-color: #4F46E5; color: white; padding: 8px 16px; border-radius: 5px; font-size: 14px;">新規作成</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div style="background-color: #D1FAE5; color: #065F46; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
            @endif

            <div class="search-filter-section" style="margin-bottom: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 5px;">
                <form method="GET" action="{{ route('tasks.index') }}" style="display: flex; gap: 10px; align-items: flex-end;">

                    <div>
                        <label for="keyword" style="font-weight: bold; display: block; margin-bottom: 5px;">キーワード</label>
                        <input
                            type="text"
                            id="keyword"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="タイトル・説明から検索"
                            style="padding: 6px 12px; width: 200px; height: 36px;">
                    </div>

                    <div>
                        <label for="status" style="font-weight: bold; display: block; margin-bottom: 5px;">ステータス</label>
                        <select id="status" name="status" style="padding: 6px 12px; width: 200px; height: 36px;">
                            <option value="">すべて</option>
                            <option value="todo" @selected(request('status')==='todo' )>未着手</option>
                            <option value="doing" @selected(request('status')==='doing' )>進行中</option>
                            <option value="done" @selected(request('status')==='done' )>完了</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" style="padding: 6px 24px; height: 36px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">
                            検索・絞り込み
                        </button>

                        <a href="{{ route('tasks.index') }}" style="margin-left: 5px; font-size: 0.9em; color: #666; text-decoration: none;">
                            クリア
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($tasks->isEmpty())
                <p style="color: #6B7280; text-align: center;">タスクが登録されていません。</p>
                @else
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #E5E7EB; background-color: #F9FAFB;">
                            @if(auth()->user()->is_admin)
                            <th style="padding: 12px;">担当ヒーロー</th>
                            @endif

                            <th style="padding: 12px;">タスク名</th>
                            <th style="padding: 12px;">ステータス</th>
                            <th style="padding: 12px;">期限日</th>

                            <th style="padding: 12px;">特命遂行者</th>

                            <th style="padding: 12px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr style="border-bottom: 1px solid #E5E7EB;">
                            @if(auth()->user()->is_admin)
                            <td style="padding: 12px; font-weight: bold; color: #4F46E5;">
                                {{ $task->user->name }}
                            </td>
                            @endif

                            <td style="padding: 12px;">
                                <a href="{{ route('tasks.show', $task) }}" style="color: #2563EB; font-weight: bold;">
                                    {{ $task->title }}
                                </a>
                            </td>

                            <td style="padding: 12px;">
                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;
                        background-color: {{ $task->status === 'done' ? '#D1FAE5' : ($task->status === 'doing' ? '#FEF3C7' : '#E5E7EB') }};
                        color: {{ $task->status === 'done' ? '#065F46' : ($task->status === 'doing' ? '#92400E' : '#374151') }};">
                                    {{ $task->status }}
                                </span>
                            </td>

                            <td style="padding: 12px; color: #4B5563;">
                                {{ $task->due_date ?? '未設定' }}
                            </td>

                            <td style="padding: 12px;">
                                @if($task->assignee)
                                <span style="background-color: #e2e8f0; color: #4a5568; padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px;">
                                    {{ $task->assignee->name }}
                                </span>
                                @else
                                <span style="color: #a0aec0; font-style: italic; font-size: 12px;">待機中</span>
                                @endif
                            </td>

                            <td style="padding: 12px; display: flex; gap: 10px;">
                                @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" style="color: #10B981; font-size: 14px;">編集</a>
                                @endcan

                                @can('delete', $task)
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #EF4444; font-size: 14px; background: none; border: none; padding: 0; cursor: pointer;" onclick="return confirm('本当に削除しますか？')">削除</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    {{ $tasks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>