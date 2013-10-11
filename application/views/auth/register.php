<div style="width:25%; padding: 15% 35% 0%; color: #3D6AA2;">

        <div style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">
            <?php echo lang('register_heading');?>
        </div>
    
        <div class="error"><?php echo $message ?></div>

        <form action="<?php echo base_url() . 'index.php/auth_actions/register' ?>" method="post">
        <div>
            <?php echo lang('register_login', 'login')?>
        </div>
            <input type="text" name="login" style="width:100%" value="<?php echo $login ?>"/>
        <div>
            <?php echo lang('register_email', 'email')?>
        </div>
            <input type="text" name="email" style="width:100%" value="<?php echo $email ?>"/>
        <div>
            <?php echo lang('register_password', 'password')?>
        </div>
            <input type="password" name="password" style="width:100%" value="<?php echo $password ?>"/>
        <div>
            <input id="save-data" type="checkbox" name="save_data" value="1" <?php echo $save_data ?>/>
            <?php echo lang('category_save_data');?><span title="<?php echo lang('login_save_data_info') ?>">*</span>
        </div>
            
            <input id="areyouabot" type="text" name="areyouabot" value=""/>

            <button type="submit"
                    title="<?php echo lang('register_submit')?>" style="padding:2px 4px">
                <?php echo lang('register_submit')?>
            </button>

        <div style="font-style: italic; font-size: 12px; margin-top:5px;">
            * <?php echo lang('login_save_data_info') ?>
        </div>
        </form>
        
</div>
