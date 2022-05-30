<?php

namespace Ibrhaim13\Translate\Models;

use Ibrhaim13\Translate\Database\Factories\TranslateFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Translate extends Model

{
    protected $fillable=[
      'key',
      'value',
      'language_code',
    ];
    public static $rules = [
        'key' => 'required|max:255',
        'value' => 'required',
        'language_code' => 'required|max:2'
    ];

    public static array $groups = [
        'str_public',
        'str_admin',
        'st_vue',
    ];

    protected static function newFactory(){
        return  TranslateFactory::new();
    }

    public function getTranslateParams(){
        $locales = config('translate13.locales');
        foreach ($locales as $code => &$locale) {
            /** @var  $translate */
            $locale = [
                'title' => $locale,
                'translation' => self::where('key', $this->key)->where('language_code', $code)->first()
            ];
        }
        list($keyNamespace, $keyGroup, $keyItem) = app('translator')->parseKey($this->key);
        return array($locales, $keyNamespace, $keyGroup, $keyItem);
    }

}