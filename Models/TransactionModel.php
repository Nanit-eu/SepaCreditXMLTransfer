<?php

namespace Nanit\SepaCreditXMLTransfer\Models;

abstract class TransactionModel {
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


}