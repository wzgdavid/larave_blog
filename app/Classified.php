<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classified extends Model
{
    protected $table = 'classified';
    const UPDATED_AT = 'date_modified';
    const CREATED_AT = 'create_datetime';
}
