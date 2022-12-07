$(document).ready(function () {

    if ( $('[data-author]').length > 0 )
    {
        let authorRowDOM = $('.row.author').detach()
        
        $('[data-author]').each(function(index){
            let authorID = $(this).attr('data-author');

            let cloned = authorRowDOM.clone();
            cloned.find(`option[value=${authorID}]`).attr('selected', 'selected')
            cloned.appendTo('.author-multiple-select .container-fluid');
        });
    }



    if ( $('[data-genre]').length > 0 )
    {
        let genreRowDOM = $('.row.genre').detach()
        
        $('[data-genre]').each(function(index){
            let genreID = $(this).attr('data-genre');

            let cloned = genreRowDOM.clone();
            cloned.find(`option[value=${genreID}]`).attr('selected', 'selected')
            cloned.appendTo('.genre-multiple-select .container-fluid');
        });
    }

});