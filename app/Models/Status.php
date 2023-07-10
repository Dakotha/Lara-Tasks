<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Status extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $table = 'status';

    protected $fillable = ['name'];

    protected $allowedSorts = [
        'name'
    ];

    protected $allowedFilters = [
        'name' => Like::class
    ];
}
