<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirebaseMessageServiceToken extends Model
{
    protected $table = 'tr_firebase_message_service_token';
    protected $fillable = ['user_id', 'token'];
    public $timestamps = false;
}
