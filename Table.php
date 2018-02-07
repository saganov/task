<?php

class Table
{
    private $rows;
    private $cols;
    private $canvas;
    private $validAttributes = array('text', 'align', 'valign', 'color', 'bgcolor');
    public function __construct($rows, $cols = null){
        if (is_null($cols)){
            $cols = $rows;
        }
        $this->rows = $rows;
        $this->cols = $cols;
        $this->canvas = array_fill(0, $rows, array_fill(0, $cols, null));
    }

    public function dump(){
        return $this->canvas;
    }

    /*
     *  Update specified attribute of the table cell by its number
     *
     *  Cell number is its order number as shown belowe 
     *  +-----------+
     *  | 1 | 2 | 3 | 
     *  +---+---+---+ 
     *  | 4 | 5 | 6 | 
     *  +---+---+---+ 
     *  | 7 | 8 | 9 | 
     *  +---+---+---+
     *
     */
    public function updateCell($cellNumber, $attribute, $value){
        if (!in_array($attribute, $this->validAttributes)) throw new Exception("Unknown attribute: '$attribute'");
        list($row, $col) = $this->resolveCellNumberToIndexes($cellNumber);
        $this->canvas[$row][$col][$attribute] = $value;
    }

    public function mergeCells($cellNumberSource, array $cellNumbersDest){
        list($rowSource, $colSource) = $this->resolveCellNumberToIndexes($cellNumberSource);
        sort($cellNumbersDest);
        $colspan = $rowspan = 1;
        foreach ($cellNumbersDest as $cellNumberDest){
            list($rowDest, $colDest) = $this->resolveCellNumberToIndexes($cellNumberDest);
            if ($rowSource != $rowDest){
                $rowspan = max($rowspan, $rowDest - $rowSource + 1);
            }
            if ($colSource != $colDest) {
                $colspan = max($colspan, $colDest - $colSource + 1);
            }
            $this->hideCell($cellNumberDest);
        }
        if ($rowspan > 1){
            $this->canvas[$rowSource][$colSource]['rowspan'] = $rowspan;
        } 
        if ($colspan > 1){
            $this->canvas[$rowSource][$colSource]['colspan'] = $colspan;
        } 
    }

    private function hideCell($cellNumber){
        list($row, $col) = $this->resolveCellNumberToIndexes($cellNumber);
        if (is_array($this->canvas[$row][$col])) throw new Exception("Attempt to occupied cell '$cellNumber' twice");
        $this->canvas[$row][$col] = ['hidden' => true];
    }

    private function resolveCellNumberToIndexes($number){
        return array((int)(($number - 1) / $this->rows), ($number - 1) % $this->cols);
    }
}
