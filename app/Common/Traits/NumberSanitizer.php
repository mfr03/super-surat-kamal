<?php

namespace App\Common\Traits;

trait NumberSanitizer
{

    protected static function sanitizeDoubleValues(array $data): array
    {
        $fields = static::$includedNumberFields ?? [];

        foreach ($fields as $key) {
            if (isset($data[$key])) {
                $data[$key] = static::sanitizeDouble($data[$key]);
            }
        }

        return $data;
    }

    protected static function sanitizeDouble($value): float
    {

        $num = floatval($value);

        if ($num < 0) {
            $num = 0;
        }

        return $num;
    }
}