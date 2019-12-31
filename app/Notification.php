<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'tr_notification';
    protected $fillable = ['user_id', 'title', 'body', 'type', 'is_read', 'extra_id'];
    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';
}
