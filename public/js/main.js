/* Bootstrap 5 tooltips */
/* https://getbootstrap.com/docs/5.2/components/tooltips/#enable-tooltips */
$(document).ready(function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, {
        html: true
    }))
});

/* Bootstrap 5 tooltips */
/* https://getbootstrap.com/docs/5.2/components/popovers/#enable-popovers */
$(document).ready(function () {
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl, {
        html: true,
        trigger: 'hover',
    }))
});

/* https://api.jqueryui.com/autocomplete */
$(document).ready(function () {
    $('#qs').autocomplete({
/* jQuery UI autocomplete */
        delay: 500,
        minLength: 3,
        source: function( request, response ) {
            $.ajax({
                url: '/search-autocomplete',
                type : 'POST',
                dataType: "json",
                data: {
                    "q": $('#qs').val()
                },
                success: function(data) {
                    /* @TODO убрать console.log */
                    console.log(data);
                    response(data);
                },
            });
        },
        select: function(event, ui) {
            $('#qs').val(ui.item.value);
            $('#main-search').submit();
        }
    })
});