$(document).ready(function () {
    if ($('.pagination li.prev').hasClass('disabled') && $('.pagination li.next').hasClass('disabled'))
    {
        $('.pagination li.prev').css('display', 'none');
        $('.pagination li.next').css('display', 'none');
    } else
    {
        $('.pagination li.prev').addClass('page-item');
        $('.pagination li.next').addClass('page-item');
        $('.pagination li.prev a').addClass('page-link');
        $('.pagination li.next a').addClass('page-link');
    }
});