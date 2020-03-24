<?php

namespace NanitEu\SepaCreditXMLTransfer\Models;

use NanitEu\SepaCreditXMLTransfer\Controller\ValidationController;

abstract class TransactionModel implements TransactionModelInterface
    {
    /** Name  */
    protected $Name;
    protected $Iban;
    protected $Bic;
    protected $Com;
    protected $E2E;
    protected $Amount;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->Iban;
    }

    /**
     * @return mixed
     */
    public function getBic()
    {
        return $this->Bic;
    }

    /**
     * @return mixed
     */
    public function getCom()
    {
        return $this->Com;
    }

    /**
     * @return mixed
     */
    public function getE2E()
    {
        return $this->E2E;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * Check if transaction has been provided with needed data and is ready to be exported
     *
     * @return bool
     */
    public function isValid()
    {
        return ValidationController::validateIBAN($this->getIban()) && ValidationController::validateBIC($this->getBic()) && $this->getAmount()>0;
    }

}