$(document).ready(function () {


});

function addField(event) {
    let row = $(event).parent();
    let container = $(event).parent().parent();
    let cloned = row.clone();
    cloned.find('option').removeAttr('selected');
    cloned.find('option[value=""]').attr('selected', 'selected');
    container.append(cloned);
}

function removeField(event) {
    let numRows = $(event).parent().parent().children();
    if (numRows.length > 1) {
        $(event).parent().remove();
    }
}