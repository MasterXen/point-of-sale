<?php

defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

global $pricingConfig;

$pricingConfig = array(
    'singleItemPricing' => array(
        'A' => 2.00,
        'B' => 12.00,
        'C' => 1.25,
        'D' => 0.15
    ),
    'volumePricing' => array(
        'A' => array(
            4 => 7.00
        ),
        'C' => array(
            6 => 6.00
        )
    )
);

/*
	Initialize PHP SessionID (for custom pricing)
*/
session_start();

/*
	Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL);

?>