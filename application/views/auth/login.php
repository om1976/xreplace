<div style="width:25%; padding: 15% 35% 0%; color: #3D6AA2; ">
    
        <div style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">
            <?php echo lang('login_heading');?>
        </div>

        <div class="error"><?php echo $message ?></div>
        
        <form action="<?php echo base_url() . 'index.php/auth_actions/login' ?>" method="post">

        <div><?php echo lang('register_email', 'login')?>
            <input type="text" name="login" style="width:100%" value="<?php echo $login ?>"/>
        </div>
        <?php echo lang('login_password', 'password')?>
        <div>
            <input type="password" name="password" style="width:100%" value="<?php echo $password ?>"/>
        </div>
    <div>
        <input id="remember" type="checkbox" name="remember" value="1" <?php echo $remember ?>/>
        <?php echo lang('login_remember', 'remember');?>
    </div>
    <div>
        <input id="save-data" type="checkbox" name="save_data" value="1" <?php echo $save_data ?>/>
        <?php echo lang('category_save_data');?><span title="<?php echo lang('login_save_data_info') ?>">*</span>
    </div>
        <button type="submit"
                title="<?php echo lang('login_submit')?>" style="padding:2px 4px">
            <?php echo lang('login_submit')?>
        </button>
            
        </form>
        <div>
            <div style="float:left">
                <a href="register"><?php echo lang('login_wanna_signup')?></a>
            </div>
            <div  style="float:right">
                <a href="forgot_password"><?php echo lang('login_forgot_password')?></a>
            </div>
        </div>
        <div style="font-style: italic; font-size: 12px; padding-top:10px; clear: both;  ">
            * <?php echo lang('login_save_data_info') ?>
        </div>
</div>