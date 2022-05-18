<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait CountryCodeTrait
{
    private string $countryCode;

    /**
     * @param string $value
     * @return $this
     */
    public function setCountryCode(string $value):IService
    {
        $this->countryCode = $value;
        return $this;
    }
}
