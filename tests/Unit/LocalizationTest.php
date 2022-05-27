<?php


namespace Ibrhaim13\Translate\Tests\Unit;


use Ibrhaim13\Translate\Localization;
use Ibrhaim13\Translate\Models\Translate;
use Ibrhaim13\Translate\Tests\TestCase;
use Illuminate\Support\Facades\DB;

class LocalizationTest extends TestCase
{
    /**
     * @test
     */

    public function add_key_to_translation()
    {
        $fakeKey = $this->generate_fake_key();
        $prefix = Translate::$groups;
        $index = rand(0, count($prefix)-1);
        $this->assertTrue(Localization::addKeyToTranslation($prefix[$index].'.'.$fakeKey, $this->faker->sentence,
            app()->getLocale()));

        $this->assertDatabaseHas('translates', [
            'key' => $prefix[$index].'.'.$fakeKey,
        ]);
    }

    /**
     * @test
     */
    public function add_key_to_translation_missing_prefix()
    {
        $fakeKey = $this->generate_fake_key();
        $this->assertFalse(Localization::addKeyToTranslation($fakeKey, $this->faker->sentence,
            app()->getLocale()));
    }
    /**
     * @test
     */

    public function add_key_to_translation_is_not_exits_prefix()
    {
        $fakeKey = 'str_ibrahim.'.$this->generate_fake_key();
        $this->assertFalse(Localization::addKeyToTranslation($fakeKey, $this->faker->sentence,
            app()->getLocale()));
        $this->assertDatabaseMissing('translates',[
           'key'=>$fakeKey
        ]);
    }
    /**
     * @test
     */
     public function test_update_key_translation(){
         $fakeKey = $this->generate_fake_key();
         $prefix = Translate::$groups;
         $index = rand(0, count($prefix)-1);
         $this->assertTrue(Localization::addKeyToTranslation($prefix[$index].'.'.$fakeKey, $this->faker->sentence,
             app()->getLocale()));
         $this->assertTrue(Localization::addKeyToTranslation($prefix[$index].'.'.$fakeKey, $this->faker->sentence,
             app()->getLocale()));

     }


    /**
     * @test
     */
    public function test_generate_translation(){

        $languages=config('translate13.locales');
       $this->assertIsArray($languages);
        $fakeKey = $this->generate_fake_key();
        $prefix = Translate::$groups;
        $index = rand(0, count($prefix)-1);
        $this->assertTrue(Localization::addKeyToTranslation($prefix[$index].'.'.$fakeKey, $this->faker->sentence,
            app()->getLocale()));
        $fakeKey = $this->generate_fake_key();
        $prefix = Translate::$groups;
        $index = rand(0, count($prefix)-1);
        $this->assertTrue(Localization::addKeyToTranslation($prefix[$index].'.'.$fakeKey, $this->faker->sentence,
            app()->getLocale()));
       Localization::exportTranslations();

    }

}