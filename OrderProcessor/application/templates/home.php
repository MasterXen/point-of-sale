<div class="container">

    <div class="content">
        <div class="page-header">
            <h1>Point of Sale Terminal</h1>
        </div>
        <div class="row">
            <div class="span10">

                <?php

                if (isset ($error)) {
                    echo "<div class='alert-message error'><p><strong>Processing failed!</strong><br />{$error}</p></div>";
                } elseif (isset ($invoice)) {
                    /** @var $processedInput string */
                    echo "<div class='alert-message success'><p><strong>Order processed successfully!</strong><br />The order total for {$processedInput} is <em>\${$invoice}</em></p></div>";
                } elseif (isset ($pricingSnapshot)) {
                    /** @var $processedInput string */
                    echo "<div class='alert-message success'><p><strong>Pricing updated successfully!</strong><br />Current pricing is: {$pricingSnapshot}</p></div>";
                }

                ?>

                <h2>SAVED ORDERS
                    <span class="label">Default</span>
                </h2>

                <form method="GET" class="form-stacked" action="">
                    <fieldset>
                        <div class="clearfix">
                            <label id="optionsRadio">Re-run past orders</label>

                            <div class="input">
                                <ul class="inputs-list">

                                    <?php

                                    /** @var $savedOrders array */
                                    foreach ($savedOrders as $order) {
                                        echo "<li><label><input type='radio' name='orderInput' value='{$order}'><strong>{$order}</strong></label></li>";
                                    }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </fieldset>
                    <div class="actions">
                        <button type="submit" class="btn large primary">Process Order</button>
                        &nbsp;
                        <button type="reset" class="btn large">Cancel</button>
                    </div>
                </form>

                <h2 style="margin-top: 30px">NEW ORDERS
                    <span class="label success">New</span>
                </h2>

                <form action="" method="GET" class="form-stacked">
                    <fieldset>
                        <div class="clearfix">
                            <div class="input">
                                <label for="userOrderInput">Add a new order to be processed</label>
                                <input class="xlarge" id="userOrderInput" name="orderInput" size="30" type="text"
                                       value="<?= isset($processedInput) ? $processedInput : '' ?>"
                                       onclick="this.select()"/>
                            </div>
                        </div>
                    </fieldset>
                    <div class="actions">
                        <button type="submit" class="btn primary">Process Order</button>
                        &nbsp;
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>

                <h2 style="margin-top: 30px">PRICING CONFIGURATION
                    <span class="label important">Important</span>
                </h2>

                <form action="" method="GET" class="form-stacked">
                    <fieldset>
                        <legend>Append or override pricing for items</legend>
                        <div class="clearfix" style="margin-top: 20px">
                            <label for="singleItemID">Item ID&nbsp;<span class="label">string</span></label>

                            <div class="input">
                                <input class="xlarge" id="singleItemID" name="singleItemID" size="30" type="text"/>
                            </div>
                        </div>
                        <div class="clearfix">
                            <label for="singleItemPrice">Price&nbsp;<span class="label">decimal</span></label>

                            <div class="input">
                                <input class="xlarge" id="singleItemPrice" name="singleItemPrice" size="30"
                                       type="text"/>
                            </div>
                        </div>
                    </fieldset>
                    <div class="actions">
                        <button type="submit" class="btn primary">Update Pricing</button>
                        &nbsp;
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>


            </div>
            <div class="span4">
                <h3>Application Design</h3>
                <ul>
                    <li>Clean separation of design (<code>public</code> folder) and logic (<code>application</code>
                        folder)
                    </li>
                    <li>Class based business objects</li>
                    <li>Uses Twitter's open sourced <a href="http://twitter.github.com/bootstrap/" target="_blank">Bootstrap
                        toolkit</a> for layout and UI elements
                    </li>
                    <li>Exceptions are handled gracefully and are bubbled to the UI layer (for example: <a
                        href="?orderInput=FAIL">Trigger exception</a>)
                    </li>
                    <li>Pricing (both per item and volume discounts) is initialized on application start using a
                        <code>GLOBAL</code> array
                    </li>
                    <li>Pricing configuration changes are stored in <code>$_SESSION</code> (and are, of course, unique
                        to a user). After adding a new item to the pricing configuration
                        (for example: Z), the same item can then be used in a new order
                    </li>
                </ul>
                <hr/>
                <h3>Assumptions</h3>
                <ul>
                    <li>Does not support multiple volume discounts for the same item</li>
                    <li>Printing the invoice/total only requires knowing the counts of each unique item; the application
                        could just maintain
                        an incremented counter of each item. However, the assumption is that there might be some further
                        work/logic on the
                        <code>Order</code> instance so the complete <code>LineItem</code> is stored.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>