<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 70年代を熱く盛り上げた特撮ヒーローたちのリスト
        $heroes = [
            'マグマ大使',      // 厳密には66年！
            '仮面ライダーV3',
            'キカイダー',
            'イナズマン',
            '快傑ズバット',
            'スペクトルマン',
            '宇宙鉄人キョーダイン'
        ];

        foreach ($heroes as $index => $name) {
            // ループのインデックスをベースに、1@1, 2@2... を作る
            $num = $index + 1;

            // ユーザーを作成
            $user = User::create([
                'name' => $name,
                'email' => "{$num}@{$num}",
                'password' => Hash::make('12345678'), // 全員共通パスワード
                'email_verified_at' => now(),
            ]);

            // 各ユーザーに紐づくテストタスクも3件ずつ自動生成（必要であれば）
            Task::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}