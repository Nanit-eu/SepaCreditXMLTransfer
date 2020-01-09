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
}