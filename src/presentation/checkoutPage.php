<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?>
<div class="equalGrid">
    <section id="customerDetails">
        <header>
            <h3>Customer details</h3>
        </header>
        
        <ul>
            <li><?= htmlentities($customer->getFirstname(), ENT_QUOTES); ?></li>
            <li><?= htmlentities($customer->getSurname(), ENT_QUOTES); ?></li>
            <li><?= htmlentities($customer->getPhone(), ENT_QUOTES); ?></li>
        </ul>
    </section>

    <section>
        <header>
            <h3>Delivery address</h3>
            <a href='<?= $_SERVER['PHP_SELF']; ?>?changeAddress=true'>change</a>
        </header>
        <ul>
            <li>
                <?php if ((isset($deliveryPossible)) && ($deliveryPossible)) : ?>
                    <?= htmlentities($deliveryAddress->getAddress(), ENT_QUOTES).' '.$postcode->getPostcode()?>
                <?php else : ?>
                    <?= "Sorry, delivery is not possible to your address"; ?> 
                <?php endif; ?>
            </li>
        </ul>
    </section>
    <?php if ((isset($showAddressForm)) && ($showAddressForm === true)) : ?>
        <section id="changeAddress">
            <header>
                <h3>Change address</h3>
            </header>
            
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="token" value="<?= $token; ?>">
                <ul>
                    <li><label for="address">Address</label> <input name="address" id="address" type="text" required></li>
                    <li>
                        <label for="">Postcode</label>
                        <select name="postcode" id="">
                            <?php foreach ($postcodes as $postcode) : ?>
                                <option name="" value="<?= $postcode->getPostcodeId(); ?>"><?= $postcode->getPostcode(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </li>
                </ul>
                <input type="hidden" name="command" value="changeAddress">
                <button>choose</button>
            </form>
        </section>
    <?php endif; ?>

    <section id="basket">
        <header>
            <h3>Order details</h3>
            <a href="orderPageController.php?edit=true">edit order</a>
        </header>
        <!-- <form action="<?php //$_SERVER['PHP_SELF']; ?>" method="POST"> -->
            <ul>
            <?php foreach ($basket as $item) : ?>
                <li class="basketItem">
                    <p><?= $item->getTitle(); ?></p>
                    <p>&euro;<?= number_format($item->getPrice(), 2); ?></p>
                </li>
            <?php endforeach; ?>
                <li>Discount: &euro;<?= number_format($discountAmount, 2); ?></li>
                <li>Subtotal: &euro;<?= number_format($orderTotal, 2); ?></li>
            </ul>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="command" value="checkout">
                <?php if ((isset($deliveryPossible)) && ($deliveryPossible)) : ?>
                    <button>checkout</button>
                <?php endif; ?>
            </form>
        <!-- </form> -->
    </section>

    
</div> 
<?php require_once __DIR__ . '/foot.php';
