// $(document).ready(() => {
//     alert('timegovno');
// });

function addEmployee(activityId) {
    $('#timesheetModal .modal-content').load('/activity/add-employee?activity_id=' + activityId);
}

function loadAddJob() {
    $('#timesheetModal .modal-content').load('/timesheet/add-job');
}

function addJob() {
    const jobId = $('#add-timesheet-job').val();
    if (jobId) {
        const yearAndDay = $('#timesheet-week').val().split('-W');
        $('#timesheet-table tbody').append('<tr>');
        $('#timesheet-table tbody tr:last-child()').load('/timesheet/job-row?year=' + yearAndDay[0] + '&week=' + yearAndDay[1] + '&job_id=' + jobId);
    }
    $('#timesheetModal').modal('hide');
}

function loadWeekDays() {
    const yearAndDay = $('#timesheet-week').val().split('-W');
    $('#weekdays').load('/timesheet/week-days?year=' + yearAndDay[0] + '&week=' + yearAndDay[1]); //  + '&job_id=' + jobId
}

function saveTimesheets(btn) {
    const jobId = $(btn).attr('data-job');
    const timesheetElems = $('.weekday-item[data-job=' + jobId + ']');
    let timesheets = [];
    for (let elem of timesheetElems) {
        const obj = $(elem);
        let quantity = 0;
        if (obj.val()) {
            quantity = obj.val();
        } else {
            obj.val(0);
        }
        timesheets.push([
            obj.attr('data-date'),
            quantity
        ]);
    }
    $.ajax({
        method: 'POST',
        url: '/timesheet/create-timesheets',
        data: { timesheets, jobId }
    }).done(
        (resp) => {
            if (resp == 1) {
                timesheetElems.each((i, elem) => {
                    $(elem).addClass('weekday-item-saved');
                });
            }
        });
    console.log(timesheets);
}

function weekdayAmount() {
    let column = 1;
    $('#timesheet-table tfoot td:not(:first-child)').each((i, elem) => {
        column++;
        let amount = 0;
        $('#timesheet-table tbody td:nth-child(' + column + ') input[type=number]').each((i, elem) => {
            amount += $(elem).val() * 1;
        });
        $(elem).text(amount + 'ч');
    });
}

function editTimesheet(obj) {
    weekdayAmount();
    $(obj).removeClass('weekday-item-saved');
}


///
// REPORTS
///

function getManagerActivityReport() {
    const dateBegin = $('#param-date-begin').val();
    const dateEnd = $('#param-date-end').val();
    const activityId = $('#param-activity').val();
    const withDetails = $('#param-details').prop('checked') ? 1 : 0;
    $('#report-result').load('/report/manager-activity-result?begin=' + dateBegin + '&end=' + dateEnd + '&activity_id=' + activityId + '&with_details=' + withDetails);
}

function getResourceManagerReport() {
    const dateBegin = $('#param-date-begin').val();
    const dateEnd = $('#param-date-end').val();
    const balance = $('#param-balance').val();
    $('#report-result').load('/report/resource-manager-result?begin=' + dateBegin + '&end=' + dateEnd + '&balance=' + balance);
}
function getResourceReport() {
    const dateBegin = $('#param-date-begin').val();
    const dateEnd = $('#param-date-end').val();
    const disbalance = $('#param-disbalance').prop('checked') ? 1 : 0;
    $('#report-result').load('/report/resource-result?begin=' + dateBegin + '&end=' + dateEnd + '&disbalance=' + disbalance);
}

function sendMessages() {
    let ids = [];
    $('.disbalance-employee').each((i, emp) => {
        ids.push($(emp).attr('data-id'));
    });
    console.log("sendMessages -> ids", ids)
    $.ajax({
        method: 'POST',
        url: '/report/send-messages',
        data: { ids }
    }).done((resp) => {
        if (JSON.parse(resp)) {
            $('.alert-wrap').css('display', 'none');
            alert('Уведомления отправлены');
        }
    });
}

function readMessage() {
    $.ajax({
        method: 'GET',
        url: '/report/read-message'
    }).done((res) => {
        if (JSON.parse(res)) {
            $('.alert-wrap').css('display', 'none');
        }
    });
}