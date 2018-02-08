<?php

namespace App;

class TableHtml implements Table
{
    private $table;
    private $template;
    public function __construct(Table $table, $template){
        $this->table = $table;
        $this->template = $template;
    }

    public function dump(){
        $xsl = new \DOMDocument;
        $xsl->loadXML($this->template);
        $proc = new \XSLTProcessor;
        $proc->importStyleSheet($xsl);
        return $proc->transformToXML($this->table->dump());
    }
}
