<?php

if (!function_exists('badgeColor')) {
    function badgeColor($unit)
    {
        return match ($unit) {
            'pc'=> 'positive',
            'pack'=> 'negative',
            'sachet'=> 'warning',
            'unit'=> 'info',
            'ream'=> 'dark',
            'box'=> 'slate',
            'set'=> 'zinc',
            'meter'=> 'neutral',
            'kg'=> 'stone',
            'bag'=> 'red',
            'case'=> 'orange',
            'kit'=> 'amber',
            'lot'=> 'lime',
            'bucket'=> 'green',
            'galon'=> 'emerald',
            'crate'=> 'teal',
            'bottle' => 'cyan',
            default => 'secondary',
        };
    }
}
