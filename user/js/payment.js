$(document).ready(function() {
    var dataTable = $('#dataTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"assets/scripts/payment",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2, 3],
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
    $(document).on('click', '.reciept', function(){
      var id = $(this).attr('id');
      var url = 'download?id='+id;
      window.open(url);
    });
  });