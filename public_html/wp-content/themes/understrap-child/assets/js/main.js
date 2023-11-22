$ = jQuery;
$(document).on('submit', 'form.ajax', function (e) {
    e.preventDefault();
    let self = this;

    $.ajax({
        type: $(self).attr('method'),
        url: $(self).attr('action'),
        data: new FormData(self),
        processData: false,
        contentType: false,
        complete: (r) => {
            $(self).find('[type=submit]').remove();
        },
    })
});