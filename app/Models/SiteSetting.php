<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'type', 'group', 'label', 'description'];

    public static function get($key, $default = null)
    {
        return Cache::remember("site_setting:{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set($key, $value, $type = 'text', $group = 'general', $label = null, $description = null)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group, 'label' => $label, 'description' => $description]
        );

        Cache::forget("site_setting:{$key}");

        return $setting;
    }

    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'json':
                return json_decode($value, true);
            case 'boolean':
                return (bool) $value;
            case 'number':
                return is_numeric($value) ? (float) $value : $value;
            default:
                return $value;
        }
    }

    public function setValueAttribute($value)
    {
        switch ($this->type) {
            case 'json':
                if (is_array($value) || is_object($value)) {
                    $this->attributes['value'] = json_encode($value);
                } elseif (is_string($value)) {
                    $decodedValue = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->attributes['value'] = $value;
                    } else {
                        $this->attributes['value'] = json_encode($value);
                    }
                } else {
                    $this->attributes['value'] = json_encode($value);
                }
                break;
            case 'boolean':
                $this->attributes['value'] = (int) $value;
                break;
            case 'number':
                $this->attributes['value'] = is_numeric($value) ? (float) $value : $value;
                break;
            default:
                $this->attributes['value'] = $value;
        }
    }

    public function getDisplayValueAttribute()
    {
        switch ($this->type) {
            case 'boolean':
                return $this->value ? 'Yes' : 'No';
            case 'image':
                return $this->value ? Storage::disk('public')->url($this->value) : 'No image';
            case 'json':
                return is_array($this->value) ? json_encode($this->value, JSON_PRETTY_PRINT) : $this->value;
            default:
                return $this->value;
        }
    }

    public function getTypeIconAttribute()
    {
        switch ($this->type) {
            case 'text':
                return 'fas fa-font';
            case 'textarea':
                return 'fas fa-align-left';
            case 'image':
                return 'fas fa-image';
            case 'json':
                return 'fas fa-code';
            case 'boolean':
                return 'fas fa-toggle-on';
            case 'number':
                return 'fas fa-hashtag';
            default:
                return 'fas fa-cog';
        }
    }

    public function getGroupIconAttribute()
    {
        switch ($this->group) {
            case 'general':
                return 'fas fa-cog';
            case 'social':
                return 'fas fa-share-alt';
            case 'contact':
                return 'fas fa-envelope';
            case 'seo':
                return 'fas fa-search';
            case 'appearance':
                return 'fas fa-palette';
            case 'security':
                return 'fas fa-shield-alt';
            default:
                return 'fas fa-folder';
        }
    }
}