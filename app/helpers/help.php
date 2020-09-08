<?php

use Illuminate\Support\Facades\App;

/**
 * @param string $text
 * @param null $lang
 * @param string|null $key
 * @return string
 */
function t(string $text, $lang = null, ?string $key = null)
{
    try {
        $messages = config('messages.' . ($lang ?: App::getLocale()));
        if (!is_null($key)) {
            $keys = explode('.', $key);
            foreach ($keys as $key) {
                $messages = $messages[$key] ?? [];
            }
        }
        $t = $messages[$text] ?? $text;
        return is_string($t) ? $t : $text;
    } catch (Throwable $e) {
        return $text;
    }
}
