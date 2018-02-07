<?php

class RenderTableHtml
{
    private $table;
    public function __construct(Table $table){
        $dom = new DOMDocument('1.0', 'utf-8');
        $rootDom = $dom->createElement('table');
        foreach ($table->dump() as $row){
            $rowDom = $dom->createElement('row');
            foreach ($row as $cell){
                if (!is_array($cell)) {
                    $rowDom->appendChild($dom->createElement('cell'));
                    continue;
                }
                if (array_key_exists('hidden', $cell)) continue;
                $cellDom = $dom->createElement('cell');
                foreach ($cell as $attribute => $value){
                    $cellDom->appendChild($dom->createElement($attribute, $value));
                }
                $rowDom->appendChild($cellDom); 
            }
            $rootDom->appendChild($rowDom);
        }
        $dom->appendChild($rootDom);
        $this->table = $dom;
    }

    public function dump(){
        return $this->table->saveXML();
    }

    public function show($template){
        $xsl = new DOMDocument;
        $xsl->loadXML($template);
        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl);
        echo $proc->transformToXML($this->table);
    }
}
