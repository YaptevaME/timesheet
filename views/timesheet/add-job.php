<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="timesheetModalLabel">Добавление задачи</h4>
</div>
<div class="modal-body">
    <p>
        <select id="add-timesheet-job" class="form-control">
            <option disabled selected>...</option>
            <?php foreach ($jobs as $job) : ?>
                <option value="<?= $job['id'] ?>">
                <b><?= $job['activity_name']?></b>
                <span class="text-primary"> > </span>
                <span><?= $job['name'] ?></span>
            </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p class="text-right">
        <button class="btn btn-primary" onclick="addJob()">Добавить</button>
    </p>
</div>