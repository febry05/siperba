<?php
require_once '../../vendor/autoload.php';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('word_template.docx');

$templateProcessor->setValues([
    'nomorsurat' => '001/pspsp/2022',
    'tanggal' => '10 Juni 2022',
]);

$templateProcessor->setImageValue(
    'logo',
    [
        'path' => 'logo.png',
        'width' => 100,
        'height' => 100,
        'ratio' => false,
    ]
);

$pathToSave = 'result_surat.docx';
$templateProcessor->saveAs($pathToSave);

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=result_surat.docx');

readfile($pathToSave);
