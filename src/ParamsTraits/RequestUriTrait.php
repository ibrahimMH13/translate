<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait RequestUriTrait
{
    private string $requestUri;

    /**
     * @param string $value
     * @return $this
     */
    public function setRequestUri(string $value):IService
    {
        $this->requestUri = $value;
        return $this;
    }
}
