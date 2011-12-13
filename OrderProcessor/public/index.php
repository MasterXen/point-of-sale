<?php

require_once(realpath(dirname(__FILE__) . "/../application/Configuration.php"));

require_once(LIBRARY_PATH . '/Templating.php');

// Must pass in variables (as an array) to use in template
$variables = array(
    'savedOrders' => array(
        'ABCDABAA',
        'CCCCCCC',
        'ABCD',
        'AAAAAAA'
    )
);

if (isset($_GET["orderInput"])) {
    $orderInput = str_split($_GET['orderInput']);
    $order = new Order();

    try {
        foreach ($orderInput as $lineItemAsString) {
            $order->addLineItem($lineItemAsString);
        }
    } catch (Exception $orderException) {
        $variables['error'] = $orderException->getMessage();
    }

    $variables['processedInput'] = $_GET['orderInput'];
    $variables['invoice'] = $order->printInvoice();
} else if (isset($_GET["singleItemID"]) && isset($_GET["singleItemPrice"])) {

    try {
        $currentTerminal = Terminal::getInstance();
        $pricingSnapshot = $currentTerminal->addSinglePricing($_GET["singleItemID"], $_GET["singleItemPrice"]);
    } catch (Exception $pricingException) {
        $variables['error'] = $pricingException->getMessage();
    }

    if (isset($pricingSnapshot)) {
        $variables['pricingSnapshot'] = $pricingSnapshot;
    }
}

renderLayoutWithContentFile("home.php", $variables);
?>