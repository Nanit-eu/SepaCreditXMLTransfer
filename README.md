
sepa-credit-xml-transfer
========================

## Install
```
composer require nanit-eu/sepa-credit-xml-transfer
```
##Usage
```
$service = new ExportService(new Debtor('BE13001123456789','GEBABEBB','Nanit SPRL'));
$service->addTransaction(new MyTransaction('M A Dupont', 123.45,'BE13001123456789','GEBABEBB','123-1234-123 '));
$file=$service->export()
```

## External Resources

* [Febelfin standard-credit_transfer-xml](https://www.febelfin.be/sites/default/files/2019-04/standard-credit_transfer-xml-v32-en_0.pdf)