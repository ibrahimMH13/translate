<?php

namespace Ibrhaim13\Translate\Models;

use Ibrhaim13\Translate\Database\Factories\TranslateFactory;
use Illuminate\Database\Eloquent\Model;

class Translate extends Model

{
    protected $fillable=[
      'key',
      'value',
      'language_code',
    ];

    protected static function newFactory(){
        return  TranslateFactory::new();
    }

}