<?php

namespace App\Models;

use App\Support\Model\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SettingOption extends BaseModel
{
    protected $fillable = [
        'group_id',
        'setting_id',
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
        'setting',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(SettingGroup::class, 'group_id');
    }

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class, 'setting_id');
    }
}
