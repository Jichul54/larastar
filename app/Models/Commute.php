<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Office;
use Illuminate\Notifications\Notifiable;


class Commute extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    

    public function office()
    {
        return $this->belongsTo(Office::class);
    }  

    use Notifiable;
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }
}
