<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait LanguageTrait
{
    private string $language;

    /**
     * @param string $value
     * @return $this
     */
    public function setLanguage(string $value):IService
    {
        $this->language = $value;
        return $this;
    }
}
