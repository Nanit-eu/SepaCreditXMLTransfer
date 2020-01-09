<?php

namespace Nanit\SepaCreditXMLTransfer\Controller;

use http\Client\Response;
use Nanit\SepaCreditXMLTransfer\Entity\Debtor;
use Nanit\SepaCreditXMLTransfer\Entity\Initation;
use Nanit\SepaCreditXMLTransfer\Entity\Transaction;

/**
 * Class ExportService
 *
 * Create service :
 * new ExportService(new Debtor('DEBTOR_IBAN_NUMBER','DEBTOR_BIC_NUMBER','DEBTOR_NAME'));
 *
 * Add transactions :
 * ->addTransaction(MyTransaction);
 * MyTransaction must extends Nanit\SepaCreditXMLTransfer\Models\TransactionModel
 *
 *  get XML sepa file with :
 *        $service->export();
 *
 * @package Nanit\SepaCreditXMLTransfer\Controller
 */
class ExportService {
    /**
     * @var Transaction[] Transaction list
     */
    private $transactions;
    /** @var $debtor Debtor : Debtor informations */
    private $debtor;

    function __construct(Debtor $debtor)
    {
        $this->transactions=[];
        if($debtor->isValid())
        {
            $this->debtor=$debtor;
        }
        else
        {
            $this->debtor = new Debtor('BE13001319659839', 'GEBABEBB', 'Fred');
        }
    }
    function addTransaction( \Nanit\SepaCreditXMLTransfer\Models\TransactionModel $transaction)
    {
        array_push($this->transactions,$transaction);
    }

    function export($batchId=null)
    {
        if(is_null($batchId))
            $batchId=date("Ymdhi");
        $sepa = new Initation($batchId);
        $sepa->setDebtor($this->debtor);
        if (count($this->transactions) > 0) {
            /**
             * @var \Nanit\SepaCreditXMLTransfer\Models\TransactionModel $transaction
             */
            foreach ($this->transactions as $transaction) {
                $sepa_transaction = new Transaction(
                    $transaction->getName(),
                    $transaction->getAmount(),
                    $transaction->getIban(),
                    $transaction->getBic(),
                    $transaction->getCom(),
                    $transaction->getE2E()
                );
                $sepa->addTransaction($sepa_transaction);
            }
        }
            $sepa->build();
            if($sepa->validateXML())
                return $sepa->getXML();
            //else throw new Exception('Error');

    }

    /*
    function htmlResponse() {

        if ($sepa->validateXML() === true) {
            $date= new \DateTime();
            header('Content-Disposition: attachment; filename="sepaxls_'
                . date_format($date, 'Ymd') . '.xml"');
            header("Content-Type:text/xml");
            print($sepa->getXML());
            // avoid every subsequent outputs
            die();
        } else {
            $response = new Response("<textarea style='width:100%;height:250px'>".$sepa->getXML()."</textarea>");
            return $response;

        }
    }
    */
}