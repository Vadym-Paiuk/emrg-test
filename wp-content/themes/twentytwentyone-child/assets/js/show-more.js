let $ = jQuery.noConflict()
$(document).on('click', '.show-more-info', function (e) {
    e.preventDefault()

    let date = {
        action: 'show_more_info',
        id: $(this).data('id')
    }

    $.ajax({
        type: 'POST',
        url: '/wp-admin/admin-ajax.php',
        data: date,
        success: function (response) {
            if (response.success === true) {
                console.log(response.data)
                lightbox(response.data.image, response.data.description)
            } else {
                console.log('Error')
            }
        },
        error: function () {
            console.log('Error')
        }
    })
})
function lightbox( item_image, item_description ){
    if ($('#lightbox').length > 0) { // #lightbox exists

        //place href as img src value
        $('#content_lightbox').html('<img src="' + item_image + '" /><p>' + item_description + '</p>');

        //show lightbox window - you could use .show('fast') for a transition
        $('#lightbox').show();
    }

    else { //#lightbox does not exist - create and insert (runs 1st time only)

        //create HTML markup for lightbox window
        var lightbox =
            '<div id="lightbox">' +
            '<p>Click to close</p>' +
            '<div id="content_lightbox">' + //insert clicked link's href into img src
            '<img src="' + item_image +'" />' +
            '<p>' + item_description + '</p>' +
            '</div>' +
            '</div>';

        //insert lightbox HTML into page
        $('body').append(lightbox);
    }
}

$('body').on('click', '#lightbox', function() { //must use on, as the lightbox element is inserted into the DOM
    $('#lightbox').hide();
});