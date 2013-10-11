<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf8" />
    <title>X-Replace | Редактор | Регулярные выражения</title>
    <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
</head>
<body>
    <div class="header">
        <div class="logo-image">
            <a href="<?php echo base_url('index.php/editor/index') ?>"><div class="logo">X-Replace</div></a>
        </div>

        <div class="top-menu">
            <ul>
                <?php echo $menu ?>

                <li id="lang" class="lang" title="<?php echo lang('header_language_button_title') ?>">
                <?php echo lang('header_language') ?>
                <a id="toggle-language" href="<?php echo base_url('index.php/editor/toggle_language') ?>">
                    <?php echo lang('header_language_button_text') ?>
                </a>
                </li>

                <li class="user-name">
                    <img class="<?php echo $user_image_class ?>" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
                    <a href="#"><?php echo html_escape($user_name) ?></a>
                </li>

                <li class="logger">
                    <a href="<?php echo $logger_ref ?>"><?php echo $logger_title ?></a>
                </li>
            </ul>
        </div>

    </div>

