$(document).ready(function() {
    $(document).on('click', '.new', function(event) {
      $('#postForm')[0].reset();
      $('#info').html("");
      $("#submit_post").prop('disabled', false);
      $("#submit_post").html("Create");
    });
    var dataTable = $('#dataTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"assets/scripts/posts",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2, 3, 4, 5],
          "orderable":false,
        },
      ],
    });
    $(document).on('click', '.refresh', function(){
      $("#refresh").html("refreshing.....");
      dataTable.ajax.reload();
      setTimeout(function(){
        $("#refresh").html('<i style="padding-bottom:1px;" class="fas fa-fw fa-sync"></i>&nbsp;Refresh');
      }, 3000);
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
    $(document).on('submit', '#postForm', function(event){
      $("#submit_post").prop('disabled', true);
      $("#submit_post").html('creating....');
      $('#info').html("");
      event.preventDefault();
      $.ajax({
        url:"assets/scripts/post",
        method:"POST",
        data:new FormData(this),
        processData: false,
        contentType: false,
        success:function(response){
          if (response === "1") {
            dataTable.ajax.reload();
            $('#postForm')[0].reset();
            $('#postModal').modal('hide');
            notify("New post created");
          }else{
            $("#submit_post").prop('disabled', false);
            $("#submit_post").text("Create");
            $('#info').html(response);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#submit_post").prop('disabled', false);
          $("#submit_post").html("Create");
          notify("Network error, please check your connection");
        }
      });
    });
    $(document).on('click', '.remove', function(){
      var id = $(this).attr('id');
      if (confirm("Delete post")) {
        $.ajax({
          url:"assets/scripts/dpost",
          method:"POST",
          data:{id:id},
          success:function(response){
            if (response === "1") {
              notify("Post deleted");
              dataTable.ajax.reload();
            }else{
              notify(response);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
             notify("Network error, please check your connection");
          }
        });
      }else{
        return false;
      }
    });
    $(document).on('click', '.publish', function(){
      var id = $(this).attr('id');
      if (confirm("Publish post")) {
        $.ajax({
          url:"assets/scripts/publish",
          method:"POST",
          data:{id:id},
          success:function(response){
            if (response === "1") {
              notify("Post published successfully");
              dataTable.ajax.reload();
            }else{
              notify(response);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
             notify("Network error, please check your connection");
          }
        });
      }else{
        return false;
      }
    });
    $(document).on('click', '.view', function(){
      var id = $(this).attr('id');
      $.ajax({
        url:"assets/scripts/viewpost",
        method:"POST",
        data:{id:id},
        success:function(response){
          if (response === "3") {
            notify("This post has been deleted");
          }else if (response === "4") {
            notify("You are not logged in, please refresh your page");
          }else{
            $('#showPost').modal('show');
            $("#postbody").html("");
            $("#postbody").html(response);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           alert("Network error, please check your connection")
        }
      });
    });
    $(document).on('click', '.comment', function(){
      var id = $(this).attr('id');
      $.ajax({
        url:"assets/scripts/comments",
        method:"POST",
        data:{id:id},
        success:function(response){
          if (response === "3") {
            notify("No comments for this post");
          }else if (response === "4") {
            notify("You are not logged in, please refresh your page");
          }else{
            $('#commentsModal').modal('show');
            $("#commentsbody").html("");
            $("#commentsbody").html(response);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
           notify("Network error, please check your connection");
        }
      });
    });
  });