<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait RequestMethodTrait
{
    private string $requestMethod;

    /**
     * @param string $value
     * @return $this
     */
    public function setRequestMethod(string $value):IService
    {
        $this->requestMethod = $value;
        return $this;
    }
}
