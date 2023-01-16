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

}
