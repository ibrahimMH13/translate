<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait RequestCookiesTrait
{
    private array $requestCookies;

    /**
     * @param array $value
     * @return $this
     */
    public function setRequestCookies(array $value):IService
    {
        $this->requestCookies = $value;
        return $this;
    }
}
