<?php

namespace NanitEu\SepaCreditXMLTransfer\Entity;

use NanitEu\SepaCreditXMLTransfer\Controller\ValidationController;

class Debtor
{

    const DEBTOR_INVALID = '100';

    public $orgName             = null;
    public $orgIban             = null;
    public $orgBic            = null;

    /**
     * Debtor constructor.
     * @param string $orgIban
     * @param string $orgBic
     * @param string $orgName
     */
    public function __construct(string $orgIban, string  $orgBic, string $orgName)
    {
        if(isset($orgIban)) {
            $this->orgIban = $orgIban;
        }
        if(isset($orgBic)) {
            $this->orgBic = $orgBic;
        }
        if(isset($orgName)) {
            $this->orgName = $orgName;
        }
    }

    /**
     * check Debtor validity
     *
     * @return bool
     */
    function isValid() {
        if(! ValidationController::validateBIC($this->getOrgBic()))
            return false;
        if(! ValidationController::validateIBAN($this->getOrgIban()))
            return false;
        if( empty($this->getOrgName()))
            return false;
        return true;
    }

    /**
     * @return null
     */
    public function getOrgName()
    {
        return $this->orgName;
    }

    /**
     * @param null $orgName
     * @return Debtor
     */
    public function setOrgName($orgName)
    {
        $this->orgName = $orgName;
        return $this;
    }

    /**
     * @return null
     */
    public function getOrgIban()
    {
        return $this->orgIban;
    }

    /**
     * @param null $orgIban
     * @return Debtor
     */
    public function setOrgIban($orgIban)
    {
        $this->orgIban = $orgIban;
        return $this;
    }

    /**
     * @return null
     */
    public function getOrgBic()
    {
        return $this->orgBic;
    }

    /**
     * @param null $orgBic
     * @return Debtor
     */
    public function setOrgBic($orgBic)
    {
        $this->orgBic = $orgBic;
        return $this;
    }

}
