<?php

include_once __DIR__ ."/input.php";
require_once __DIR__ ."/Table.php";
require_once __DIR__ ."/RenderTableHtml.php";


try {
    // Construct Table according to structure in input.php
    $table = new Table(3, $input);
    // Instantiate reneder of table
    $render = new RenderTableHtml($table);
    // Render table acording to the template
    $render->show(file_get_contents('RenderTableHtml.xsl'));
} catch (Exception $e) {
    echo "[ERROR]: {$e->getMessage()}";
}

