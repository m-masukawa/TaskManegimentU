<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデル
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'due_date','assigned_to',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee()
    {
        // assigned_to カラムを基準に User モデルと紐付ける
        return $this->belongsTo(User::class, 'assigned_to');
    }
}