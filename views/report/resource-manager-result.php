<?php if ($balance == 1 && $disbalance_count > 0) : ?>
    <div class="alert-wrap">
        <div class="alert alert-warning">
            Отправить уведомление сотрудникам о наличии положительного дисбаланса
            <button type="button" class="btn btn-warning" onclick="sendMessages()"><span class="glyphicon glyphicon-send"></span></button>
        </div>
        <hr>
    </div>
<?php endif; ?>

<table class="table table-hover table-report">
    <thead>
        <tr>
            <td></td>
            <td>Сотрудник</td>
            <td>Списание</td>
            <td>Рабочих дней</td>
            <td>Норма, ч</td>
            <td>Дисбаланс, ч</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $no => $employee) : ?>
            <?php if ($balance == 0) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $employee['last_name'] . ' ' . $employee['first_name'] ?></td>
                    <td><?= $employee['time_quantity'] ?></td>
                    <td><?= $employee['workdays'] ?></td>
                    <td><?= $employee['timenorm'] * $employee['workdays'] ?></td>
                    <td><?= $employee['timenorm'] * $employee['workdays'] - $employee['time_quantity'] ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($balance == 1) : ?>
                <?php if ($employee['timenorm'] * $employee['workdays'] - $employee['time_quantity'] > 0) : ?>
                    <tr class="disbalance-employee" data-id="<?= $employee['id'] ?>">
                        <td><?= ++$no ?></td>
                        <td><?= $employee['last_name'] . ' ' . $employee['first_name'] ?></td>
                        <td><?= $employee['time_quantity'] ?></td>
                        <td><?= $employee['workdays'] ?></td>
                        <td><?= $employee['timenorm'] * $employee['workdays'] ?></td>
                        <td><?= $employee['timenorm'] * $employee['workdays'] - $employee['time_quantity'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($balance == 2) : ?>
                <?php if ($employee['timenorm'] * $employee['workdays'] - $employee['time_quantity'] < 0) : ?>
                    <tr>
                        <td><?= ++$no ?></td>
                        <td><?= $employee['last_name'] . ' ' . $employee['first_name'] ?></td>
                        <td><?= $employee['time_quantity'] ?></td>
                        <td><?= $employee['workdays'] ?></td>
                        <td><?= $employee['timenorm'] * $employee['workdays'] ?></td>
                        <td><?= $employee['timenorm'] * $employee['workdays'] - $employee['time_quantity'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td><?= $sum ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>