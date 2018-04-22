$( document ).ready(function() {
    $('.contract_name.title-table, .checked-document-list a').click(function () {
        console.log('click');
        var fa = $(this).closest('.contract-block-wrapper').find('.checked-document-list .fa');
        var span = $(this).closest('.contract-block-wrapper').find('.checked-document-list span');
        if(fa.hasClass('fa-angle-down')){
            fa.removeClass('fa-angle-down');
            fa.addClass('fa-angle-up');
            span.html('развернуть');
            $(this).closest('.contract-block-wrapper').find('.body-document').hide();
        }
        else{
            if(fa.hasClass('fa-angle-up')){
                fa.removeClass('fa-angle-up');
                fa.addClass('fa-angle-down');
                span.html('свернуть');
                $(this).closest('.contract-block-wrapper').find('.body-document').show();
            }
        }
    });
});