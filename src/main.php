<?php

include_once __DIR__ ."/autoloader.php";
include_once __DIR__ ."/input.php";

use App as App;

try {
    $table = new App\TableHtml(
                new App\TableXml(
                    new App\TableArray(3, $input)),
                file_get_contents(__DIR__ .'/templates/RenderTableHtml.xsl'));
    echo $table->dump();
} catch (Exception $e) {
    echo "[ERROR]: {$e->getMessage()}";
}

