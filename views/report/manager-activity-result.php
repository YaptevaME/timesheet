<?php if ($with_details == 0) : ?>
    <table class="table table-hover table-report">
        <thead>
            <tr>
                <td></td>
                <td>Сотрудник</td>
                <td>Списание</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $no => $employee) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $employee['last_name'] . ' ' . $employee['first_name'] ?></td>
                    <td><?= $employee['time_quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><?= $sum ?></td>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>

<?php if ($with_details == 1) : ?>
    <table class="table table-hover table-report">
        <thead>
            <tr>
                <td></td>
                <td>Задача</td>
                <td>Списание</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $no => $job) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $job['name'] ?></td>
                    <td><?= $job['time_quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td><?= $sum ?></td>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>