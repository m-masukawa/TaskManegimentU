<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">タスク新規登録</h2>
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

                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    @include('tasks._form')

                    <div style="margin-bottom: 15px;">
                        <label for="assigned_to" style="font-weight: bold; display: block; margin-bottom: 5px;">特命対象</label>
                        <select id="assigned_to" name="assigned_to" style="padding: 8px; width: 100%; border: 1px solid #000;">
                            <option value="">-- 待機 --</option>
                            @foreach($heroes as $hero)
                            <option value="{{ $hero->id }}" @selected(old('assigned_to')==$hero->id)>
                                {{ $hero->name }}
                                @if($hero->is_admin)@else （ヒーロー） @endif
                            </option>
                            @endforeach
                        </select>

                        @error('assigned_to')
                        <div style="color: #EF4444; font-weight: bold; font-size: 14px; margin-top: 5px;">
                            ⚠️アース様に特命を下すことは許されません！
                        </div>
                        @enderror
                    </div>

                    <button type="submit" style="background-color: #4F46E5; color: white; padding: 10px 20px; border-radius: 5px;">登録する</button>
                    <a href="{{ route('tasks.index') }}" style="margin-left: 10px; color: #6B7280;">キャンセル</a>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>