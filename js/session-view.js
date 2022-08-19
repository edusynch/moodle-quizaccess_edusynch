function changeCarouselToEvent(event_id, carouselSelector) {
    var carouselElem = $(carouselSelector);
    var photoWrapperElem = carouselElem.find("div[data-event='"+event_id+"']");
    var photoIndex = photoWrapperElem.index();

    carouselElem.carousel(photoIndex);
    carouselElem.carousel('pause');

    $(carouselSelector).get(0).scrollIntoView();
}