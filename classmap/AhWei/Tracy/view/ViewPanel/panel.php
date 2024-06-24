<h1>View</h1>

<div class="tracy-inner tracy-InfoPanel">
    <table>
        <tr>
            <th>
                name
            </th>
            <th>
                data
            </th>
        </tr>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td>
                    <?php echo $row['name']; ?>
                </td>
                <td>
                    <?php echo Tracy\Dumper::toHtml($row['data'], [Tracy\Dumper::LIVE => true, Tracy\Dumper::DEPTH => 7, Tracy\Dumper::TRUNCATE => 1000]); ?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>