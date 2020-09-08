<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @package App\Models
 * @property string $message
 * @property string $ip
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'ip',
        'created_at',
        'updated_at'
    ];
}
