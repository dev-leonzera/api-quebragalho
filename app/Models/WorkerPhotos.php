<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPhotos extends Model
{
    use HasFactory;

    protected $table = 'workerphotos';
    public $timestamps = false;
}
