<?php
declare(strict_types=1);

require_once __DIR__ . '/head.php';

?><section>
    <header>
        <h2>Register</h2>
    </header>
    <form id="registerForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="token" value="<?= $token;?>">
        <ul>
            <li><label for="firstname">Firstname</label> <input name="firstname" type="text" value="<?php if (isset($fname)) : ?><?= htmlentities($fname, ENT_QUOTES); ?><?php endif; ?>" required></li>
            <li><label for="surname">Surname</label> <input name="surname" type="text" value="<?php if (isset($sname)) : ?><?= htmlentities($sname, ENT_QUOTES); ?><?php endif; ?>" required></li>
            <li><label for="phone">Phone</label> <input name="phone" type="text" value="<?php if (isset($phone)) : ?><?= htmlentities($phone, ENT_QUOTES); ?><?php endif; ?>" required></li>
            <li><label for="address">Address</label> <input name="address" type="text" value="<?php if (isset($address)) : ?><?= htmlentities($address, ENT_QUOTES); ?><?php endif; ?>" required></li>
            <li><label for="postcode">Postcode</label> <input name="postcode" type="text" value="<?php if (isset($postcode)) : ?><?= htmlentities($postcode, ENT_QUOTES); ?><?php endif; ?>" required></li>
            <?php if ((isset($makeAccount)) && ($makeAccount === false)) : ?>
                <li id="makeAccount"><label for="">make account</label> <input name="makeAccount" type="checkbox" value="true"></li>
            <?php endif; ?>
            <?php if ((isset($makeAccount)) && ($makeAccount === true)) : ?>
                <li><label for="email">Email</label> <input name="email" type="email" required></li>
                <li><label for="password">Password</label> <input name="password" type="password" required></li>
                <li><label for="passwordConfirm">Confirm Password</label> <input name="passwordConfirm" type="password" required></li>
                <input type="hidden" name="createAccount" value="true">
            <?php endif; ?>
        </ul>
        <input type="hidden" name="command" value="register">
        <button>submit</button>
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