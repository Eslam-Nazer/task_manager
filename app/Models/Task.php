<?php

namespace App\Models;

use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Auth;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    /**
     * @use HasFactory<\Illuminate\Database\Eloquent\Factories\HasFactory>
     * @use SoftDeletes<\Illuminate\Database\Eloquent\SoftDeletes>
     */
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        if (!app()->runningInConsole()) {
            static::creating(function ($task) {
                $task->user_id = Auth::id();
            });

            static::updating(function ($task) {
                $task->user_id = Auth::id();
            });
        }
    }

    /**
     * Summary of table
     * @var string
     */
    protected $table = "tasks";

    /**
     * Summary of fillable
     * @var array<string>
     */
    protected $fillable = [
        "title",
        "status",
        "user_id"
    ];

    /**
     * Summary of newFactory
     * @return TaskFactory
     */
    protected static function newFactory(): TaskFactory
    {
        return new TaskFactory();
    }

    /**
     * Summary of users
     * @return BelongsTo<User, Task>
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
