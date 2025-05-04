<?php

namespace App\Models;

use App\Models\BaseModel;

class StickerTypeMaterial extends BaseModel
{
    protected $fillable = [
        'sticker_type_id',
         'material_id',
         'sort_order',

         'created_by',
         'updated_by',
         'deleted_by',

         'created_at',
         'updated_at',
         'deleted_at',
        ];

        public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

        public function stickerType()
        {
            return $this->belongsTo(StickerType::class);
        }
        public function material()
        {
            return $this->belongsTo(Material::class);
        }
}
