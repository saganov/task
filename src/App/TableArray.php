<?php

namespace App;

class TableArray implements Table
{
    private $size;
    private $structure;
    private $canvas;
    public function __construct($size, array $structure){
        $this->size = $size;
        $this->structure = $structure;
    }

    public function dump(){
        $this->canvas = array_fill(0, $this->size, array_fill(0, $this->size, null));
        foreach ($this->structure as $item){
            if (!is_array($item)) throw new Exception("Invalid rectangle description: '$item'");
            $this->constructRectangle($item);
        }
        return $this->canvas;
    }

    private function constructRectangle($description){
        if (!is_array($description)) throw new Exception("Invalid rectangle description: '$description'");
        if (!array_key_exists('cells', $description)) throw new Exception('Invalid rectangle description, mandatory attribute "cells" is missed');
        $cells = array_map('intval', explode(',', $description['cells']));
        unset($description['cells']);
        sort($cells, SORT_NUMERIC);
        $cellNumberSource = array_shift($cells);     
        foreach ($description as $attribute => $value){
            switch ($attribute){
                case 'text':
                case 'align':
                case 'valign':
                case 'color':
                case 'bgcolor':
                    $this->updateCell($cellNumberSource, $attribute, $value);
                    break;
                default:
                    throw new Exception("Unknown table attribute: '{$attribute}'");
            }
        }
        if (count($cells) > 0){
            $this->mergeCells($cellNumberSource, $cells);
        }
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
    private function updateCell($cellNumber, $attribute, $value){
        list($row, $col) = $this->resolveCellNumberToIndexes($cellNumber);
        $this->canvas[$row][$col][$attribute] = $value;
    }

    private function mergeCells($cellNumberSource, array $cellNumbersDest){
        list($rowSource, $colSource) = $this->resolveCellNumberToIndexes($cellNumberSource);
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
        return array((int)(($number - 1) / $this->size), ($number - 1) % $this->size);
    }
}
