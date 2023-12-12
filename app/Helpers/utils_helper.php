<?php
use CodeIgniter\I18n\Time;

if (!function_exists('datetime_indo')) {
    function datetime_indo($parameter = "now")
    {
        $datetime_indo = new Time($parameter);
        $datetime_indo = $datetime_indo->toLocalizedString('eeee, dd MMMM yyyy, HH:mm');
        return $datetime_indo;
    }
}

if (!function_exists('array_has_attributes')) {
    function array_has_attributes(array $array, array $attributes): array
    {
        $missingAttributes = [];
        foreach ($attributes as $attribute) {
            if (!isset($array[$attribute])) {
                $missingAttributes[] = $attribute;
            }
        }
        return $missingAttributes;
    }
}

