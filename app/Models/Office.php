<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Commute;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'location',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function offices()
    {
        return $this->hasMany(Office::class);
    }
}
