<?php

class RenderTableHtml
{
    private $table;
    public function __construct(Table $table){
        $this->table = $table;
    }

    public function show(){
        $dump = $this->table->dump();
        $tableHeight = count($dump);
        $tableWidth  = count($dump[0]);
        $html = "<style>\n";
        $html .= "\ttable {table-layout:fixed; width: ". 100*$tableWidth ."px; height: ". 100*$tableHeight ."px;}\n";
        $html .= "\ttable td {width: ". 10*$tableWidth ."px; height: ". 10*$tableHeight ."px; border: 1px solid #000}\n";
        $html .= "</style>\n";
        $html .= "<table>\n";
        foreach ($this->table->dump() as $row){
            $html .= "\t<tr>\n\t\t";
            foreach ($row as $cell){
                if (!is_array($cell)) {
                    $html .= "<td></td>";
                    continue;
                }
                if (array_key_exists('hidden', $cell)) continue;
                $text = '';
                $html .= "<td";
                foreach ($cell as $attribute => $value){
                    if ($attribute == 'text') {
                        $text = $value;
                    } else if ($attribute == 'color'){
                        $html .= " style = 'color:#$value'";
                    } else {
                        $html .= " $attribute = '$value'";
                    }
                }
                $html .= ">$text</td>";
            }
            $html .= "\n\t</tr>\n";
        }
        $html .= "</table>";
        return $html;
    }
}
