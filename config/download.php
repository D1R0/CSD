<?php
$zip = new ZipArchive();

$zip_filename = 'archive.zip';

if ($zip->open($zip_filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die("Failed to create archive\n");
}

$zip->addFile('../data/concurentiTimp.csv');
$zip->addFile('../data/istoric.log');

$zip->close();

header('Content-Type: application/zip');
header('Content-disposition: attachment; filename=' . basename($zip_filename));
header('Content-Length: ' . filesize($zip_filename));

readfile($zip_filename);
unlink($zip_filename);