<td><b><?= $job->name ?></b></td>
<?php foreach ($weekdays as $weekday) : ?>
    <td>
        <input type="number" value="0"  min="0" max="24" data-job="<?= $job->id?>" data-date="<?= date('Y-m-d', $weekday) ?>" oninput="editTimesheet(this)" class="form-control weekday-item" title="<?= date('d.m.Y', $weekday) ?>">
    </td>
<?php endforeach; ?>
<td>
    <button class="btn btn-primary btn-save-timesheets" data-job="<?= $job->id ?>" onclick="saveTimesheets(this)">
        <span class="glyphicon glyphicon-ok"></span>
    </button>
</td>