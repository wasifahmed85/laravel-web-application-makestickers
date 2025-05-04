<?php

namespace App\Models;

use App\Models\BaseModel;

class TemplateCategory extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',

        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
