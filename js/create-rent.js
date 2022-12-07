
var rentPage = 1;
var bookSelected = [];




$(document).ready(function () {

    // load all borrowers and books records
    showBorrowers("");
    showBooks("");

    togglePages();

    // check if the borrower is already selected
    if ( $('#selected-borrower').children().length > 0 ) {
        $('#nav-borrower-next').removeClass('d-none');
    }

    // check if any book is already selected
    if ( $('#selected-book').children().length > 0 ) {
        $('#nav-book-next').removeClass('d-none');
    }

    // set rental date to current date
    let now = moment().format('YYYY-MM-DD')
    $('#rentalDate').attr('value', now);
    changeDueDate(now);

    validateDate()

    // add event listeners to date
    $('input[type="date"]').on('change', function(){
        validateDate();
    });


});


function showBorrowers(str)
{
    $.ajax(`../ajax/search-borrower.php?search=${str}`)
        .done(function( data, status, jqXHR ) {

            // load borrowers to the selection panel
            $('#borrower-results').html(data);

            // add event listener to the select button
            $('.select-borrower-tuple').on('click', function(event) {
                let tuple = $(this).parent().parent().children();
                let id = tuple.eq(0).text()
                let name = tuple.eq(1).text() + ' ' + tuple.eq(2).text();
                let email = tuple.eq(3).text();
                let phone = tuple.eq(4).text();
                let address = tuple.eq(5).text() + ' ' + tuple.eq(6).text() + ' ' + tuple.eq(7).text();
                let postal = tuple.eq(8).text();
                let selectedBorrower = `
                <div class="p-4 border border-success" data-borrower="${id}">
                    <div class="close close-borrower"><i class="fas fa-times"></i></div>
                    <div><strong>ID:</strong> ${id}</div>
                    <div>${name}</div>
                    <div>${email}</div>
                    <div>${phone}</div>
                    <div>${address}</div>
                    <div>${postal}</div>
                </div>`;
                let selectedBorrowerSummary = `
                <div class="" data-summary-borrower="${id}">
                    <div>${name}</div>
                    <div>${email}</div>
                    <div>${phone}</div>
                    <br>
                    <div>${address}</div>
                    <div>${postal}</div>
                    <input type="hidden" value="${id}" name="borrowerID">
                </div>
                `;
               
                $('#selected-borrower').html(selectedBorrower); // individual
                $('summary #summary-borrower').html(selectedBorrowerSummary); // summary
                $('#nav-borrower-next').removeClass('d-none'); 

                $('.close-borrower').on('click', function(event) {
                    let removedBorrower = $(this).parent().attr('data-borrower');
                    $(`[data-borrower="${removedBorrower}"]`).remove();
                    $(`[data-summary-borrower="${removedBorrower}"]`).remove();
                    $('#nav-borrower-next').addClass('d-none');
                });
            });
        })
        .fail(function( jqXHR, status, error ){
            console.log('error');
        });
}


function showBooks(str)
{
    $.ajax(`../ajax/search-book.php?search=${str}`)
    .done(function( data, status, jqXHR ) {

        // load books to the selection panel
        $('#book-results').html(data);

        // add event listener to the select button
        $('.select-book-tuple').on('click', function(event) {
            let tuple = $(this).parent().parent().children();
            let id = tuple.eq(0).text();
            let title = tuple.eq(1).text();
            let year = tuple.eq(3).text();
            let author = tuple.eq(2).text();

            // to avoid duplicate selections
            if ( !bookSelected.includes(id) )
            {
                bookSelected.push(id);
                let selectedBook = `
                <div class="p-4 border border-success position-relative" data-book="${id}">
                    <div class="close"><i class="fas fa-times"></i></div>
                    <div><strong>ID:</strong> ${id}</div>
                    <div>${title} (${year})</div>
                    <div>by ${author}</div>
                </div>
                `;

                let selectedBookSummary = `
                <div class="py-3 mb-3 border-bottom" data-summary-book="${id}">
                    <div>${title} (${year})</div>
                    <div>by ${author}</div>
                    <input type="hidden" value="${id}" name="bookID[]">
                </div>
                `;

                $('#selected-book').append(selectedBook);
                $('summary #summary-book').append(selectedBookSummary); // summary
                $('#nav-book-next').removeClass('d-none');
    
                $('.close').on('click', function(event){
                    let removedBook = $(this).parent().attr('data-book');
                    $(`[data-book="${removedBook}"]`).remove();
                    $(`[data-summary-book="${removedBook}"]`).remove();

                    bookSelected = bookSelected.filter(id => id != removedBook);
                    if (bookSelected.length < 1) {
                        $('#nav-book-next').addClass('d-none');
                    }
                });
            }
            
        });
    })
    .fail(function( jqXHR, status, error ){
        console.log('error');
    });
}

function togglePages()
{  
    // activate first page
    $('[data-page]').addClass('d-none');
    $(`[data-page=${rentPage}]`).removeClass('d-none');
    console.log(rentPage);
}


function next()
{
    rentPage++;
    togglePages();
}

function prev()
{
    rentPage--;
    togglePages();
}

function changeDueDate(date)
{
    $('#rentalDate').val(date)
    let rentalDate = date;
    let dueDate = moment(rentalDate).add(2, 'week').format('YYYY-MM-DD');
    console.log(dueDate);
    $('#dueDate').val(dueDate);
}

function validateDate()
{
    rentDate = $('#rentalDate').val();
    dueDate = $('#dueDate').val();
    updateSummaryDates(rentDate, dueDate);

    if (!rentDate) {
        $('#nav-date-next').addClass('d-none');
        $('#date-error').text('Specify a rental date.');
        $('#date-error').removeClass('d-none');
        return;
    }
    // valid
    if( moment(rentDate).isBefore(dueDate) ) {
        $('#nav-date-next').removeClass('d-none');
        $('#date-error').addClass('d-none');
    } else {
        $('#nav-date-next').addClass('d-none');
        $('#date-error').text('Due date should be at least one day after the rental date.');
        $('#date-error').removeClass('d-none');
    }

}


function updateSummaryDates(rentDate, dueDate)
{
    let rentDateEl = `
    <div>
        Starting rent date:<br>
            <strong>${moment(rentDate).format('LL')}</strong>
            <br><br>
        Must return on or before:<br>
            <strong>${moment(dueDate).format('LL')}</strong>
        <input type="hidden" value="${rentDate}" name="rentDate">
        <input type="hidden" value="${dueDate}" name="dueDate">
    </div>
    `
    $('summary #summary-date').html(rentDateEl)

}