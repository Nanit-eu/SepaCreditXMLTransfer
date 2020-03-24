<?php

namespace NanitEu\SepaCreditXMLTransfer\Models;

interface TransactionModelInterface
{
    public function getName();
    public function getIban();
    public function getBic();
    public function getCom();
    public function getE2E();
    public function getAmount();
    /**
     * Check if transaction has been provided with needed data and is ready to be exported
     *
     * @return bool
     */
    public function isValid();
}