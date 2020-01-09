<?php

namespace NanitEu\SepaCreditXMLTransfer\Entity;


class Transaction
{
    public $amount;

    public $bic;
    public $iban;
    public $name;
    public $descr;
    public $end_to_end;
    public $transactionId    = null;
    private $decode_html_entities = true;

    /**
     *
     * @param string $name
     * @param float $amount
     * @param string $iban
     * @param string $bic
     * @param string $descr
     * @param string $end_to_end
     * @param bool $decode_html_entities
     */
    public function __construct($name, $amount, $iban, $bic, $descr = '', $end_to_end=null, $decode_html_entities = true)
    {
        $this->decode_html_entities=$decode_html_entities;
        $this->setAmount($amount)
             ->setBic($bic)
            ->setIban($iban)
            ->setName($name)
            ->setDescr($descr)
            ->setE2E($end_to_end);
    }

    /**
     * @param float $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $bic
     * @return Transaction
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @param string $iban
     * @return Transaction
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @param string|string[]|null $name
     * @return Transaction
     */
    public function setName($name)
    {
        $name= str_replace(
            array('@', '&'),
            '',
            $name
        );
        if ($this->decode_html_entities) {
            $name             = html_entity_decode($name, ENT_COMPAT, 'UTF-8');
        }


        // filter non-valid characters from name and description. translate special characters
        $name                = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $allow_regex        = "/[^a-zA-Z0-9-\.\+\/\? ]+/";
        $name                = preg_replace($allow_regex, "", $name);
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|string[]|null $descr
     * @return Transaction
     */
    public function setDescr($descr)
    {

        if ($this->decode_html_entities) {
            $descr            = html_entity_decode($descr, ENT_COMPAT, 'UTF-8');
        }
        $descr                = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $descr);
        $allow_regex        = "/[^a-zA-Z0-9-\.\+\/\? ]+/";
        $descr                = preg_replace($allow_regex, "", $descr);
        $this->descr = $descr;
        return $this;
    }

    /**
     * @param null $transactionId
     * @return Transaction
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    /**
     * @param mixed $E2E
     * @return Transaction
     */
    public function setE2E($E2E)
    {
        $this->end_to_end = $E2E;
        return $this;
    }

}