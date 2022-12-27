$(document).ready(function() {
    var dataTable = $('#dataTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"assets/scripts/payments",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2, 3, 4, 5, 6],
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
  });