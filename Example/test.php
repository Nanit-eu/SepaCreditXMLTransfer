<?php
include_once "../Controller/ExportService.php";
include_once "../Entity/Debtor.php";
include_once "../Entity/Initation.php";
include_once "../Entity/Transaction.php";
include_once "../Controller/ValidationController.php";
include_once "../Models/TransactionModel.php";
include_once "MyTransaction.php";

use NanitEu\SepaCreditXMLTransfer\Controller\ExportService;
use NanitEu\SepaCreditXMLTransfer\Entity\Debtor;
use NanitEu\SepaCreditXMLTransfer\Example\MyTransaction;
use NanitEu\SepaCreditXMLTransfer\Exception\InvalidDebtorException;
use NanitEu\SepaCreditXMLTransfer\Exception\XmlValidationException;

$i = 1;
try {
    $service = new ExportService(new Debtor('BE13001319659839', 'GEBABEBB', 'Fred SPRL'));
    $service->addTransaction(new MyTransaction('fred&aa @ ezez1', 123.45, 'BE14665349856987', 'GEBABEBB', 'transaction ' . $i++));
    $service->addTransaction(new MyTransaction('fred&aa @ ezez2', 321.45, 'BE14665349856987', 'GEBABEBB', 'transaction ' . $i++));
    $service->addTransaction(new MyTransaction('fred&aa @ ezez3', 987.45, 'BE14665349856987', 'GEBABEBB', 'transaction ' . $i++));

    $filename = './export-' . date("Ymdhi") . '.xml';

    file_put_contents($filename, $service->export());
} catch (InvalidDebtorException $e) {
    $this->assertFalse(true, 'Exception was raised while instantiate ExportService');
} catch (XmlValidationException $e) {
    $this->assertFalse(true, 'Check if output is valid');
}
