<?php

namespace app\Utils;

class DataSessionUtils
{
    public static function getUserFullName(): string
    {
        return $_SESSION["user_data"]["full_name"] ?? '';
    }
}
