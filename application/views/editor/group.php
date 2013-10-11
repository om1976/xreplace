
<div class="group <?php echo $group_global ?>" id="group-<?php echo $group_id ?>" data-category-id="<?php echo $category_id ?>">

    <div class="group-heading">
        <img src="<?php echo base_url() . 'assets/images/group-' . $group_type ?>.png"
             alt="<?php echo $group_type ?>"
             title="<?php echo lang('group_type_' . $group_type) ?>"/>

        <div class="group-name-wrapper">
        <div class="group-name" title="<?php echo $group_title ?>">
            <?php echo html_escape($group_name) ?>
        </div>

        <div class="group-category">
            <?php echo html_escape($category_name) ?>
        </div>
        </div>


    </div>

    <button type="submit" class="custom apply" name="action" value="apply_group/<?php echo $group_id ?>" title="<?php echo lang('group_apply') ?>" <?php echo $button_status['apply']?>></button>

    <?php if ($group_stats): ?>
    <div class="group-stats">
        <?php echo $group_stats ?>
    </div>
    <?php endif ?>

    <button type="submit" class="custom delete g" title="<?php echo lang('group_delete') ?>"
            name="action" value="delete_group/<?php echo $group_id ?>" <?php echo $button_status['delete']?>></button>

    <button type="submit" class="custom edit" title="<?php echo lang('group_edit') ?>"
            name="action" value="open_update_group_form/<?php echo $group_id ?>" <?php echo $button_status['edit']?>>
    </button>

    <button type="submit" class="custom add r" title="<?php echo lang('rule_add') ?>"
            name="action" value="open_add_rule_form/<?php echo $group_id ?>" <?php echo $button_status['add_r']?>>
    </button>

<?php echo $form ?>
    
<!-- Rules START -->
<div class="rules">

    <?php echo $rules ?>

</div>

<!-- Rules END -->

</div>

<!-- Group END -->