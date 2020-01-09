<?php
use Nanit\SepaCreditXMLTransfer\Models\TransactionModel;

class WikiTransaction extends TransactionModel {
    function __construct($name,$amount,$iban,$bic,$com)
    {
        $this->setName($name)
            ->setAmount($amount)
            ->setIban($iban)
            ->setBic($bic)
            ->setCom($com);
    }

    /**
     * @param mixed $Name
     * @return TransactionModel
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @param mixed $Iban
     * @return TransactionModel
     */
    public function setIban($Iban)
    {
        $this->Iban = $Iban;
        return $this;
    }

    /**
     * @param mixed $Bic
     * @return TransactionModel
     */
    public function setBic($Bic)
    {
        $this->Bic = $Bic;
        return $this;
    }

    /**
     * @param mixed $Com
     * @return TransactionModel
     */
    public function setCom($Com)
    {
        $this->Com = $Com;
        return $this;
    }

    /**
     * @param mixed $E2E
     * @return TransactionModel
     */
    public function setE2E($E2E)
    {
        $this->E2E = $E2E;
        return $this;
    }

    /**
     * @param mixed $Amount
     * @return TransactionModel
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
        return $this;
    }

}
