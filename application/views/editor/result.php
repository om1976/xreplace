<div class="right">

    <div class="right-top-side">

        <div class="editable">
            <textarea id="text" class="text" name="text">
<?php echo html_escape($text); ?></textarea></div>
<!-- The first linebreak is inserted intentionally -->


    </div>

    <div class="right-middle-side">
    
    <button id="cancel" class="custom cancel"
            type="submit"
            title="<?php echo lang('result_cancel')?>"
            name="action"
            value="cancel/last"
            <?php echo $button_status['result_cancel']?>>
    </button>

     <button id="history-reset" class="custom reset"
             type="submit"
             title="<?php echo lang('history_reset') ?>"
             name="action"
             value="cancel/all"
             <?php echo $button_status['result_reset_history']?>>
     </button>

        <div class="console-clock">
            <img class="ui-clock-bright" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
        </div>
       <div class="benchmark">
           <?php echo $benchmark_message ?>
       </div>

        <div class="console-message">
            <?php echo $console_message ?>
        </div>

        <div class="memory-used"><img class="ui-memory" src="<?php echo base_url('assets/images/img_trans.gif');?>"/>
            <?php echo $memory_used ?> %
            <div class="history-message">
                <?php echo $history_message ?>
            </div>
        </div>

    </div>

<!--#BED9FF-->
    <div class="right-bottom-side">

        <div class="result">
            <div id="info" class="hidden info">
                <button type="button" class="custom close toggle-info">
                </button>
                <div class="info-title">
                    Информация
                </div>
                <div>
                    <?php echo nl2br(html_escape($info)) ?>
                </div>
            </div>

            <?php echo $result_list ?>
        </div>

    </div>

</div>

<input id="areyouabot" type="text" name="areyouabot" value=""/>

</form>