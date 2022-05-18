<?php
namespace Ibrhaim13\Translate\Database\Factories;
use Ibrhaim13\Translate\Models\Translate;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslateFactory extends Factory
{
    protected $model = Translate::class;
    public function definition()
    {
        $words = $this->faker->words(3, true);
        return [
            'key'           => str_replace('','_',$words),
            'value'         => $words,
            'language_code' => 'en',
        ];

    }
}