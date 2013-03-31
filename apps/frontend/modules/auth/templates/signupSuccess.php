
<form action="<?php echo url_for('@register') ?>" method="post">
<?php if ($message != ''):?>
    <div class="alert alert-error">
        <?php echo $message ?>
    </div>
<?php endif;?>
    
<?php /* @var $registerForm registerForm */ ?>
<?php echo $registerForm->renderHiddenFields(); ?>
<br /> e-mail <br />
<?php echo $registerForm['username']?>
<br /> пароль <br />
<?php echo $registerForm['userpass']?>
<br /> подтвердите пароль <br />
<?php echo $registerForm['confirm_userpass']?>
<br /> проверочный код <br />
<?php echo $registerForm['captcha']?> <br />

<input type="submit" class="btn" value="Регистрация">
</form>