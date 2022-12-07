$(document).ready(function () {
    let selectedProv = $('[data-selected-prov]').attr('data-selected-prov');
    console.log(selectedProv);
    if (selectedProv) {
        $('select > option').removeAttr('selected');
        $(`select > option[value="${selectedProv}"]`).attr('selected', 'selected');
    }
});