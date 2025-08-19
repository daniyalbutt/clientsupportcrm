$( function() {
    var dateFormat = "dd/mm/yy",
        from = $( ".dp-date-range-from" )
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 2,
                dateFormat: 'dd/mm/yy',
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( ".dp-date-range-to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: 'dd/mm/yy'
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
        });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }
    $(".searcher").select2();
});

// $('form').submit(function(){
//     $(this).find('button[type="submit"]').attr('disabled', true);
// });

$(function() {
    $('.search-input input').on('keyup change', function(ev) {
        // pull in the new value
        var searchTerm = $(this).val();
        $('#main-menu-navigation').removeHighlight();
        // disable highlighting if empty
        $('#main-menu-navigation li').removeClass('open');
        if ( searchTerm ) {
            // highlight the new term
            $('#main-menu-navigation > li > a').highlight( searchTerm );
            $('#main-menu-navigation li').children().find('.highlight').parents('.nav-item').addClass('open');
            var custom_scroll = $('.highlight').offset().top;
            $('.ps-container').scrollTop(custom_scroll).perfectScrollbar('update');
        }
    });
});


$(function(){
    $(window).on("load",function(){
        
    });
});