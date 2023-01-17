<?php

namespace App\Infra;

class UtilsXML
{
    static function check($file): Array {
        libxml_use_internal_errors(true);
        simplexml_load_string($file);
        $errors = libxml_get_errors();

        return $errors;
    }

    static function filter($filter): array
    {
        $temp = array();

        foreach (session()->get('nodes') as $node) {

            if (str_contains(
                   strtolower($node['tag']),
                    strtolower($filter)
                ) ||
                str_contains(
                   strtolower($node['path']),
                    strtolower($filter)
                ) ||
                str_contains(
                   strtolower($node['value']),
                    strtolower($filter)
                )
            ) {
                $temp[] = $node;
            }
        }

        return $temp;
    }
}
