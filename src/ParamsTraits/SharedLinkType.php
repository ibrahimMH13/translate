<?php

namespace Ibrhaim13\Translate\ParamsTraits;
use Ibrhaim13\Translate\Contract\IService;

trait SharedLinkType
 {
     private  $sharedLinkType;

    /**
     * @param string $name
     * @return $this
     */
    public function setSharedLinkType(string $name):IService
     {
         $this->sharedLinkType = $name;
         return $this;
     }
}
