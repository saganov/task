<?php

include_once __DIR__ ."/input.php";
require_once __DIR__ ."/Table.php";
require_once __DIR__ ."/RenderTableHtml.php";

$table = new Table(3);

try {
    foreach ($input as $item){
        $cells = array_map('intval', explode(',', $item['cells']));
        sort($cells, SORT_NUMERIC);
        $cellNumberSource = array_shift($cells);
        foreach($item as $attribute => $value){
            switch ($attribute){
                case 'text':
                case 'align':
                case 'valign':
                case 'color':
                case 'bgcolor':
                    $table->updateCell($cellNumberSource, $attribute, $value);
                    break;
                case 'cells':
                    break;
                default:
                    Throw new Exception("Unknown table attribute: '{$attribute}'");
            }
        }
        if (count($cells) > 0){
            $table->mergeCells($cellNumberSource, $cells);
        }
    }

    $render = new RenderTableHtml($table);
    print($render->show());
} catch (Exception $e) {
    echo "[ERROR]: {$e->getMessage()}";
}

