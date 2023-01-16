<?php

namespace App\Infra;

use DOMDocument;

class GenerateXMLStructure
{
    private $doc;
    private $nodes;

    public function __construct(String $file)
    {
        $this->doc = new DOMDocument();
        $this->doc->loadXML($file);

        $this->setNodes();
    }

    private function setNodes()
    {
        foreach ($this->doc->getElementsByTagName('*') as $node) {

            if ($node->childElementCount === 0 && $node->nodeValue !== "") {
                $names[] = $node->nodeName;
                $this->nodes[] = [
                    'tag' => $node->nodeName,
                    'path' => $this->generatePath($node),
                    'value' => $node->nodeValue,
                ];
            }
        }

        session()->put('nodes', $this->nodes);
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

        return join('/', $reversed);
    }

    // public function getNodes(): array
    // {
    //     return session()->get('nodes');
    // }

}
