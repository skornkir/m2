$( document ).ready(function() {

    $('.rowDashboard').masonry({
        itemSelector: '.dashboard-block',
        columnWidth: '.dashboard-block',
        percentPosition: true
    });
});