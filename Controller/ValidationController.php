<?php

namespace NanitEu\SepaCreditXMLTransfer\Controller;

class ValidationController
{
/**
 * Validates IBAN
 */
public static function validateIBAN($str)
{
    $ibanCountryLength        = array();
    $ibanCountryLength['NL']    = 18;
    $ibanCountryLength['DE']    = 22;
    $ibanCountryLength['BE']    = 16;
    $ibanCountryLength['AD']     = 24;
    $ibanCountryLength['BA']     = 20;
    $ibanCountryLength['BG']     = 22;
    $ibanCountryLength['CY']     = 28;
    $ibanCountryLength['DK']     = 18;
    $ibanCountryLength['EE']    = 20;
    $ibanCountryLength['FO']     = 18;
    $ibanCountryLength['FI']    = 18;
    $ibanCountryLength['FR']    = 27;
    $ibanCountryLength['GE']    = 22;
    $ibanCountryLength['GI']     = 23;
    $ibanCountryLength['GR']    = 27;
    $ibanCountryLength['GL']     = 18;
    $ibanCountryLength['HU']     = 28;
    $ibanCountryLength['IE']     = 22;
    $ibanCountryLength['IS']     = 26;
    $ibanCountryLength['IL']     = 22;
    $ibanCountryLength['IT']     = 27;
    $ibanCountryLength['HR']    = 21;
    $ibanCountryLength['LV']     = 21;
    $ibanCountryLength['LB']     = 28;
    $ibanCountryLength['LI']     = 21;
    $ibanCountryLength['LT']     = 20;
    $ibanCountryLength['LU']     = 20;
    $ibanCountryLength['MK']     = 19;
    $ibanCountryLength['MT']     = 31;
    $ibanCountryLength['MC']     = 27;
    $ibanCountryLength['ME']     = 22;
    $ibanCountryLength['NO']     = 15;
    $ibanCountryLength['AT']     = 20;
    $ibanCountryLength['PL']     = 28;
    $ibanCountryLength['PT']     = 25;
    $ibanCountryLength['RO']     = 24;
    $ibanCountryLength['SM']     = 27;
    $ibanCountryLength['SA']     = 24;
    $ibanCountryLength['RS']     = 22;
    $ibanCountryLength['SK']     = 24;
    $ibanCountryLength['SI']     = 19;
    $ibanCountryLength['ES']     = 24;
    $ibanCountryLength['CZ']     = 24;
    $ibanCountryLength['TR']     = 26;
    $ibanCountryLength['TN']     = 24;
    $ibanCountryLength['GB']     = 22;
    $ibanCountryLength['AE']     = 23;
    $ibanCountryLength['SE']     = 24;
    $ibanCountryLength['CH']     = 21;

    $regexvalid            = preg_match("/^[A-Z]{2,2}[0-9]{2,2}[a-zA-Z0-9]{1,30}$/", $str);
    if (!$regexvalid) {
        return false;
    }

    // validate country code & length
    $country            = substr($str, 0, 2);
    $checkDigits        = substr($str, 2, 2);
    if (!isset($ibanCountryLength[$country])) {
        return false;
    }

    if (strlen($str) != $ibanCountryLength[$country]) {
        return false;
    }

    // calculate IBAN check digits
    $checkstr            = substr($str, 4).substr($str, 0, 2)."00";
    // replace A-Z by numbers
    for ($char='A',$num=10; $num<=35; $char++,$num++) {
        $checkstr         = str_replace($char, $num, $checkstr);
    }
    // remove leading
    $checkstr            = ltrim($checkstr, '0');
    // calculate iban mod 97 without using large integers
    $ibanN                     = substr($checkstr, 0, 9);
    $ibanD                     = substr($checkstr, 9);
    $mod                 = 0;
    while (1) {
        $mod             = ((int)$ibanN) % 97;

        if (strlen($ibanD) > 0) {
            $ibanN             = $mod.substr($ibanD, 0, 7);
            $ibanD             = substr($ibanD, 7);
        } else {
            break;
        }
    }

    // check digit is 98 - iban mod 97
    $calc_check_digit    = 98-$mod;

    // check if check digits match
    if ($calc_check_digit != $checkDigits) {
        return false;
    }

    return true;
}
public static function validateBIC($str)
{
    $regexvalid            = preg_match("/^[A-Z]{6,6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3,3}){0,1}$/", $str);
    return $regexvalid;
}

}