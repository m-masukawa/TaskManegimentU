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

@if ($errors->has('assigned_to'))
    <style>
        /* 1. 画面全体を一瞬ブルーホワイトに激しく明滅させる雷の定義 */
        @keyframes thunder-lightning {
            0%, 20%, 40%, 60%, 100% { background-color: transparent; opacity: 0; }
            10%, 14% { background-color: #e0f2fe; opacity: 0.9; } /* 1発目の雷 */
            12%      { background-color: #ffffff; opacity: 1; }
            50%, 54% { background-color: #bae6fd; opacity: 0.8; } /* 2発目の雷（追撃） */
            52%      { background-color: #ffffff; opacity: 1; }
        }

        /* 2. アース様の怒りで画面全体をガタガタ激しく揺らす定義（アース・シェイク） */
        @keyframes earth-shake {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            10% { transform: translate(-5px, 5px) rotate(-1deg); }
            20% { transform: translate(5px, -5px) rotate(1deg); }
            30% { transform: translate(-8px, -5px) rotate(-2deg); }
            40% { transform: translate(8px, 5px) rotate(2deg); }
            50% { transform: translate(-5px, 5px) rotate(-1deg); }
            60% { transform: translate(5px, -5px) rotate(1deg); }
            70% { transform: translate(-5px, -5px) rotate(0deg); }
            80% { transform: translate(5px, 5px) rotate(1deg); }
        }

        /* 雷のレイヤー（時間を1.5秒に延ばして存在感をアップ） */
        .lightning-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9998;
            pointer-events: none;
            animation: thunder-lightning 1.5s ease-in-out;
        }

        /* 画面全体を揺らすためのクラス（フォームを囲む要素などに自動適用） */
        body {
            animation: earth-shake 1.2s ease-in-out;
        }
@endif

</x-app-layout>