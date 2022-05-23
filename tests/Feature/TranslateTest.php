<?php

namespace Ibrhaim13\Translate\Tests\Feature;


use Ibrhaim13\Translate\Tests\TestCase;

class TranslateTest extends TestCase
{
    /**
     * @test
     */
    public function example_test(){
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function list_translate(){
         $res = $this->get('translate');
         dd($res->getStatusCode());
    }
}
