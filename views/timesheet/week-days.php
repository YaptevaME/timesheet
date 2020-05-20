<div class="timesheet-index">
    <h4>с <?= date('d.m.Y', $monday_date) ?> по <?= date('d.m.Y', $sunday_date) ?></h4>

    <p>
        <button class="btn btn-primary" data-toggle="modal" data-target="#timesheetModal" onclick="loadAddJob()">
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </p>
    <table class="table" id="timesheet-table">
        <thead>
            <tr>
                <td></td>
                <?php foreach ($weekdays as $weekday) : ?>
                    <td class="text-center"><?= date('d.m.Y', $weekday) ?> (<?= $weekday_names[date('w', $weekday)] ?>)</td>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job) : ?>
                <tr>
                    <td><b><?= $job['name'] ?></b></td>
                    <?php foreach ($job['weekdays'] as $weekday) : ?>
                        <td>
                            <input type="number" value="<?= $weekday['tsh'] != null ? $weekday['tsh']->quantity : 0 ?>"  min="0" max="24" data-job="<?= $job['id'] ?>" data-date="<?= date('Y-m-d', $weekday['date']) ?>" oninput="editTimesheet(this)" class="form-control weekday-item weekday-item-saved" title="<?= date('d.m.Y', $weekday['date']) ?>">
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <button class="btn btn-primary btn-save-timesheets" data-job="<?= $job['id'] ?>" onclick="saveTimesheets(this)">
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td>Итого</td>
                <?php foreach ($weekdays as $weekday) : ?>
                    <td class="text-center"></td>
                <?php endforeach; ?>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(() => {
        weekdayAmount();
    });
</script>