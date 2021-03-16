<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?>
<section>
    <header>
        <h3>You need to be logged in to place an order</h3>
    </header>
    <ul>
        <li><a href="<?= $_SERVER['PHP_SELF']; ?>?account=true">I have an account</a></li>
        <li><a href="<?= $_SERVER['PHP_SELF']; ?>?account=false">I do not have an account</a></li>
    </ul>
</section>

