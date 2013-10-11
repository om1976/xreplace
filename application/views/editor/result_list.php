<?php if (! empty($result) and is_array($result)): ?>
<table>
    <tr><th><?php echo lang('rule_order_sign') ?></th>
        <th><?php echo lang('result_line_found') ?></th>
        <th><?php echo lang('result_line_replaced') ?></th>
        <th><?php echo lang('result_line_total') ?></th>
    </tr>
    <?php foreach ($result as $data): ?>
    <tr class="result-line">
        <td class="string-rule">
            <?php echo $data['rule_order'] ?>
        </td>
        <td class="string-found">
            <?php echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", htmlspecialchars($data['found'], ENT_NOQUOTES)) ?>
        </td>
        <td class="string-replaced">
            <?php echo str_replace(array("\r\n", "\n", "\r"), "<img src=\"" . base_url('assets\images\newline.png') . "\">", htmlspecialchars($data['replaced'], ENT_NOQUOTES)) ?>
        </td>
        <td class="string-total">
            <?php echo $data['total'] ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>

<div class="no-match"><?php echo lang('result_no_match') ?></div>

<?php endif; ?>