<?php

namespace App\Http\Controllers;

use App\Infra\CheckXML;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    public function upload(Request $request) {
       $request->validate([
            'file_input' => 'mimes:xml|required'
        ]);

        $file = file_get_contents($request->file('file_input')->getRealPath());

        $validated = CheckXML::check($file);

        if(sizeof($validated) !== 0){
            return Redirect::to('/')->withErrors(['xml_check' => 'XML file invalid!']);
        }

        $doc = new DOMDocument();
        $doc->loadXML($file);

        $names = array();
        $paths = array();
        $nodes = array();

        foreach ($doc->getElementsByTagName('*') as $node) {

            if ($node->childElementCount === 0) {
                $names[] = $node->nodeName;
                $paths[] = $node->parentNode->nodeName;

                $nodes[] = [
                    'tag' => $node->nodeName,
                    'path' => $node->parentNode->nodeName,
                    'value' => $node->nodeValue,
                ];
            }
        }

        return view('index', compact('nodes'));
    }
}
