<?php if (count($faq)): ?>
    <?php foreach ($faq as $faq): ?>
        <div class="faq-container">
            <div class="alert faq-q"><?php echo $faq->getQuestion(); ?></div>
<pre class="faq-a">
    <?php echo $faq->getAnswer(); ?>
</pre>
            <div class="separator-r"></div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="alert alert-danger"> Тут пока нет ни одного вопроса</div>
<?php endif; ?>
    

