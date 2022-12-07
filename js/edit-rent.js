
var rentPage = 1;
var currentBook = $('[data-current-book]').attr('data-current-book');
var currentBorrower = $('[data-current-borrower]').attr('data-current-borrower');



$(document).ready(function () {

    // load all borrowers and books records
    showBorrowers( "", currentBorrower );
    showBooks( "", currentBook );

    togglePages();

    toggleBorrowerNext();
    toggleBookNext();

    validateDate();

    // set rental date to current date
    // let now = moment().format('YYYY-MM-DD')
    // $('#rentalDate').attr('value', now);
    // changeDueDate(now);

    // validateDate()

    // add event listeners to date
    $('input[type="date"]').on('change', function(){
        validateDate();
    });


    // close buttons
    $('.close-borrower').on('click', function() {
       closeBorrower($(this));
    });


    $('.close-book').on('click', function() {
        closeBook($(this));
    });

    


});


/** enable next navigation *******************************************************/
function toggleBorrowerNext()
{
    if ( $('#selected-borrower').children().length > 0 ) {
        $('#nav-borrower-next').show();
    } else {
        $('#nav-borrower-next').hide();
    }
}

function toggleBookNext()
{
    if ( $('#selected-book').children().length > 0 ) {
        $('#nav-book-next').show();
    } else {
        $('#nav-book-next').hide();
    }
}
/** enable next navigation *******************************************************/



/** ajax calls *******************************************************************/
function showBorrowers(str, restrict)
{
    $.ajax(`../ajax/search-borrower.php?search=${str}&restrict=${restrict}`)
        .done(function( data, status, jqXHR ) {

            // load borrowers to the selection panel
            $('#borrower-results').html(data);

            // add event listener to the select button
            $('.select-borrower-tuple').on('click', function() {
                selectBorrowerTuple($(this));
            });
        })
        .fail(function( jqXHR, status, error ){
            console.log('error');
        });
}


function showBooks(str, restrict)
{
    $.ajax(`../ajax/search-book.php?search=${str}&restrict=${restrict}`)
    .done(function( data, status, jqXHR ) {

        // load books to the selection panel
        $('#book-results').html(data);

        // add event listener to the select button
        $('.select-book-tuple').on('click', function() {
            selectBookTuple($(this));
        });
    })
    .fail(function( jqXHR, status, error ){
        console.log('error');
    });
}
/** ajax calls *******************************************************************/



/** restore *******************************************************************/
function restoreBook (thisRestoreButton)
{
    let restoredBook = $(thisRestoreButton).parent().detach();

    $('#selected-book').html(restoredBook);
    $('#selected-book').find('[data-book]')
                       .removeClass('border-warning')
                       .addClass('border-success');
    $('#selected-book').find('[data-book]')
                       .find('.restore-book')
                       .removeClass('restore-book')
                       .addClass('close-book')
                       .html('<i class="fas fa-times"></i>');

    $('.close-book').on('click', function() {
        closeBook($(this));
    });
    toggleBookNext();
}


function restoreBorrower (thisRestoreButton)
{
    let restoredBorrower = $(thisRestoreButton).parent().detach();

    $('#selected-borrower').html(restoredBorrower);
    $('#selected-borrower').find('[data-borrower]')
                       .removeClass('border-warning')
                       .addClass('border-success');
    $('#selected-borrower').find('[data-borrower]')
                       .find('.restore-borrower')
                       .removeClass('restore-borrower')
                       .addClass('close-borrower')
                       .html('<i class="fas fa-times"></i>');

    $('.close-borrower').on('click', function() {
        closeBorrower($(this));
    });
    toggleBorrowerNext();
}
/** restore *******************************************************************/


/** close *******************************************************************/
function closeBook (thisCloseButton)
{
    let removedBook = $(thisCloseButton).parent().attr('data-book');
    if (removedBook == currentBook) {
        let removedCard = $(`[data-book="${removedBook}"]`).detach();
        $('#previous-book').html(removedCard);
        $('#previous-book').find('[data-book]')
                           .removeClass('border-success')
                           .addClass('border-warning');
        $('#previous-book').find('[data-book]')
                           .find('.close-book')
                           .removeClass('close-book')
                           .addClass('restore-book')
                           .html('<i class="fas fa-undo"></i>');

        $('.restore-book').on('click', function() {
            restoreBook($(this));
        });
    } else {
        $(`[data-book="${removedBook}"]`).remove();
        $(`[data-summary-book="${removedBook}"]`).remove();
    }
    toggleBookNext();
}


function closeBorrower (thisCloseButton) 
{
    let removedBorrower = $(thisCloseButton).parent().attr('data-borrower');
    if (removedBorrower == currentBorrower) {
        let removedCard = $(`[data-borrower="${removedBorrower}"]`).detach();
        $('#previous-borrower').html(removedCard);
        $('#previous-borrower').find('[data-borrower]')
                           .removeClass('border-success')
                           .addClass('border-warning');
        $('#previous-borrower').find('[data-borrower]')
                           .find('.close-borrower')
                           .removeClass('close-borrower')
                           .addClass('restore-borrower')
                           .html('<i class="fas fa-undo"></i>');

        $('.restore-borrower').on('click', function() {
            restoreBorrower($(this));
        });
    } else {
        $(`[data-borrower="${removedBorrower}"]`).remove();
        $(`[data-summary-borrower="${removedBorrower}"]`).remove();
    }
    toggleBorrowerNext();
}
/** close *******************************************************************/


