<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>

                    <ul class="nav" style="float:left">
                        <li class="active">
                            <a href="<?php echo url_for('@homepage') ?>">Фронтенд</a>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">sfGuard<b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <li><a href="<?php echo url_for('@sf_guard_user')?>">Users</a></li>
                                <li><a href="<?php echo url_for('@sf_guard_user_profile')?>">Profiles</a></li>
                                <li><a href="<?php echo url_for('@sf_guard_group')?>">Groups</a></li>                                
                                <li><a href="<?php echo url_for('@sf_guard_permission')?>">Permissions</a></li>
                                <li>---</li>
                                <li><a href="<?php echo url_for('@mobitvabot_transaction')?>">Transaction</a></li>
                                <li><a href="<?php echo url_for('@mobitvabot_news')?>">News</a></li>
                                <li><a href="<?php echo url_for('@mobitvabot_faq')?>">Faq</a></li>
                                <li><a href="<?php echo url_for('@mobitvabot_config')?>">Configs</a></li>
                                <li><a href="<?php echo url_for('@mobitvabot_config_group')?>">Config Gropus</a></li>
                                <li><a href="<?php echo url_for('@mobitvabot_files')?>">FILES</a></li>
                                

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">sfGuard<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                
                            </ul>
                        </li>
                        
                        <li><a href="#">Обсуждение</a></li>
                    </ul>
                
        <?php echo $sf_content ?>
    </body>
</html>
