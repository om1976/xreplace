    <?php if (! empty($rules_data) and is_array($rules_data)): ?>
    <div class="compact-rule-list">
    <?php foreach ($rules_data as $rule_data): ?>
        <?php echo $rule_data['order']; ?>.&nbsp;<?php echo html_escape($rule_data['pattern']); ?>&nbsp;-&nbsp;<?php echo html_escape($rule_data['replacement']); ?><br/>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>