<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['module', 'setting_key', 'setting_value'];

    public static function getNoShowEmail()
    {
        return [
            'subject' => self::where('setting_key', 'no_show_mail_subject')->first()->setting_value ?? null,
            'body'    => self::where('setting_key', 'no_show_mail_body')->first()->setting_value ?? null,
        ];
    }

    public static function scopeKey($query, $key)
    {
        return $query->where('setting_key', $key);
    }

    public static function scopeModule($query, $module)
    {
        return $query->where('module', $module);
    }
}
