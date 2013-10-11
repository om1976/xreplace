<!-- New rule start -->
<div id="rule-add-form" class="rule form">
<input type="hidden" name="group_id" value="<?php echo $group_id ?>">
<input type="hidden" name="current_action" value="open_add_rule_form/<?php echo $group_id ?>">


    <div>
        <img
            class="disabled-handle"
            src="<?php echo base_url('assets/images/sorterer.gif');?>"
        />
    </div>

    <button type="submit" class="custom apply" name="action" value="apply_rule_form/add/<?php echo $group_id ?>" title="<?php echo lang('rule_edit_form_apply') ?>"></button>

    <button type="submit" class="custom save" title="<?php echo lang('rule_save') ?>" name="action" value="add_rule/<?php echo $group_id ?>"></button>


    <button
        type="submit"
        class="custom close"
        title="<?php echo lang('form_close') ?>"
        name="action"
        value="close_form">
    </button>

    <div class="rule-label">
            <?php echo lang('rule_add_form_heading') ?>
<!--        <span class="rule-heading"></span>-->
    </div>

    <div class="rule-error"><?php echo $rule_message ?></div>

    <div class="rule-body">

        <div class="rule-types">
            <input type="radio"
                   name="rule_type"
                   id="simple"
                   value="simple"
                   <?php echo $rule_type === 'simple' ? 'checked' : '' ?>
            >
            <label class="simple" for="simple"><?php echo lang('rule_simple') ?></label>

            <input type="radio"
                   name="rule_type"
                   id="regex"
                   value="regex"
                   <?php echo $rule_type === 'regex' ? 'checked' : '' ?>
            >
            <label class="regex" for="regex"><?php echo lang('rule_regex') ?></label>

<!--            <input type="radio"
                   name="rule_type"
                   id="callback"
                   value="callback"
                   <?php echo $rule_type === 'callback' ? 'checked' : '' ?>
            >
            <label class="callback" for="callback">callback</label>-->
        </div>

        <?php echo lang('rule_description') ?>:
        <div>
            <input class="rule-description-input" type=text name="rule_description" value="<?php echo html_escape($rule_description) ?>">
        </div>
        <?php echo lang('rule_delimiter_and_modifiers') ?>:
        <div >
            <input class="rule-separator-input" type=text name="rule_separator" value="<?php echo html_escape($rule_separator) ?>">
            <input class="rule-modifiers-input"  type=text name="rule_modifiers" value="<?php echo html_escape($rule_modifiers) ?>"></div>
        <?php echo lang('rule_pattern') ?>:
        <div><textarea class="rule-pattern-input" name="rule_pattern" rows="4"><?php echo html_escape($rule_pattern)?></textarea></div>
        <?php echo lang('rule_replacement') ?>:
        <div>
            <textarea class="rule-replacement-input" name="rule_replacement" rows="4"><?php echo html_escape($rule_replacement)?></textarea>
        </div>
    </div>
</div>
<!-- New rule end -->