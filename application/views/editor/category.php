<div class="left">
        
    <div class="category">

        <?php echo form_open('editor_actions/action', 'id="actions"');?>

        <div class="category-controls">

            <button type="submit" class="custom delete c" name="action" value="delete_category"
                    title="<?php echo lang('category_delete_button_title')?>" <?php echo $button_status['delete']?>></button>

            <div class="category-dropdown"><?php echo form_dropdown('category_id', $category_list, $category_id, 'id="category_id"'); ?></div>

            <button id="choose" type="submit" class="custom choose" name="action" value="select_category"
                    title="<?php echo lang('category_choose_button_title')?>" <?php echo $button_status['choose']?>></button>

            <button
               id="copy-sample-category" class="custom copy"
               type="submit"
               title="<?php echo lang('category_copy_sample')?>"
               name="action"
               value="copy_sample_category"
               <?php echo $button_status['copy_sample']?>></button>


            <button
               id="edit-category" class="custom edit"
               type="submit"
               title="<?php echo lang('category_edit_button_title')?>"
               name="action"
               value="open_update_category_form"
               <?php echo $button_status['edit']?>></button>

            <button
               id="add-category" class="custom add c"
               type="submit"
               title="<?php echo lang('category_add_button_title')?>"
               name="action"
               value="open_add_category_form"
               <?php echo $button_status['add_c']?>></button>

            <button
               id="add-group" class="custom add g"
               type="submit"
               title="<?php echo lang('group_add_button_title')?>"
               name="action"
               value="open_add_group_form"
               <?php echo $button_status['add_g']?>></button>

            <button id="toggle-info" class="custom toggle-info" type="submit"
                    <?php echo $button_status['toggle_info']?>></button>

            <button id="toggle-global-groups" class="custom global" type="submit"
                     <?php echo $button_status['toggle_global_groups']?>></button>

            <button id="category-download" class="custom download"
                    type="submit"
                    title="<?php echo lang('category_download') ?>"
                    name="action"
                    value="download_categories"
                    <?php echo $button_status['category_download']?>>
            </button>

            <button type="submit" class="custom pin"
                    title="<?php echo lang('category_get_snapshot_link') ?>"
                    name="action" value="make_category_snapshot/<?php echo $category_id ?>"
                    <?php echo $button_status['get_snapshot_link']?>>
            </button>


            <div class="highlight-result" title="<?php echo lang('category_highlight_result')?>">
                <input id="highlight-result" type="checkbox" />
                <label for="highlight-result">¶</label>
            </div>
            
        </div>
    </div>

    <div class="left-bottom-side">
        <div class="groups" >
        
            <!-- Form START -->

            <?php echo $form ?>

            <!-- Form END -->

            <!-- Groups START -->

            <?php echo $groups ?>

            <!-- Groups END -->
        
        </div>
    </div>
            
</div>