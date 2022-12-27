$(document).ready(function (){
    setInterval(function(){get_posts()} , 300000);
    $(document).on('click', '.refresh', function(){
      $("#refresh").html("getting topics.....");
      get_posts();
      setTimeout(function(){
        $("#refresh").html('<i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh');
      }, 3000);
    });
    get_posts();
    function get_posts(){
      $.ajax({
        url:"assets/scripts/getdocs",
        method:"GET",
        dataType:"html",
        success:function(response){
            $(".getdocs").html("");
            $('.getdocs').html(response);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          notify("Network error, cannot get posts at this time, check your connection");
        }
      });
    }
  });