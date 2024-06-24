<h1>DataBase</h1>

<div class="tracy-inner tracy-InfoPanel">
    <?php if (empty($rows) === true): ?>
        <p><i>empty</i></p>
    <?php else: ?>
    <table>
        <tr>
            <th>Time&nbsp;ms</th>
            <th>SQL Query</th>
        </tr>
        <tbody>
        	<?php foreach ($rows as $key => $value): ?>
            <tr>
                <th><?php echo $key; ?></th>
                <td>

                    <?php echo Tracy\Dumper::toHtml($value, [Tracy\Dumper::LIVE => true, Tracy\Dumper::TRUNCATE => 1000]); ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php endif;?>
</div>