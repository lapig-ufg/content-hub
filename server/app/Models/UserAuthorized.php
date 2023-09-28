<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthorized extends Model
{
    use HasFactory;

    protected $table = "users_authorized";

    protected $fillable = [
        'email',
        'authorized'
    ];

    static public function isAuthorized(string $email) {
        $list = UserAuthorized::where("email", $email)->first();
        
        return !is_null($list) ? $list->value('authorized') : false;
    }
}