<?php

namespace App\Http\Controllers;

use App\Infra\GenerateXMLStructure;
use App\Infra\UtilsXML;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{
    private GenerateXMLStructure $nodes;


    public function upload(Request $request)
    {
        unset($this->nodes);

       $request->validate([
            'file_input' => 'mimes:xml|required'
        ]);

        $file = file_get_contents($request->file('file_input')->getRealPath());

        $validated = UtilsXML::check($file);

        if (sizeof($validated) !== 0) {
            return Redirect::to('/')->withErrors(['xml_check' => 'XML file invalid!']);
        }

        $this->nodes = new GenerateXMLStructure($file);

        return view('index', ['nodes' => session()->get('nodes')]);
    }

    public function search(Request $request)
    {
        $nodes_filter = [];
        if ($request->has('search')) {
            $nodes_filter = UtilsXML::filter($request->search);
        }

        return view('index', ['nodes' => $nodes_filter]);
    }
}
