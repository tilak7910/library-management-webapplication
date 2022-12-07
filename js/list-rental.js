$(document).ready(function () {
    console.log('Don')
    showRentals("");
});


function showRentals(str)
{
    $.ajax(`../ajax/unreturned-books.php?search=${str}`)
        .done(function( data, status, jqXHR) {
            $('#rental-results').html(data);
        })
        .fail(function( jqXHR, status, error ) {
            console.log('error');
        });
}