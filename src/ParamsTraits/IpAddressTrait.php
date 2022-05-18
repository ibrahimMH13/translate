<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait IpAddressTrait
{
    private string $ipAddress;

    /**
     * @param string $value
     * @return $this
     */
    public function setIpAddress(string $value):IService
    {
        $this->ipAddress = $value;
        return $this;
    }
}
