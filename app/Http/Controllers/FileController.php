<?php

namespace App\Http\Controllers;

use App\Infra\CheckXML;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    private $nodes = array();

    public function upload(Request $request)
    {
        unset($this->nodes);

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

        foreach ($doc->getElementsByTagName('*') as $node) {

            if ($node->childElementCount === 0 and $node->nodeValue !== "") {
                $names[] = $node->nodeName;
                $this->nodes[] = [
                    'tag' => $node->nodeName,
                    'path' => $this->generatePath($node),
                    'value' => $node->nodeValue,
                ];
            }
        }

        session()->put('nodes', $this->nodes);

        return view('index', ['nodes' => $this->nodes]);
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

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $this->nodes = $this->filter($request->search);
        }

        return view('index', ['nodes' => $this->nodes]);
    }

    public function filter($filter)
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
