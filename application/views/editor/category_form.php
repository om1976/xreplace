<!-- Category form start -->
<div id="category-form" class="category-form">

    <div class="category-form-heading"><?php echo $category_form_heading ?></div>


    <button
        type="submit"
        class="custom save"
        title="<?php echo lang('category_save') ?>"
        name="action"
        value="<?php echo $category_action ?>">
    </button>

    <button
        type="submit"
        class="custom close"
        title="<?php echo lang('form_close') ?>"
        name="action"
        value="close_form">
    </button>

    <div class="category-error"><?php echo $category_message ?></div>
    
    <?php echo lang('category_name') ?>:
    <div class="">
        <input type=text name="category_name" value="<?php echo html_escape($category_name) ?>">
    </div>

    <?php echo lang('category_info') ?>:
    <div class="">
        <textarea name="category_info" rows="7"><?php echo html_escape($category_info) ?></textarea>
    </div>
</div>
<!-- Category form end -->