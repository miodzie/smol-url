<?php

namespace App\TinyUrls;

class UrlValidator
{
    public const REGEX = '/^(http|https):\/\/[^ "]+$/';

    public static function validate($url): bool
    {
        return preg_match(self::REGEX, $url);
    }
}
