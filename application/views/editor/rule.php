
<div id="<?php echo $rule_id; ?>" class="rule">


    <div>
        <img
            class="handle"
            src="<?php echo base_url('assets/images/sorterer.gif');?>"
        />
    </div>

    <button type="submit" class="custom apply" title="<?php echo lang('rule_apply') ?>"
            name="action"
            value="apply_rule/<?php echo $rule_id?>"></button>

    <button type="submit"  class="custom edit" title="<?php echo lang('rule_edit')?>"
            name="action"
            value="open_update_rule_form/<?php echo $rule_id ?>"></button>

    <button type="submit" class="custom reset" name="action" value="reset_stats/<?php echo $rule_id?>" title="<?php echo lang('rule_stats_reset') ?>"></button>

    <button type="submit" class="custom delete r" title="<?php echo lang('rule_delete') ?>"
            name="action"
            value="delete_rule/<?php echo $rule_id ?>"></button>


    <div class="rule-stats">
        <?php //echo $rule_stats ?>
        <div>
            <img class="ui-clock" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
                <?php echo $rule_average_duration ?>
            <img class="ui-calculator" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
                <?php echo $rule_times_used ?>
            <img class="ui-calendar" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
                <?php echo $rule_used_ago ?>
    
        </div>
    </div>

    <div class="rule-order <?php echo $rule_type ?>"><?php echo lang('rule_order_sign') . $rule_order ?></div>

    <div class="rule-description"><span><?php echo html_escape($rule_description) ?></span></div>

    <div class="rule-body">

        <span class="regex-separator">
            <?php echo html_escape($rule_separator) ?>
        </span>

        <span class="regex-pattern">
            <?php
            if ($rule_type === 'regex'):
                echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", highlight_pattern(htmlspecialchars($rule_pattern, ENT_NOQUOTES)));
            else:
                echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", htmlspecialchars($rule_pattern, ENT_NOQUOTES));
            endif;
            ?>
        </span>

        <span class="regex-separator">
            <?php echo html_escape($rule_separator) ?>
        </span>

        <span class="regex-modifiers">
            <?php echo html_escape($rule_modifiers) ?>
        </span>

        <img src="<?php echo base_url()  ?>assets/images/right-arrow.png">

        <span class="replacement">
            <?php
            if ($rule_type === 'regex'):
                echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", highlight_replacement(htmlspecialchars($rule_replacement, ENT_NOQUOTES), $this->config->item('func_placeholders')));
            else:
                echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", htmlspecialchars($rule_replacement, ENT_NOQUOTES));
            endif;
            ?>
        </span>
    </div>
    
</div>