/** select tuple ************************************************************/
function selectBorrowerTuple (thisSelectButton)
{
    let tuple = $(thisSelectButton).parent().parent().children();
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
    <div class="p-4" data-summary-borrower="${id}">
        <div><strong>ID:</strong> ${id}</div>
        <div>${name}</div>
        <div>${email}</div>
        <div>${phone}</div>
        <div>${address}</div>
        <div>${postal}</div>
        <input type="hidden" value="${id}" name="borrowerID">
    </div>
    `;
   
    insertSelected ( 
        $('#selected-borrower'), 
        selectedBorrower, 
        $('summary > #summary-borrower'),
        selectedBorrowerSummary,
        'data-borrower'
    );


    $('.close-borrower').on('click', function() {
        closeBorrower($(this));
    });
}

function selectBookTuple (thisSelectButton)
{
    let tuple = $(thisSelectButton).parent().parent().children();
    let id = tuple.eq(0).text();
    let title = tuple.eq(1).text();
    let year = tuple.eq(3).text();
    let author = tuple.eq(2).text();

    // to avoid duplicate selections
    let selectedBook = `
    <div class="p-4 border border-success position-relative" data-book="${id}">
        <div class="close close-book"><i class="fas fa-times"></i></div>
        <div><strong>ID:</strong> ${id}</div>
        <div>${title} (${year})</div>
        <div>by ${author}</div>
    </div>
    `;

    let selectedBookSummary = `
    <div class="p-4" data-summary-book="${id}">
        <div><strong>ID:</strong> ${id}</div>
        <div>${title} (${year})</div>
        <div>by ${author}</div>
        <input type="hidden" value="${id}" name="bookID[]">
    </div>
    `;

    insertSelected ( 
        $('#selected-book'), 
        selectedBook, 
        $('summary > #summary-book'),
        selectedBookSummary,
        'data-book'
    );

    $('.close-book').on('click', function() {
        closeBook($(this));
    });
}
/** select tuple ************************************************************/


function insertToSummary(selectedEl, summaryCon)
{
    let selectedClone = selectedEl.children('.border-success').clone();
    selectedClone.removeAttr('class').removeAttr('data-borrower');
    selectedClone.find('.close').remove();
    selectedClone.find('div:has(strong)').remove();
    summaryCon.html(selectedClone);
}


function showSummary()
{
    insertToSummary( $('#selected-borrower'), $('#summary-borrower') );
    insertToSummary( $('#selected-book'), $('#summary-book') );
    $('#summary-rental').html( moment( $('#rentalDate').val() ).format('LL') );
    $('#summary-due').html( moment( $('#dueDate').val() ).format('LL') );

}

function populateForm()
{
    let selectedBorrowerID = $('#selected-borrower').children('.border-success').attr('data-borrower');
    let selectedBookID = $('#selected-book').children('.border-success').attr('data-book');
    let selectedRentalDate = $('#rentalDate').val();
    let selectedDueDate = $('#dueDate').val();
    $('[name="form-new-borrower"]').val( selectedBorrowerID );
    $('[name="form-new-book"]').val( selectedBookID );
    $('[name="form-new-rentalDate"]').val( selectedRentalDate );
    $('[name="form-new-dueDate"]').val( selectedDueDate );

}


function insertSelected(aContainer, aContent, bContainer, bContent, flag)
{
    if (aContainer.children().length > 0) {
        let card = aContainer.find(`[${flag}]`); // get the index of the card
        let index = card.attr(flag);
        if (index == currentBook && flag == 'data-book') {
            // console.log(index, currentBook);
            closeBook( card.find('.close-book') );
        }

        if (index == currentBorrower && flag == 'data-borrower') {
            closeBorrower( card.find('.close-borrower') );
        }
    }
    aContainer.html(aContent);
    bContainer.html(bContent);
    
    if (flag == 'data-book') {
        toggleBookNext();
    }
    if (flag == 'data-borrower') {
        toggleBorrowerNext();
    }
}


function togglePages()
{  
    // activate first page
    $('[data-page]').addClass('d-none');
    $(`[data-page=${rentPage}]`).removeClass('d-none');
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
    $('#rentalDate').val(date);
    let rentalDate = date;
    let dueDate = moment(rentalDate).add(2, 'week').format('YYYY-MM-DD');
    // console.log(dueDate);
    $('#dueDate').val(dueDate);
}

function validateDate()
{
    rentDate = $('#rentalDate').val();
    dueDate = $('#dueDate').val();
    updateSummaryDates(rentDate, dueDate);

    console.log(rentDate);
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
    $('summary > #summary-date').html(rentDateEl)

}