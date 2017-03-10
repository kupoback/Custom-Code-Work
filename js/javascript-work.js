$(function() {

                     // This will be your element you're selecting getting
                     // all the heights from. Set this to the outer most 
                     // container of your content, unless it has to be the
                     // box. Such as the first div before the content shows
 var _carouselItem = $( '.pageable-content' ),
                     // This function will get the outerHeight of the element
                     // including padding and margin
    _eleHeight  = _carouselItem.map(function() {	return $(this).outerHeight();	}).get(),
    _maxHeight  = Math.max.apply(null, _eleHeight);
        
        
}
