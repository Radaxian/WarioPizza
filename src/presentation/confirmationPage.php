<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?><header>
    <h2>Order overview</h2>
</header>
<section id="orderConfirmation">
    <header>
        <h3>Delivery details</h3>
    </header>
    <ul>
        <li><?= $customer->getFirstname().' '.$customer->getSurname(); ?></li>
        <li><?= $deliveryAddress->getAddress(); ?></li>
        <li><?= $postcode->getPostcode(); ?></li>
    </ul>
</section>
<section>
    <header>
        <h3>Order details</h3>
    </header>
    <ul>
        <?php foreach ($basket as $item) : ?>
            <li><?= $item->getTitle().' &euro;'.number_format($item->getPrice(), 2) ?></li>
        <?php endforeach; ?>
        <li>Discount: &euro;<?= number_format($discountAmount, 2); ?></li>
        <li>Order Total: &euro;<?= number_format($orderTotal, 2); ?></li>
    </ul>
</section>
<h2 id="thankyouMessage">Thankyou for your order</h2>
<?php require_once __DIR__ . '/foot.php';