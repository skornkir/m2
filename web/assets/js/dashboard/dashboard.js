$( document ).ready(function() {
    console.log('masonry');
    $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
    });

    $('.rowDashboard').masonry({
        itemSelector: '.dashboard-block',
        columnWidth: '.dashboard-block',
        percentPosition: true
    });
});