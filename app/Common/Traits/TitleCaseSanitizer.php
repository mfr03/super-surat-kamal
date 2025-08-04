<?php

namespace App\Common\Traits;

trait TitleCaseSanitizer
{
    protected static function sanitizeTitleCase(array $data): array
    {
        $excluded = static::$excludeTitleCasedFields ?? [];

        foreach ($data as $key => $value) {
            if (is_string($value) && !in_array($key, $excluded)) {
                $value = trim($value);
                if ($value !== '') {
                    $data[$key] = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
                } else {
                    $data[$key] = '';
                }
            }
        }
        return $data;
    }
}