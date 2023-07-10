<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = ['title', 'description', 'close_at', 'project_id', 'user_id', 'status_id'];

    protected $allowedSorts = [
        'title',
        'created_at',
        'close_at',
        'status_id'
    ];

    protected $allowedFilters = [
        'title' => Like::class,
        'created_at' => Like::class,
        'close_at' => Like::class,
        'status_id' => Like::class,
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
