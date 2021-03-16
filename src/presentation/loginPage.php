<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?><section>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" id="loginForm" method="POST">
        <input type="hidden" name="token" value="<?= $token; ?>">
        <ul>
            <li>
                <label for="email">Email</label> 
                <input name ="email" id="email" type="email" value="<?= isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" required></li>
            <li><label for="password">Password</label> <input name="password" id="password" type="password" required></li>
        </ul>
        <input type="hidden" name="command" value="login">
        <button>login</button>
    </form>
</section>
<?php if(isset($formErrors)) : ?>
<section id="formErrors" class="errors">
    <ul>
    <?php foreach($formErrors as $error) : ?>
        <li><?= $error; ?></li>
    <?php endforeach; ?>
    </ul>
</section>
<?php endif; ?>
<?php require_once __DIR__ . '/foot.php';