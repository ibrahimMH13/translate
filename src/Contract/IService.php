<?php

namespace Ibrhaim13\Translate\Contract;

interface IService
{
    /**
     * @return $this
     */
    public function exec():IService;

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params):IService;

    /**
     * @return array
     */
    public function getExecOutputs():array;

    /**
     * @param string $key
     * @return mixed
     */
    public function getExecOutput(string $key);

    /**
     * @param string $output
     * @param string $message
     */
    public function assertOutputExists(string $output, string $message): IService;
}
