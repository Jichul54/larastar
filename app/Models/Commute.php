<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commute extends Model
{
    use HasFactory;

    'id',
    'user_id',
    'office_id',
    'arrival',
    'departure',
}
