<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): self
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get multiple settings
     */
    public static function getMany(array $keys): array
    {
        $settings = self::whereIn('key', $keys)->get();
        $result = [];

        foreach ($keys as $key) {
            $setting = $settings->firstWhere('key', $key);
            $result[$key] = $setting ? $setting->value : null;
        }

        return $result;
    }

    /**
     * Set multiple settings at once
     */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Delete a setting
     */
    public static function remove(string $key): bool
    {
        return self::where('key', $key)->delete() > 0;
    }
}
