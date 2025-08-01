<?php

function convertSecondsToTime($seconds)
{
    $jam   = floor($seconds / 3600);
    $menit = floor(($seconds % 3600) / 60);

    $result = '';
    if ($jam > 0) {
        $result .= $jam . ' jam';
    }
    if ($menit > 0) {
        if ($jam > 0) {
            $result .= ' ';
        }
        $result .= $menit . ' menit';
    }

    return $result ?: '0 menit';
}
