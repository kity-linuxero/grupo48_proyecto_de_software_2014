var updateTimer = 0;
  
  function setupMessageBox(){
    showMessage(); //displays message on page load
    jQuery(window).scroll(function() {
       showMessage();
    });    
    clearTimeout(updateTimer);
    activateTimer();
  };
 
  function activateTimer() {
    //updateTimer = setTimeout('jQuery("#message_box").remove()', 3000);
    updateTimer = setTimeout('jQuery("#message_box").animate({ top:"-=15px",opacity:0 }, "slow")', 3000);
    
    
  }
 
  function showMessage(){
      jQuery('#message_box').animate({top:jQuery(window).scrollTop() + "px" }, {queue: false,duration:350});
      
  }
