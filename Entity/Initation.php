<?php

namespace Nanit\SepaCreditXMLTransfer\Entity;


class Initation
{
    private $xml;
    private $transactions = array();
    private $msgid;
    private $transid;

    /** @var Debtor Debtor informations */
    private $debtor;

    private $batchBooking        = null;

    public function __construct($msgid, $transid = null)
    {
        $this->xml             = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>
            <Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.001.001.03" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <CstmrCdtTrfInitn>
            </CstmrCdtTrfInitn>
        </Document>');

        $this->msgid            = $msgid;
        if ($transid) {
            $this->transid        = $transid;
        } else {
            $this->transid        = $msgid;
        }
    }

    public function setDebtor(Debtor $debtor)
    {
        $this->debtor = $debtor;
    }

    public function addTransaction(Transaction $t, $group = 0)
    {
        if (!isset($this->transactions[$group])) {
            $this->transactions[$group] = array();
        }
        $this->_groups[$group]=$this->debtor;
        $this->transactions[$group][]    = $t;
    }

    private function addGroupHeader()
    {
        $header                 = $this->xml->CstmrCdtTrfInitn->addChild('GrpHdr');

        $header->addChild('MsgId', $this->msgid);
        $header->addChild('CreDtTm', strftime("%FT%T"));
        $nbOfTxs                 = 0;
        foreach ($this->transactions as $trans) {
            $nbOfTxs            += count($trans);
        }

        $header->addChild('NbOfTxs', $nbOfTxs);


        $initgPty                = $header->addChild('InitgPty');
        $initgPty->addChild('Nm', $this->debtor->getOrgName());
    }

    private function addTransactions()
    {
        foreach ($this->transactions as $group => $trans) {
            $pmtinf                 = $this->xml->CstmrCdtTrfInitn->addChild('PmtInf');
            $pmtinf->addChild('PmtInfId', $this->transid);
            $pmtinf->addChild('PmtMtd', 'TRF');
            $pmtinf->addChild('BtchBookg', 'false');

            if ($this->batchBooking !== null) {
                $pmtinf->addChild('BtchBookg', $this->batchBooking===true?'true':'false');
            }

            $pmtinf->addChild('NbOfTxs', count($trans));

            $pmtinf->addCHild('ReqdExctnDt', strftime("%F"));

            $Dbtr                    = $pmtinf->addChild('Dbtr');
            $DbtrAcct                = $pmtinf->addChild('DbtrAcct');
            $DbtrAgt                = $pmtinf->addChild('DbtrAgt');

            $Dbtr->addChild('Nm', $this->debtor->getOrgName());
            $DbtrAcct->addChild('Id')->addChild('IBAN', $this->debtor->getOrgIban());
            $DbtrAcct->addChild('Ccy', 'EUR');

            $DbtrAgt->addChild('FinInstnId')->addChild('BIC', $this->debtor->getOrgBic());

            foreach ($trans as $key => $t) {
                $CdtTrfTxInf            = $pmtinf->addChild('CdtTrfTxInf');
                $tid                     = $this->transid.'-'.$group."-".$key;
                if(isset($t->transaction_id))
                {
                    $tid                .= "-".$t->transaction_id;
                }
                $tid .='-'. $t->end_to_end;

                $CdtTrfTxInf->addChild('PmtId')->addChild('EndToEndId', $tid);
                $CdtTrfTxInf->addChild('Amt')->addChild('InstdAmt', $t->amount)->addAttribute('Ccy', 'EUR');
                $CdtTrfTxInf->addChild('CdtrAgt')->addChild('FinInstnId')->addChild('BIC', $t->bic);

                $Cdtr                    = $CdtTrfTxInf->addChild('Cdtr');
                $Cdtr->addChild('Nm', $t->name);

                $CdtrAcct                = $CdtTrfTxInf->addChild('CdtrAcct');
                $CdtrAcct->addChild('Id')->addChild('IBAN', $t->iban);

                if (strlen($t->descr) > 0) {
                    $RmtInf                    = $CdtTrfTxInf->addChild('RmtInf');
                    $RmtInf->addChild('Ustrd', substr($t->descr, 0, 140)); // maximale lengte 140 karakters
                }
            }
        }
    }

    public function build()
    {
        $this->addGroupHeader();
        $this->addTransactions();
    }

    public function getXML()
    {
//        return $this->_xml->asXML();
        return str_replace('><', ">\n<", $this->xml->asXML());
    }
    public function validateXML()
    {
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadXML(str_replace('><', ">\n<", $this->xml->asXML()));
        $res=$doc->schemaValidate(dirname(__FILE__).'/pain.001.001.03.xsd');
        $errors=libxml_get_errors();
        if ($res) {
            return $res;
        } else {
            var_dump($errors);
            throw new \Exception( $errors[0]);
        }
    }
}