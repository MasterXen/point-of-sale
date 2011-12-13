<?php

/**
 *
 */
class LineItem
{
    /**
     * @var
     */
    private $itemID;

    /**
     * @param $itemID
     */
    public function setItemID($itemID)
    {
        $this->itemID = $itemID;
    }

    /**
     * @return mixed
     */
    public function getItemID()
    {
        return $this->itemID;
    }

    /**
     * @param $itemID
     */
    function __construct($itemID)
    {
        if (!array_key_exists($itemID, Terminal::getInstance()->getPricing('singleItemPricing'))) {
            throw new LogicException("Unable to add an unknown item to the order: {$itemID}");
        }

        $this->setItemID($itemID);
    }
}
