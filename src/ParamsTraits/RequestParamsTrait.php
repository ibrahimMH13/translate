<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait RequestParamsTrait
{
    private array $requestParams;

    /**
     * @param array $value
     * @return $this
     */
    public function setRequestParams(array $value):IService
    {
        $this->requestParams = $value;
        return $this;
    }
}
