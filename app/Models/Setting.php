<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getJson(string $key, mixed $default = []): mixed
    {
        $value = static::get($key);
        if ($value === null) {
            return $default;
        }
        return json_decode($value, true) ?? $default;
    }

    public static function setJson(string $key, mixed $value): void
    {
        static::set($key, json_encode($value));
    }
}
