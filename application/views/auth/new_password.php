<div style="width:25%; padding: 15% 35% 0%; color: #3D6AA2; ">

        <div style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">
            <?php echo lang('forgot_password_heading');?>
        </div>

        <?php echo form_open("auth_actions/new_password");?>

              <div>
                <label for="new_password"><?php echo lang('forgot_password_new_label') ?></label>
              </div>
              <div>
                <input type="hidden" name="code" value="<?php echo $code ?>"/>
              </div>
              <div>
                <input type="password" name="new_password" style="width:100%" value="<?php echo $new_password ?>"/>
              </div>
              <div>
                <input type="submit" value="Ок"/>
              </div>

        <?php echo form_close();?>
</div>