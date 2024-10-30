<?php

namespace App\Helper\Generator;

class Configurator
{
    public static function getPropertyTypesOptions(): array
    {
        // This is only place where you should be adding new types with related array of values for swagger
        return [
            'bigInteger' =>
                ['value' => 1, 'format' => 'int64', 'isString' => false],
            'boolean' =>
                ['value' => 'true', 'format' => 'boolean', 'isString' => false],
            'date' =>
                ['value' => '1980-01-23', 'format' => 'string', 'isString' => true],
            'integer' =>
                ['value' => 1, 'format' => 'int32', 'isString' => false],
            'string' =>
                ['value' => 'Lorem ipsum', 'format' => 'string', 'isString' => true],
            'text' =>
                ['value' => 'Lorem ipsum dolor sit amet, conse ...', 'format' => 'string', 'isString' => true],
            'timestamp' =>
                ['value' => '1980-01-23 12:35:07', 'format' => 'string', 'isString' => true],
        ];
    }
}
