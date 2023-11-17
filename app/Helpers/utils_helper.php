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
