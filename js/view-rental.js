$(document).ready(function () {
    let rentalDate = $('#rentalDate-raw').text();
    let dueDate = $('#dueDate-raw').text();

    rentalDate = moment(rentalDate);
    dueDate = moment(dueDate);
    now = moment(moment().format('YYYY-MM-DD'));

    $('#rentalDate-raw').text( rentalDate.format('LL') );
    $('#dueDate-raw').text( dueDate.format('LL') );

    if ( dueDate.isSame(now, 'day') ) {
        $('#rent-status').html(`<div class="border border-warning border-5 text-warning fw-bold p-3 m-0 bg-white">This book is due today.</div>`);
        return;
    }

    
    if( dueDate.isBefore(now, 'day') ) {
        let diff = now.diff(dueDate, 'days');
        $('#rent-status').html(`<div class="border border-danger border-5 text-danger fw-bold p-3 m-0 bg-white">This book is ${diff} days overdue.</div>`);
        return;
    }

    if( dueDate.isAfter(now, 'day') ) {
        let diff = dueDate.diff(now, 'days');
        $('#rent-status').html(`<div class="border border-success border-5 text-success fw-bold p-3 m-0 bg-white">This book will be due in ${diff} days.</div>`);
        return;
    }

});