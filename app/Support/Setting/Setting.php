<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace App\Support\Setting;

use App\Models\Setting as SettingModel;

class Setting
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public static function has(string $key): bool
    {
        return SettingModel::new()->where('key', $key)->exists();
    }

    /**
     * @param string|array $key
     * @param mixed|null $default
     *
     * @return mixed|array
     */
    public static function get(string|array $key, mixed $default = null): mixed
    {
        if (is_string($key)) {
            return SettingModel::new()->firstOrNew(['key' => $key], ['value' => $default])['value'];
        }

        return SettingModel::new()->whereIn('key', $key)->pluck('value', 'key')->toArray();
    }

    /**
     * @param string|array $key
     * @param mixed|null $value
     *
     * @return void
     */
    public static function set(string|array $key, mixed $value = null): void
    {
        if (is_string($key)) {
            SettingModel::new()->updateOrCreate(['key' => $key], ['value' => $value]);
        } elseif (is_array($key)) {
            foreach ($key as $k => $v) {
                SettingModel::new()->updateOrCreate(['key' => $k], ['value' => $v]);
            }
        }
    }

    /**
     * @param string|array $key
     *
     * @return void
     */
    public static function remove(string|array $key): void
    {
        SettingModel::new()->whereIn('key', (array)$key)->delete();
    }
}
