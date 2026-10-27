<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

//Alumno: Carlos Alejandro Ambriz
class Task extends Model
{
    use HasFactory, SoftDeletes;

    const BACKLOG_STATUS    = 'backlog';
    const IN_PROCESS_STATUS = 'in_process';
    const COMPLETED_STATUS  = 'completed';

    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'assigned_at',
        'expected_at',
        'due_at',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'expected_at' => 'datetime',
        'due_at'      => 'datetime',
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function taskResponsibles(): HasMany
{
    return $this->hasMany(TaskResponsible::class, 'task_id');
}

public function responsibles(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'task_responsible_users', 'task_id', 'user_id')
        ->withTimestamps();
}

}
