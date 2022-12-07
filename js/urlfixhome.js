$(document).ready(function () {
    $('.menu ul li a').each(function(index){
        let href = $(this).attr('href');
        newHref = href.replace('../', '');
        $(this).attr('href', newHref);
    });
});