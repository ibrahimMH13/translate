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
    public static $rules = [
        'key' => 'required|max:255',
        'value' => 'required',
        'language_code' => 'required|max:2'
    ];

    public static array $groups = [
        'str_public',
        'str_admin',
    ];

    protected static function newFactory(){
        return  TranslateFactory::new();
    }

}