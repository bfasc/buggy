//priority rating code from: https://codepen.io/depy/pen/vEWWdw
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });

  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });


  /* 2. Action to perform on click */
  var unClick = false;
  $('#stars li').on('click', function(){
    if(starClicks == 0) {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
          $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
          $(stars[i]).addClass('selected');
        }
        unClick = true;
    } else {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');
        //if last selected star
        if($(stars[onStar-1]).hasClass('selected') && !$(stars[onStar]).hasClass('selected')) {
            for (i = 0; i < stars.length; i++) {
              $(stars[i]).removeClass('selected');
            }
        }
        unClick = false;
    }
  });
