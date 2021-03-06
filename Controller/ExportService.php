<?php

namespace NanitEu\SepaCreditXMLTransfer\Controller;

use Exception;
use NanitEu\SepaCreditXMLTransfer\Entity\Debtor;
use NanitEu\SepaCreditXMLTransfer\Entity\Initation;
use NanitEu\SepaCreditXMLTransfer\Entity\Transaction;
use NanitEu\SepaCreditXMLTransfer\Exception\InvalidDebtorException;
use NanitEu\SepaCreditXMLTransfer\Exception\XmlValidationException;
use NanitEu\SepaCreditXMLTransfer\Models\TransactionModel;
use NanitEu\SepaCreditXMLTransfer\Models\TransactionModelInterface;

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
class ExportService
{
    /**
     * @var Transaction[] Transaction list
     */
    private $transactions;
    /** @var $debtor Debtor : Debtor informations */
    private $debtor;

    function __construct(Debtor $debtor)
    {
        $this->transactions = [];
        if ($debtor->isValid()) {
            $this->debtor = $debtor;
        } else {
            throw new InvalidDebtorException('Invalid Debtor', Debtor::DEBTOR_INVALID);
        }
    }

    /**
     * Add a transaction to transactions list
     * @param TransactionModelInterface $transaction
     * @return bool Successfully add transaction
     */
    function addTransaction(TransactionModelInterface $transaction)
    {
        if ($transaction->isValid()) {
            array_push($this->transactions, $transaction);
            return true;
        } else {
            return false;
        }
    }

    function export($batchId = null)
    {
        if (is_null($batchId))
            $batchId = date("Ymdhi");
        $sepa = new Initation($batchId);
        $sepa->setDebtor($this->debtor);
        if (count($this->transactions) > 0) {
            /**
             * @var TransactionModel $transaction
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
        try {
            $sepa->validateXML();
            return $sepa->getXML();
        } catch (Exception $e) {
            throw new XmlValidationException('Validation Error', 0, $e);
        }

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