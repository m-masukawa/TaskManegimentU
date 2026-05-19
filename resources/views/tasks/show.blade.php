<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">タスク詳細</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 style="font-size: 24px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #E5E7EB; padding-bottom: 10px;">
                    {{ $task->title }}
                </h3>

                <div style="margin-bottom: 20px;">
                    <span style="font-weight: bold; display: block; color: #4B5563;">ステータス:</span>
                    <span style="padding: 4px 8px; border-radius: 4px; font-size: 14px; font-weight: bold;
                        background-color: {{ $task->status === 'done' ? '#D1FAE5' : ($task->status === 'doing' ? '#FEF3C7' : '#E5E7EB') }};
                        color: {{ $task->status === 'done' ? '#065F46' : ($task->status === 'doing' ? '#92400E' : '#374151') }};">
                        {{ $task->status }}
                    </span>
                </div>

                <div style="margin-bottom: 20px;">
                    <span style="font-weight: bold; display: block; color: #4B5563;">期限日:</span>
                    <p style="font-size: 16px;">{{ $task->due_date ?? '未設定' }}</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <span style="font-weight: bold; display: block; color: #4B5563;">詳細説明:</span>
                    <p style="font-size: 16px; background-color: #F9FAFB; padding: 15px; border-radius: 5px; white-space: pre-wrap;">{!! nl2br(e($task->description ?? '説明はありません。')) !!}</p>
                </div>

                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #E5E7EB;">

                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('tasks.index') }}" style="color: #6B7280; border: 1px solid #D1M5DB; padding: 8px 16px; border-radius: 5px;">一覧へ戻る</a>
                    @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" style="background-color: #10B981; color: white; padding: 8px 16px; border-radius: 5px;">このタスクを編集</a>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-app-layout>