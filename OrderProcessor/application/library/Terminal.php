<?php
/**
 * Terminal configuration (implements Singleton pattern)
 * Centralized pricing management ocurrs through this class
 */
class Terminal
{

    /**
     * @var Singleton instance
     */
    private static $instance;

    /**
     * Explicit constructor to prevent auto-init
     */
    function __construct()
    {
        //NOOP
    }

    /**
     * @static
     * @return mixed
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $priceArray
     * @return mixed
     */
    public function getPricing($priceArray)
    {
        if (isset($_SESSION['customPricing'])) {
            return $_SESSION['customPricing'][$priceArray];
        }
        return $GLOBALS['pricingConfig'][$priceArray];
    }

    /**
     * @param $priceArray
     * @param $priceConfig
     */
    public function setPricing($priceArray, $priceConfig)
    {
        if (!self::hasCustomPricing()) {
            $_SESSION['customPricing'] = array();
        }
        $_SESSION['customPricing'][$priceArray] = $priceConfig;
    }

    /**
     * @return bool
     */
    public function hasCustomPricing()
    {
        return isset($_SESSION['customPricing']);
    }

    /**
     * @param $itemID
     * @param $amount
     * @param $price
     * @return mixed
     * @throws Exception
     */
    public function addVolumePricing($itemID, $amount, $price)
    {
        if (!is_numeric($price) || is_nan($amount) || !is_string($itemID) || is_numeric($itemID)) {
            throw new Exception("Volume discount price, amount and item ID must be valid values");
        }

        $volumeDiscount = array(
            $amount => $price
        );

        array_push($GLOBALS['pricingConfig']['volumePricing'][$itemID], $volumeDiscount);

        return print_r($GLOBALS['pricingConfig']['volumePricing'], true);
    }

    /**
     * @param $itemID
     * @param $price
     * @return mixed
     * @throws Exception
     */
    public function addSinglePricing($itemID, $price)
    {
        if (!is_numeric($price) || !is_string($itemID) || is_numeric($itemID)) {
            throw new Exception("Item ID must be a string & item price must be a valid decimal amount");
        }

        $pricingConfig = self::getPricing('singleItemPricing');

        $pricingConfig[$itemID] = $price;

        self::setPricing('singleItemPricing', $pricingConfig);

        return print_r($pricingConfig, true);
    }
}