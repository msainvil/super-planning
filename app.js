$('#login-btn').click(function(){
    $('#login-button').fadeOut("fast",function(){
      $("#container").fadeIn();
      TweenMax.from("#container", .2, { scale: 0, ease:Sine.easeInOut});
      TweenMax.to("#container", .2, { scale: 1, ease:Sine.easeInOut});
    });
  });
  $(".close-btn").click(function(){
    TweenMax.from("#container", .2, { scale: 1, ease:Sine.easeInOut});
    TweenMax.to("#container", .2, { left:"0px", scale: 0, ease:Sine.easeInOut});
    $("#container, #forgotten-container").fadeOut(200, function(){
      $("#login-button").fadeIn(200);
    });
  });
  


}