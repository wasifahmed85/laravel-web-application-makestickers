<?php

namespace App\Models;

use App\Models\BaseModel;

class MaterialAttribute extends BaseModel
{

    protected $fillable = [
        'name',
        'type',

        'created_by',
        'updated_by',
        'deleted_by',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'material_type',
        ]);
    }

    public const TYPE_TEXT = 1;
    public const TYPE_NUMBER = 2;
    public const TYPE_DECIMAL = 3;

    public static function getType()
    {
        return [
            self::TYPE_TEXT => 'Text',
            self::TYPE_NUMBER => 'Number',
            self::TYPE_DECIMAL => 'Decimal',
        ];
    }

    public function getMaterialTypeAttribute()
    {
        return $this->getType()[$this->type] ?? 'Unknown';
    }

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
}
