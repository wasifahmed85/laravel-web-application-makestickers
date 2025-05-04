<?php

namespace App\Models;

use App\Models\BaseModel;

class Material extends BaseModel
{

    protected $fillable = [
        'name',
        'description',
        'price_modifier',
        'icons',
        'status',

        'created_by',
        'updated_by',
        'deleted_by',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function materialAttributeValues()
    {
        return $this->hasMany(MaterialAttributeValue::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
    public function stickerTypeMaterial()
    {
        return $this->hasMany(StickerTypeMaterial::class);
    }
}
