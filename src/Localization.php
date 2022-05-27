<?php

namespace Ibrhaim13\Translate;

use Ibrhaim13\Translate\Models\Translate;
use Ibrhaim13\Translate\Services\GeoIP\GetRequestGeo;
use Illuminate\Support\Facades\App;

class Localization
{
    public static function routePrefix($locale = null):? string
    {

        $currentLocale = null;
        if (empty($locale) || !is_string($locale)) {
            $locale = request()->segment(1);
        }
        if (array_key_exists($locale, config('translate13.locales'))) {
            $currentLocale = $locale;
        } else {
            $locale = null;
            $currentLocale = config('translate13.fallback_locale');
        }

        App::setLocale($currentLocale);
        return $locale;
    }

    public static function addKeyToTranslation($key, $value = null, $languageCode = 'en')
    {
        $flag = false;
        list($namespace, $group, $item) = app('translator')->parseKey(trim($key));
        if (in_array($group, Translate::$groups)) {
            $flag = true;
        }
        if ($flag) {
            // check if translation not exists
            $existsTransKey = Translate::where('key', $key)
                ->where('language_code', $languageCode)
                ->first();
            if (!$existsTransKey) {
                Translate::create([
                    'key' => strtolower($key),
                    'language_code' => $languageCode,
                    'value' => $value ?: $item
                ]);
            } else {
                if ($value) {
                    $existsTransKey->value = $value;
                    $existsTransKey->save();
                }
            }
        }
        return $flag;
    }

    public static function generate($class, &$attributes, $old = null)
    {
        $generate = false;
        $key = uniqid();

        foreach ($attributes as $filed => $value) {
            if (preg_match('/_key$/', $filed)) {
                if ($value) {
                    $attributes[$filed] = empty($old[$filed]) ? self::getTranslationKey($class, $filed, strtolower($key)) : $old[$filed];

                    self::addKeyToTranslation($attributes[$filed], $value);

                    $generate = true;
                } else {
                    $attributes[$filed] = '';

                    if (!empty($old[$filed])) {
                        try {
                            Translate::where('key', $old[$filed])
                                ->delete();
                        } catch (\Exception $e) {
                        }

                        $generate = true;
                    }
                }
            }
        }

        if ($generate && !App::runningInConsole()) {
            self::exportTranslations();
        }
    }

    private static function getTranslationKey($class, $filed, $key): string
    {
        return self::getTranslationFileName($class) . '.' . $filed . '_' . $key;
    }

    public static function getTranslationFileName($class): string
    {
        return 'db_' . strtolower(str_replace('App\\Models\\', '', $class));
    }

    public static function exportTranslations()
    {

        $languages = array();
        foreach (config('translate13.locales') as $code => $locale) {

            $translations = Translate::where('language_code', $code)->get();

            foreach ($translations as $translation) {
                if (str_starts_with($translation->key, 'db_')) {
                    $languages[$code]['db'][$translation->key] = $translation->value;
                } else {
                    $languages[$code][$translation->key] = $translation->value;
                }
            }
        }

        foreach ($languages as $code => $language) {
            self::exportPHPTranslation($code, $language);
        }
    }

    private static function exportPHPTranslation($code, array $language)
    {

        $langPath = App::langPath() . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR;

        $translations = [];

        foreach ($language as $key => $value) {
            self::getFolder($translations, $key, $value);
        }

        foreach ($translations as $group => $trans) {
            if ($group === 'st_vue') continue;

            if ($group === 'validation') {
                self::prepareValidationArray($trans);
            }

            self::exportPHP($langPath . $group . '.php', $trans);
        }
    }

    private static function getFolder(&$array, $key, $value)
    {
        list($namespace, $group, $item) = app('translator')->parseKey($key);

        if ($namespace == '*') {
            $array[$group][$item] = $value;
        }
    }

    private static function prepareValidationArray(array &$trans)
    {

        foreach ($trans as $key => $value) {

            $keys = explode('.', $key);

            switch (count($keys)) {
                case 2:
                    list($k1, $k2) = $keys;
                    $trans[$k1][$k2] = $value;
                    unset($trans[$key]);
                    break;
                case 3:
                    list($k1, $k2, $k3) = $keys;
                    $trans[$k1][$k2][$k3] = $value;
                    unset($trans[$key]);
                    break;
            }

        }

    }

    private static function exportPHP($fullPath, array $trans)
    {
        if (!is_dir(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        file_put_contents($fullPath, '<?php' . "\n\n" . 'return ' . var_export($trans, true) . ';');
    }

    public static function extractLangFromRequest()
    {
        static $lang = '';
        if ($lang) {
            return $lang;
        }

        $requestLocale = request()->segment(1);
        if (strpos($requestLocale, '-')) {
            $url = explode('-', $requestLocale);
            $lang = array_key_exists($url[1], config('translate13.locales')) ? $url[1] : '';
        } else {
            if ($requestLocale) {
                $lang = array_key_exists($requestLocale, config('translate13.locales')) ? $requestLocale : '';
            } else {
                $getRequestGeoCountry = app()->make(GetRequestGeo::class);
                $geo = $getRequestGeoCountry->process();
                $countryCode = $geo['country_code'];
                if ($countryCode == 'US') $lang = 'en';
                else $lang = array_key_exists($requestLocale, config('translate13.locales')) ? $requestLocale : '';
            }
        }

        // validate country code and language
        if (strlen($lang) == 2) {
            $lang = strtolower($lang);
            return $lang;
        }
        if (!$lang) {
            $location = geoip()->getLocation(request()->ip());
            if (array_key_exists(strtolower($location->iso_code), config('country-language.countries'))) {
                $lang = config('country-language.countries')[strtolower($location->iso_code)];
            }
        }
        return config('app.fallback_locale');
    }

    public static function extractCountryFromRequest()
    {
        static $countryCode = '';
        if ($countryCode) {
            return $countryCode;
        }

        $requestLocale = request()->segment(1);

        if (strpos($requestLocale, '-')) {
            $url = explode('-', $requestLocale);
            $countryCode = preg_replace('#[^a-z]#i', '', $url[0]);
        }

        // validate country code and language
        if (strlen($countryCode) != 2) {
            $getRequestGeoCountry = app()->make(GetRequestGeo::class);
            $geo = $getRequestGeoCountry->process();
            $countryCode = $geo['country_code'];
        }

        return $countryCode ?: 'local';
    }


}
