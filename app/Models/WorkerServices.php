<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerServices extends Model
{
    use HasFactory;
    protected $table = 'workerservices';
    public $timestamps = false;
}
