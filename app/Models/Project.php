<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'color',
        'user_id',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
