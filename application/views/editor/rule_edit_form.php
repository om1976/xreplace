<!-- Edited rule start -->
<div id="<?php echo $rule_id; ?>" class="rule form">

<input type="hidden" name="rule_id" value="<?php echo $rule_id ?>">
<input type="hidden" name="current_action" value="open_update_rule_form/<?php echo $rule_id ?>">

<!-- TODO: Reset stats -->

    <div>
        <img
            class="handle"
            src="<?php echo base_url('assets/images/sorterer.gif');?>"
        />
    </div>

    <button type="submit" class="custom apply" name="action" value="apply_rule_form/update/<?php echo $rule_id?>" title="<?php echo lang('rule_edit_form_apply') ?>"></button>

    <button type="submit" class="custom save" title="<?php echo lang('rule_save') ?>"
            name="action" value="update_rule/<?php echo $rule_id ?>"></button>

    <button
        type="submit"
        class="custom close"
        title="<?php echo lang('form_close') ?>"
        name="action"
        value="close_form"></button>

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


        <span class="rule-order <?php echo $rule_type; ?>">
            <?php echo lang('rule_order_sign') . $rule_order;/* номер по порядку */?>
        </span>
        <input type="hidden" name="rule_order" value="<?php echo $rule_order ?>">
    
        <span class="rule-label"><?php echo lang('rule_edit_form_heading') ?></span>
    
    <div class="rule-error"><?php echo $rule_message ?></div>


    <div class="rule-body">

        <div class="rule-types">
            <input type="radio"
                   name="rule_type"
                   id="simple<?php echo $rule_id ?>"
                   value="simple"
                   <?php echo $rule_type === 'simple' ? 'checked' : '' ?>
            >
            <label class="simple" for="simple<?php echo $rule_id ?>"><?php echo lang('rule_simple') ?></label>

            <input type="radio"
                   name="rule_type"
                   id="regex<?php echo $rule_id ?>"
                   value="regex"
                   <?php echo $rule_type === 'regex' ? 'checked' : '' ?>
            >
            <label class="regex" for="regex<?php echo $rule_id ?>"><?php echo lang('rule_regex') ?></label>
        </div>

        <?php echo lang('rule_description') ?>:
        <div>
            <input class="rule-description-input" type=text name="rule_description" value="<?php echo html_escape($rule_description) ?>">
        </div>
        <?php echo lang('rule_delimiter_and_modifiers') ?>:
        <div>
            <input class="rule-separator-input" type=text name="rule_separator" value="<?php echo html_escape($rule_separator) ?>">
            <input class="rule-modifiers-input" type=text name="rule_modifiers" value="<?php echo html_escape($rule_modifiers) ?>"></div>
        <?php echo lang('rule_pattern') ?>:
        <div><textarea class="rule-pattern-input" name="rule_pattern" rows="4"><?php echo html_escape($rule_pattern) ?></textarea></div>
        <?php echo lang('rule_replacement') ?>:
        <div>
            <textarea class="rule-replacement-input" name="rule_replacement" rows="4"><?php echo html_escape($rule_replacement) ?></textarea>
        </div>
        <?php echo lang('group_group') . ': ' . form_dropdown('group_id', $group_list, $group_id, 'id="group_id"'); ?>
    </div>
</div>
<!-- Edited rule end -->