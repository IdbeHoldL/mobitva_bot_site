<div style="margin-left: 50px; margin-top: 20px;">
    
    <?php if ($form->getErrorSchema()->getMessage()):?>
        <div class="alert alert-error" style="padding: 10px;">
            Такой пары логин-пароль не обранужено
            <?php echo $form->getErrorSchema()->getMessage();?>
        </div>
    <?php endif;?>
    
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
<!--    < ?php//  $form = new sfGuardFormSignin() ?>-->
    
    <?php echo $form->renderHiddenFields(); ?>
    <br />e-mail: <br />
    <?php echo $form['username']?>
    <br />пароль: <br />
    <?php echo $form['password']?>
    <br />запомнить: 
    <?php echo $form['remember']?>
    <br />
    
    
    <input type="submit" class="btn-primary" value="Войти" />
</form>
</div>
