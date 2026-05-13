<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::rememberForever('setting_' . $key, function () use ($key) {
            return static::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        $raw = is_array($value) || is_object($value) ? json_encode($value) : (string) $value;
        static::updateOrCreate(['key' => $key], ['value' => $raw]);
        Cache::forget('setting_' . $key);
    }

    /**
     * Inbox for site-driven mail (contact form, admin alerts, etc.).
     * Priority: Settings admin email → public contact email → MAIL_ADMIN_EMAIL / config → MAIL_FROM_ADDRESS.
     */
    public static function siteNotificationEmail(): string
    {
        foreach ([
            trim((string) self::get('admin_email', '')),
            trim((string) self::get('contact_email', '')),
            trim((string) config('mail.admin_email', '')),
            trim((string) config('mail.from.address', '')),
        ] as $email) {
            if ($email !== '') {
                return $email;
            }
        }

        return '';
    }
}
