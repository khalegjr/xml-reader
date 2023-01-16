<?php

namespace App\Http\Controllers;

use App\Infra\CheckXML;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    public function upload(Request $request)
    {
       $request->validate([
            'file_input' => 'mimes:xml|required'
        ]);

        $file = file_get_contents($request->file('file_input')->getRealPath());

        $validated = CheckXML::check($file);

        if (sizeof($validated) !== 0) {
            return Redirect::to('/')->withErrors(['xml_check' => 'XML file invalid!']);
        }

        $doc = new DOMDocument();
        $doc->loadXML($file);

        $names = array();
        $nodes = array();

        foreach ($doc->getElementsByTagName('*') as $node) {

            if ($node->childElementCount === 0 and $node->nodeValue !== "") {
                $names[] = $node->nodeName;
                $nodes[] = [
                    'tag' => $node->nodeName,
                    'path' => $this->generatePath($node),
                    'value' => $node->nodeValue,
                ];
            }
        }

        return view('index', compact('nodes'));
    }

    public function generatePath($node): String
    {
        $paths = array();

        while ($node->nodeType === XML_ELEMENT_NODE) {
            $paths[] = $node->parentNode->nodeName;

            $node = $node->parentNode;
        }

        array_pop($paths);
        $reversed = array_reverse($paths);
        $path_completed = join('/', $reversed);

        return $path_completed;
    }
}
