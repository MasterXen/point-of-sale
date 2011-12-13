<?php

/**
 * Initializes a new order
 */
class Order
{
    /**
     * @var array
     */
    private $lineItemsCollection = array();

    /**
     * @param $itemID
     */
    public function addLineItem($itemID)
    {
        $newLineItem = new LineItem($itemID);

        if (array_key_exists($itemID, $this->lineItemsCollection) && is_array($this->lineItemsCollection[$itemID])) {
            array_push($this->lineItemsCollection[$itemID], $newLineItem);
        } else {
            $this->lineItemsCollection[$itemID] = array(
                $itemID => $newLineItem
            );
        }
    }

    /**
     * @param array $itemsArray
     * @throws LogicException
     */
    public function addLineItems(array $itemsArray)
    {
        throw new LogicException("Function not implemented");
    }

    /**
     * @return string
     */
    public function printInvoice()
    {
        $invoiceTotal = 0;
        foreach ($this->lineItemsCollection as $itemArray) {
            $itemCount = count($itemArray);
            $itemID = array_shift(array_keys($itemArray));

            // When no volume pricing exists, perform simple multiplication
            if (!array_key_exists($itemID, $GLOBALS['pricingConfig']['volumePricing'])) {
                $pricingConfig = Terminal::getInstance()->getPricing('singleItemPricing');
                $invoiceTotal += $itemCount * $pricingConfig[$itemID];
                continue;
            } else {
                $volumePriceCollection = $GLOBALS['pricingConfig']['volumePricing'][$itemID];
                krsort($volumePriceCollection);

                foreach ($volumePriceCollection as $volumeAmount => $volumePrice) {
                    if ($volumeAmount > $itemCount) {
                        continue;
                    }

                    $invoiceTotal += $volumePrice;
                    $itemCount -= $volumeAmount;
                }

                if ($itemCount > 0) {
                    $pricingConfig = Terminal::getInstance()->getPricing('singleItemPricing');
                    $invoiceTotal += $itemCount * $pricingConfig[$itemID];
                }
            }
        }

        return number_format($invoiceTotal, 2);
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->printInvoice();
    }
}