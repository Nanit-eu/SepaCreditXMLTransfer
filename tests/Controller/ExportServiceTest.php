<?php

namespace App\Tests\Controller;

use NanitEu\SepaCreditXMLTransfer\Controller\ExportService;
use NanitEu\SepaCreditXMLTransfer\Entity\Debtor;
use NanitEu\SepaCreditXMLTransfer\Example\MyTransaction;
use NanitEu\SepaCreditXMLTransfer\Exception\InvalidDebtorException;
use NanitEu\SepaCreditXMLTransfer\Exception\XmlValidationException;
use PHPUnit\Framework\TestCase;

class ExportServiceTest extends TestCase
{
    public function testValidateIBAN()
    {
        $debtor= new Debtor('test','BE1300131965983','GEBABEBB');
        $this->assertFalse($debtor->isValid());
        try{
            $service=new ExportService($debtor);
            $this->assertTrue($service instanceof ExportService ,'Checking if $service is an instance of ExportService');
        } catch (InvalidDebtorException $e) {
            $this->assertTrue( $e instanceof InvalidDebtorException, 'InvalidDebtorException was raised while instanciate ExportService with bad Debtor');
            $this->assertEquals(Debtor::DEBTOR_INVALID, $e->getCode(), 'Check InvalidDebtorException error code');
        }
        $debtor->setOrgName('test');
        $debtor->setOrgIban('BE13001319659839');
        $debtor->setOrgBic('GEBABEBB');
        $this->assertTrue($debtor->isValid());
        try{
            $service=new ExportService($debtor);
            $this->assertTrue($service instanceof ExportService ,'Checking if $service is an instance of ExportService');

        $transaction= new MyTransaction('test name', 2.54, 'BE13001319659839', 'GEBABEBB', 'transaction 1');
        $this->assertTrue($transaction->isValid());
        $this->assertTrue($service->addTransaction($transaction));
        $xml=$service->export();
        $this->assertContains('<NbOfTxs>1</NbOfTxs>',$xml);
        $this->assertContains('<IBAN>BE13001319659839</IBAN>',$xml);
        $this->assertContains('<BIC>GEBABEBB</BIC>',$xml);
        $this->assertContains('<InstdAmt Ccy="EUR">2.54</InstdAmt>',$xml);
        $this->assertContains('<Ustrd>transaction 1</Ustrd>',$xml);

        $this->assertFalse($service->addTransaction(new MyTransaction('test name', 0, 'BE13001319659839', 'GEBABEBB', 'transaction 1')));
        $xml=$service->export();
        $this->assertContains('<NbOfTxs>1</NbOfTxs>',$xml);
        $this->assertFalse($service->addTransaction(new MyTransaction('test name', 50, 'BE1300131965839', 'GEBABEBB', 'transaction 1')));
        $xml=$service->export();
        $this->assertContains('<NbOfTxs>1</NbOfTxs>',$xml);
        $this->assertTrue($service->addTransaction(new MyTransaction('test name', 50, 'BE13001319659839', 'GEBABEBB', 'transaction 2')));
        $xml=$service->export();
        $this->assertContains('<NbOfTxs>2</NbOfTxs>',$xml);
        $this->assertContains('<InstdAmt Ccy="EUR">50</InstdAmt>',$xml);
        $this->assertContains('<Ustrd>transaction 2</Ustrd>',$xml);
        } catch (InvalidDebtorException $e) {
            $this->assertFalse(true ,'Exception was raised while instantiate ExportService');
        } catch (XmlValidationException $e) {
            $this->assertFalse(true ,'Check if output is valid');
        }
    }
}