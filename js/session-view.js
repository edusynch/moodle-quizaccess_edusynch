$(document).ready(function(){
    $('#mark-reviewed').on('change', function(){
        markAsReviewed();
    }); 
});

function changeCarouselToEvent(event_id, carouselSelector) {
    var carouselElem = $(carouselSelector);
    var photoWrapperElem = carouselElem.find("div[data-event='"+event_id+"']");
    var photoIndex = photoWrapperElem.index();

    carouselElem.carousel(photoIndex);
    carouselElem.carousel('pause');

    $(carouselSelector).get(0).scrollIntoView();
}

function markAsReviewed() {
    var reviewed = $('#mark-reviewed').is(':checked') ? 1 : 0;
    var url = $('#reviewed-wrapper').attr('data-url') + '&reviewed=' + reviewed;
    $.ajax({
        url: url, 
        dataType: 'json',
    }).done(function(result){
        if(result.success) {
            $('#success-message').text(result.message);
            $('#success-container').fadeIn();
            setTimeout(function() {
                $('#success-container').fadeOut();
            }, 3000);
        } 
    });
}