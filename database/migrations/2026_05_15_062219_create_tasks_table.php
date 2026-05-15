<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
        public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // 誰のタスクか（外部キー）。cascadeOnDeleteでユーザー削除時にタスクも消える設定
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // タスク名
            $table->text('description')->nullable(); // 詳細（空でもOK）
            $table->string('status')->default('todo'); // todo, doing, done
            $table->date('due_date')->nullable(); // 期限日（空でもOK）
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
