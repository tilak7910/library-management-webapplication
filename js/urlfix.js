$(document).ready(function () {
    $('.menu ul li a').each(function(index){
        let href = $(this).attr('href');
        newHref = '../' + href;
        $(this).attr('href', newHref);
    });
});