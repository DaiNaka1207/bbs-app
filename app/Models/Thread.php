<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    protected $fillable = ['user_name','user_identifier', 'message_title', 'message'];
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
