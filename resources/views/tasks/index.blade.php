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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($tasks->isEmpty())
                    <p style="color: #6B7280; text-align: center;">タスクが登録されていません。</p>
                @else
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #E5E7EB; background-color: #F9FAFB;">
                                <th style="padding: 12px;">タスク名</th>
                                <th style="padding: 12px;">ステータス</th>
                                <th style="padding: 12px;">期限日</th>
                                <th style="padding: 12px;">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr style="border-bottom: 1px solid #E5E7EB;">
                                    <td style="padding: 12px;">
                                        <a href="{{ route('tasks.show', $task) }}" style="color: #2563EB; font-weight: bold; hover:underline;">
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
                                    <td style="padding: 12px; display: flex; gap: 10px;">
                                        <a href="{{ route('tasks.edit', $task) }}" style="color: #10B981; font-size: 14px;">編集</a>
                                        
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #EF4444; font-size: 14px;" onclick="return confirm('本当に削除しますか？')">削除</button>
                                        </form>
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