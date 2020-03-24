<?php

namespace App\Tests\Controller;

use NanitEu\SepaCreditXMLTransfer\Controller\ValidationController;
use PHPUnit\Framework\TestCase;

class ValidationControllerTest extends TestCase
{
    public function testValidateIBAN()
    {
        $this->assertTrue(ValidationController::validateIBAN('BE13001319659839'));
        $this->assertFalse(ValidationController::validateIBAN('DE13001319659839'));
        $this->assertFalse(ValidationController::validateIBAN('BE13001329659838'));
        $this->assertFalse(ValidationController::validateIBAN('BE1300131965983'));
        $this->assertFalse(ValidationController::validateIBAN('BE14665349856987'));
    }

    public function testValidateBIC()
    {
        $this->assertTrue(ValidationController::validateBIC('GEBABEBB'));
        $this->assertFalse(ValidationController::validateBIC('GEBABEB'));
        $this->assertFalse(ValidationController::validateBIC('GEBABEBBGEBABEBB'));
    }

}