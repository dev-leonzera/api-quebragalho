<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerAvailability extends Model
{
    use HasFactory;

    protected $table = 'workeravailability';
    public $timestamps = false;
}
