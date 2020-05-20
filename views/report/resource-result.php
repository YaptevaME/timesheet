<table class="table table-hover table-report">
    <thead>
        <tr>
            <td></td>
            <td>Дата</td>
            <td>Списание</td>
            <td>Норма, ч</td>
            <td>Дисбаланс, ч</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($days as $no => $day) : ?>
            <?php if ($disbalance == 0 || $day['time_quantity'] - $employee->timenorm != 0): ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= date('d.m.Y', $day['date']) ?> <br><?= $day['date2'] ?></td>
                <td><?= $day['time_quantity'] ?></td>
                <td><?= $day['norm'] ?></td>
                <td><?= $day['norm'] - $day['time_quantity'] ?></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td><?= $sum ?></td>
            <td></td>
            <td><?= $disbalance_sum ?></td>
        </tr>
    </tfoot>
</table>