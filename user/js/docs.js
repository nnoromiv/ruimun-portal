$(document).ready(function() {
    $(document).on('click', '.new', function(event) {
      $('#postForm')[0].reset();
      $('#info').html("");
      $("#submit_post").prop('disabled', false);
      $("#submit_post").html("Upload");
    });
    var dataTable = $('#dataTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"assets/scripts/docs",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2, 3, 4],
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
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $(document).on('submit', '#postForm', function(event){
      $("#submit_post").prop('disabled', true);
      $("#submit_post").html('uploading....');
      $('#info').html("");
      event.preventDefault();
      $.ajax({
        url:"assets/scripts/doc",
        method:"POST",
        data:new FormData(this),
        processData: false,
        contentType: false,
        success:function(response){
          if (response === "1") {
            dataTable.ajax.reload();
            $('#postForm')[0].reset();
            $('#postModal').modal('hide');
            notify("Document uploaded successfully");
          }else{
            $("#submit_post").prop('disabled', false);
            $("#submit_post").text("Upload");
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
      if (confirm("Delete all document and all document data")) {
        $.ajax({
          url:"assets/scripts/ddoc",
          method:"POST",
          data:{id:id},
          success:function(response){
            if (response === "1") {
              notify("Document deleted");
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
  });