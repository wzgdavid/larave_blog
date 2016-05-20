<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classified extends Model
{
    protected $table = 'classified';
    const UPDATED_AT = 'date_modified';
    const CREATED_AT = 'create_datetime';


    protected $fillable = [

        'title',
        'content',
        'slug',
        'is_approved',
        'is_individual',
        'start_datetime',
        'end_datetime',
        'price',
        'size',
        'is_shared',
        'is_agency',
        'geo_location',
        'size_square',
        'contributor_id',
        'district_id',
        'forum_url',
        'featured',
        'category_id',
        'merto_line',
        'station',



    ];
}
