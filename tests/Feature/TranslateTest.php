<?php

namespace Ibrhaim13\Translate\Tests\Feature;


use Ibrhaim13\Translate\Http\Middleware\Web\Localization;
use Ibrhaim13\Translate\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*    public function list_page_with_empty_record_translation(){+

        $res =  $this->get('/translate/en');
        dd($res);
        $res->assertOk(); // Checks that response status was 200
        $res->assertSee('no there data available');
    }*/
}
