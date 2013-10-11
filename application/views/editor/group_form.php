<div id="group-form" class="group form">
    <input type="hidden" name="group_id" value="<?php echo $group_id ?>">

    <div class="group-form-heading"><?php echo $group_form_heading ?></div>

    <div class="group-error"><?php echo $group_message ?></div>


    <button type="submit" class="custom save" title="<?php echo lang('group_save') ?>" 
            name="action" value="<?php echo $group_form_action ?>">
    </button>

    <button
        type="submit"
        class="custom close"
        title="<?php echo lang('form_close') ?>"
        name="action"
        value="close_form">
    </button>


    <div class="group-types">

            <input type="radio"
                   name="group_type"
                   id="group-type-expanded"
                   value="expanded"
                   <?php echo $group_type === 'expanded' ? 'checked' : '' ?>
            >
            <img src="<?php echo base_url('assets/images/group-expanded.png') ?>"/>
            <label class="group-label expanded" for="group-type-expanded"><?php echo lang('group_type_expanded') ?></label>

            <input type="radio"
                   name="group_type"
                   id="group-type-compact"
                   value="compact"
                   <?php echo $group_type === 'compact' ? 'checked' : '' ?>
            >
            <img src="<?php echo base_url('assets/images/group-compact.png') ?>"/>
            <label class="group-label compact" for="group-type-compact"><?php echo lang('group_type_compact') ?></label>

            <input type="radio"
                   name="group_type"
                   id="group-type-norules"
                   value="norules"
                   <?php echo $group_type === 'norules' ? 'checked' : '' ?>
            >
            <img src="<?php echo base_url('assets/images/group-norules.png') ?>"/>
            <label class="group-label norules" for="group-type-norules"><?php echo lang('group_type_norules') ?></label>

            <input id="group-global" name="group_global" value="global" class="check" type="checkbox" <?php echo $group_global === 'global' ? 'checked' : '' ?> />
            <label for="group-global"><?php echo lang('group_global_title') ?></label>
        </div>

        <div class="group-name-input">
            <label for="group-name"><?php echo lang('group_name_label') ?></label>
            <input id="group-name" name="group_name" type="text" value="<?php echo html_escape($group_name) ?>"/>
        </div>


</div>