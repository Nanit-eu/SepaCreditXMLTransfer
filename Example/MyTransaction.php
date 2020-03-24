<?php

use NanitEu\SepaCreditXMLTransfer\Controller\ValidationController;
use NanitEu\SepaCreditXMLTransfer\Models\TransactionModel;
use NanitEu\SepaCreditXMLTransfer\Models\TransactionModelInterface;

class MyTransaction extends TransactionModel implements TransactionModelInterface {
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
     * @return MyTransaction
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @param mixed $Iban
     * @return MyTransaction
     */
    public function setIban($Iban)
    {
        $this->Iban = $Iban;
        return $this;
    }

    /**
     * @param mixed $Bic
     * @return MyTransaction
     */
    public function setBic($Bic)
    {
        $this->Bic = $Bic;
        return $this;
    }

    /**
     * @param mixed $Com
     * @return MyTransaction
     */
    public function setCom($Com)
    {
        $this->Com = $Com;
        return $this;
    }

    /**
     * @param mixed $E2E
     * @return MyTransaction
     */
    public function setE2E($E2E)
    {
        $this->E2E = $E2E;
        return $this;
    }

    /**
     * @param mixed $Amount
     * @return MyTransaction
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
        return $this;
    }

}
