<div style="width:25%; padding: 15% 35% 0%; color: #3D6AA2; ">

        <div style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">
            <?php echo lang('forgot_password_heading');?>
        </div>

        <div class="error"><?php echo $message;?></div>

        <?php echo form_open("auth_actions/reset_password");?>

              <div>
                <label for="code"><?php echo lang('forgot_password_code_label') ?></label>
              </div>
              <div>
                <input type="text" name="code" style="width:100%" value="<?php echo $code ?>"/>
              </div>
              <div>
                <input type="submit" value="Ок"/>
              </div>

        <?php echo form_close();?>
              
</div>