<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Alumno: Carlos Alejandro Ambriz
class TaskResponsible extends Model
{
    use HasFactory;

    protected $table = 'task_responsible_users';
    protected $fillable = ['task_id', 'user_id'];
    
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}