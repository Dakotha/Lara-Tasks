<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Project extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = ['title', 'description', 'close_at'];

    protected $allowedSorts = [
        'title',
        'created_at',
        'close_at'
    ];

    protected $allowedFilters = [
        'title' => Like::class,
        'created_at' => Like::class,
        'close_at' => Like::class,
    ];
}
