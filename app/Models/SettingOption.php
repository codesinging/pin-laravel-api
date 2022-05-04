<?php

namespace App\Models;

use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SettingOption extends BaseModel
{
    protected $fillable = [
        'group_id',
        'name',
        'type',
        'default',
        'attributes',
        'options',
        'sort',
        'status',
    ];

    protected $casts = [
        'default' => 'json',
        'attributes' => 'json',
        'options' => 'json',
        'status' => 'boolean',
    ];

    protected $with = [
        'group',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(SettingGroup::class, 'group_id');
    }
}
