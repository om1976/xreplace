<div style="width:25%; padding: 15% 35% 0%; color: #3D6AA2; ">

        <div style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">
            <?php echo lang('forgot_password_heading');?>
        </div>

        <div class="error"><?php echo $message;?></div>

        <?php echo form_open("auth_actions/forgot_password");?>

            <div>
                <label for="email"><?php echo lang('forgot_password_email_label') ?></label>
            </div>
            <div>
                <input type="text" name="email" style="width: 100%" value="<?php echo $email ?>"/>
            </div>
            <div>
                <input type="submit" value="Ок" style="padding:2px 6px"/>
            </div>

            <input id="areyouabot" type="text" name="areyouabot" value=""/>
        
        <?php echo form_close();?>

</div>