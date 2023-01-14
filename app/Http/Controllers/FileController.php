<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request) {
       $request->validate([
            'file_input' => 'mimes:xml|required'
        ]);

        // $meuXml = simplexml_load_string($request->file_input);
        $file = file_get_contents($request->file('file_input')->getRealPath());

        libxml_use_internal_errors(true);


        if(!(simplexml_load_string($file))){
            $erros = libxml_get_errors();

            foreach ($erros as $erro) {
                echo $erro->message, PHP_EOL;
            }
            exit;
        } else {
            echo "DEU BÃO";
        }
    }
}
