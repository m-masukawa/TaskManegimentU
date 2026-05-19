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
        // ヒーローごとの専用タスクリスト
        $heroTasks = [
            'マグマ大使' => [
                ['title' => 'アース様からの緊急呼び出しに対応', 'description' => '火山基地へ向かい、地球侵略者ゴアの作戦についての指示を仰ぐ。短笛の音に注意すること。', 'status' => 'todo'],
                ['title' => '宇宙怪獣モグネスの動向調査', 'description' => '地中を移動するモグネスの震源地を特定し、防衛隊と連携して迎撃体制を整える。', 'status' => 'doing'],
                ['title' => 'ゴアの円盤群を撃退', 'description' => 'スクランブル発進。東京上空に現れた円盤をロケット弾で一掃する。', 'status' => 'done'],
            ],
            '仮面ライダーV3' => [
                ['title' => 'デストロンの怪人ハサミジャガー捜索', 'description' => '少年仮面ライダー隊からの目撃情報を元に、アジトを特定する。バイクの整備を忘れずに。', 'status' => 'todo'],
                ['title' => 'V3ホッパーによる上空偵察', 'description' => '新型ロケット爆弾の輸送ルートを空から追跡する。', 'status' => 'doing'],
                ['title' => 'ライダーV3の特殊能力の特訓', 'description' => '逆ダブルタイフーンのエネルギー消費量と、使用後のスキを検証する。', 'status' => 'done'],
            ],
            'キカイダー' => [
                ['title' => 'ダーク破壊部隊のギルハカイダーを阻止', 'description' => 'プロフェッサー・ギルの悪魔の笛の音が聞こえたら、良心回路をフル稼働して耐える。', 'status' => 'todo'],
                ['title' => 'サイドマシーンのオイル交換', 'description' => '光明寺博士の捜索に向けて、愛車の各部メンテナンスと燃料補給を行う。', 'status' => 'doing'],
                ['title' => '不完全な良心回路のデバッグ', 'description' => 'ジローの回路ログを解析し、善と悪の感情の揺らぎを調整する。', 'status' => 'done'],
            ],
            'イナズマン' => [
                ['title' => 'サナギマンからイナズマンへの転換訓練', 'description' => 'エネルギーが満ちるまでの耐久時間を15秒短縮するための精神統一。', 'status' => 'todo'],
                ['title' => '新人類帝国ファントム軍団のミュータント討伐', 'description' => 'ゼーバーを装着し、超能力増幅器の動作チェックを行う。', 'status' => 'doing'],
                ['title' => 'ライジンゴーの自動操縦テスト', 'description' => '噛みつき攻撃およびカッター射出の命中精度を測定。', 'status' => 'done'],
            ],
            '快傑ズバット' => [
                ['title' => '「その腕前は日本じゃあ二番目だ」の口上練習', 'description' => '対決相手に精神的プレッシャーを与えるための完璧な間（ま）とポージングの研究。', 'status' => 'todo'],
                ['title' => 'ズバットスーツの制限時間タイマー修理', 'description' => '活動限界の5分間を超えると爆発する仕様をどうにか改善できないか設計図を見直す。', 'status' => 'doing'],
                ['title' => '親友・飛鳥五郎を殺した犯人の手がかり調査', 'description' => '今回の地回りヤクザのボスを尋問したが、やはり「アリバイがある」とのことだった。', 'status' => 'done'],
            ],
            'スペクトルマン' => [
                ['title' => 'ネビュラ71遊星からの指示受信', 'description' => '公害エージェントの動向について、宇宙意志からの作戦命令を待つ。', 'status' => 'todo'],
                ['title' => 'ラーとゴリの怪獣製造工場の特定', 'description' => 'ヘドロやゴミ集積場周辺に発生している異常な放射線をガイガーカウンターで測定。', 'status' => 'doing'],
                ['title' => '公害怪獣ヘドロンの溶解液対策', 'description' => 'スペクトルシールドの耐酸コーティングを強化する。', 'status' => 'done'],
            ],
            '宇宙鉄人キョーダイン' => [
                ['title' => 'スカイゼル・グランゼルの変形同調テスト', 'description' => 'スカイミサイルとグランカーへの同時変形時の、サイバロイドリンクの安定化。', 'status' => 'todo'],
                ['title' => 'ダダ星人のロボット兵器迎撃', 'description' => '地球防衛軍の基地周辺に敷設されたバリアの出力を調整。', 'status' => 'doing'],
                ['title' => '葉山博士のメッセージ解読', 'description' => '宇宙から届いた超微弱な電波をノイズキャンセラーで補正。', 'status' => 'done'],
            ],
        ];

        // 1. 先に管理者「アース様」を作成する
        User::create([
            'name' => 'アース様（管理者）',
            'email' => '0@0', // 超覚えやすいメアド
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'is_admin' => true, 
        ]);

        foreach ($heroTasks as $heroName => $tasks) {
            // 前回のメアド規則をそのまま採用 (1@1, 2@2...)
            static $num = 1;

            $user = User::create([
                'name' => $heroName,
                'email' => "{$num}@{$num}",
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);

            // 各ヒーローに用意した専用タスクを登録
            foreach ($tasks as $taskData) {
                Task::create([
                    'user_id' => $user->id,
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'status' => $taskData['status'],
                    'due_date' => now()->addDays(rand(1, 30))->format('Y-m-d'), // 期限日はランダムに未来の日付
                ]);
            }

            $num++;
        }
    }
}