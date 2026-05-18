<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">タスク編集</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>・{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PUT') @include('tasks._form', ['task' => $task])

                    <button type="submit" style="background-color: #10B981; color: white; padding: 10px 20px; border-radius: 5px;">更新する</button>
                    <a href="{{ route('tasks.index') }}" style="margin-left: 10px; color: #6B7280;">キャンセル</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>