<?php

namespace Ibrhaim13\Translate;

use Illuminate\Translation\Translator as LaravelTranslator;

class Translator extends LaravelTranslator
{

    /**
     * Get the translation for the given key.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string
     */
    public function get($key, array $replace = array(), $locale = null, $fallback = true)
    {
         // Get without fallback
        $key = strtolower($key);
        $result = parent::get($key, $replace, $locale, false);

         if($result === $key){
            $this->notifyMissingKey($key);

            // Reget with fallback
            $result = parent::get($key, $replace, $locale, $fallback);
        }

        return $result;
    }

    protected function notifyMissingKey($key)
    {
        $allowMissingKey = true;

        if (str_starts_with($key, 'db_')) {
            $allowMissingKey = false;
        }

        if (str_starts_with($key, 'validation')) {
            $allowMissingKey = false;
        }

        if($allowMissingKey) {
            Localization::addKeyToTranslation($key);
        }
    }

}
