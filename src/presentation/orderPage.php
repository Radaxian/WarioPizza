<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?><div class="grid">
    <div id="menu">
        <ul id="pizzas">
        <?php foreach ($menu as $item) : ?>
            <li class="pizza">
                <img src="./public/images/<?= $item->getImage();?>.png" alt="a pizza">
                <div class="pizzaDetails">
                    <h2><?= $item->getTitle(); ?></h2>
                    <p><?= $item->getDescription(); ?></p>
                    <?php if ($item->getDiscount() > 0) : ?>
                        <?php 
                            $discount = 100 - ($item->getDiscount() * 100); 
                            echo "<p id='discount'>$discount% OFF</p>"
                        ?>
                    <?php endif; ?>
                </div>
                <p>&euro;<?= number_format($item->getPrice(),2); ?></p>
                <a href="<?= $_SERVER['PHP_SELF']; ?>?pizza=<?= $item->getProductId(); ?>">add</a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div id="basket">
        <header>
            <h3>Basket</h3>
        </header>
        <?php if ((isset($basket)) && (count($basket)) > 0) : ?>
            <ul>
            <?php foreach ($basket as $item) : ?>
                <li class="basketItem">
                    <span><?= $item->getTitle(); ?></span>
                    <span>&euro;<?= number_format($item->getPrice(), 2); ?></span>
                    <a href="<?php $_SERVER['PHP_SELF']; ?>?remove=<?= $item->getProductId(); ?>">remove</a>
                </li>
            <?php endforeach; ?>
                <li>Discount: &euro;<?= number_format($discountAmount, 2); ?></li>
                <li>Subtotal: &euro;<?= number_format($orderTotal, 2); ?></li>
            </ul>
            
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="command" value="checkout">
                <button>checkout</button>
            </form>
        <?php else : ?>
            <p>basket is empty</p>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/foot.php';