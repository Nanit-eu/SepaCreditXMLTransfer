<?php
include_once "../Controller/ExportService.php";
include_once "../Entity/Debtor.php";
include_once "../Entity/Initation.php";
include_once "../Entity/Transaction.php";
include_once "../Controller/ValidationController.php";
include_once "../Models/TransactionModel.php";

include_once "WikiTransaction.php";

use Nanit\SepaCreditXMLTransfer\Controller\ExportService;
use Nanit\SepaCreditXMLTransfer\Entity\Debtor;
use Nanit\SepaCreditXMLTransfer\Entity\Initation;
use Nanit\SepaCreditXMLTransfer\Entity\Transaction;
use Nanit\SepaCreditXMLTransfer\Models\TransactionModel;
$i=1;
$service = new ExportService(new Debtor('BE13001319659839','GEBABEBB','Fred SPRL'));
$service->addTransaction(new WikiTransaction('fred&aa @ ezez1', 123.45,'BE14665349856987','GEBABEBB','transaction '.$i++));
$service->addTransaction(new WikiTransaction('fred&aa @ ezez2', 123.45,'BE14665349856987','GEBABEBB','transaction '.$i++));
$service->addTransaction(new WikiTransaction('fred&aa @ ezez3', 123.45,'BE14665349856987','GEBABEBB','transaction '.$i++));

$filename='./export-'.date("Ymdhi").'.xml';

file_put_contents($filename, $service->export());
