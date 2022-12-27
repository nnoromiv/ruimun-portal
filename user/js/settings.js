$(document).ready(function(){
    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      }else{
        input.attr("type", "password");
      }
    });
    function notify(notify){
      $.notifyDefaults({
        type: 'info',
        allow_dismiss: false,
        delay:2000
      });
      $.notify(notify, {
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutRight'
        },
        onShow: function() {
          this.css({'width':'auto','height':'auto'});
        }
      });
    }
    $(document).on('submit', '#profile', function(event){
      $("#submit_post").prop('disabled', true);
      $("#submit_post").html('saving....');
      $('#info').html("");
      event.preventDefault();
      $.ajax({
        url:"assets/scripts/settings",
        method:"POST",
        data:new FormData(this),
        processData: false,
        contentType: false,
        success:function(response){
          if (response === "1") {
            $('#profile')[0].reset();
            notify("Password updated successfully");
          }else{
            $("#submit_post").prop('disabled', false);
            $("#submit_post").text("Save");
            $('#info').html(response);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#submit_post").prop('disabled', false);
          $("#submit_post").html("Save");
          notify("Network error, please check your connection");
        }
      });
    });
  });