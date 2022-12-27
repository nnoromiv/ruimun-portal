$(document).ready(function() {
    var dataTable = $('#dataTable').DataTable({
      "processing":true,
      "serverSide":true,
      "order":[],
      "ajax":{
        url:"assets/scripts/members",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 1, 2, 3, 4, 5, 6, 7],
          "orderable":false,
        },
      ],
    });

      $("#dataTable").on("click", ".viewMember", function () {
          $("#viewdetailsModal").modal("show");           
          $("#member_details").html($(this).data('name'))
          $("#my_name").html($(this).data('name'))
          $("#my_email").html($(this).data('email'))
          $("#phone").html($(this).data('phone'))
          $("#type").html($(this).data('type'))
          $("#gender").html($(this).data('gender'))
          $("#medical").html($(this).data('medical'))
          $("#experience").html($(this).data('experience'))
          $("#affiliation").html($(this).data('affiliation'))
          $("#position").html($(this).data('position'))
          $("#matric").html($(this).data('matric'))
          $("#dept").html($(this).data('dept'))
          $("#referral").html($(this).data('referral'))
          $("#city").html($(this).data('city'))
          $("#state").html($(this).data('state'))
          $("#country").html($(this).data('country'))
          $("#shirt").html($(this).data('shirt'))
          $("#diet").html($(this).data('diet'))
          $("#committee1").html($(this).data('committee1'))
          $("#committee2").html($(this).data('committee2'))
          $("#committee3").html($(this).data('committee3'))
          $("#country1").html($(this).data('country1'))
          $("#country2").html($(this).data('country2'))
          $("#country3").html($(this).data('country3'))            
      })

      $("#dataTable").on("click", ".payment", function () {
          $("#paymentModal").modal("show");   
          $("#name").val($(this).data('name'))            
          $("#email").val($(this).data('email'))
          $("#paytype").val($(this).data('type'))
          $("#userid").val($(this).attr('id')) 
          $("#btnActivatePayment").click(function () {
            $("#formActivatePayment").validate({
                submitHandler: submitformActivatePayment,
                errorClass: "invalid",
            });

            function submitformActivatePayment(e) {
                var formData = $("#formActivatePayment").serialize();
                $.ajax({
                    type: "POST",
                    url: "assets/scripts/activatePayment",
                    data: formData,
                    dataType: "json",
                    beforeSend: function () {
                        $("#btnActivatePayment").html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == "1") {
                          $("#btnActivatePayment").html("Submit");
                          
                          notify("Payment Activated");
                        }
                        else{
                          notify(response);
                          $("#btnActivatePayment").html("Submit");
                        }
                    },
                    error: function (response) {
                        console.log(response);
                        $("#btnActivatePayment").html("Submit");
                        notify(response.responseText);
                    },
                });
            }
          })
        })


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
    $(document).on('click', '.active0', function(){
      var id = $(this).attr('id');
      var type = 0;
      if (confirm("De-active member account")) {
        $.ajax({
          url:"assets/scripts/active",
          method:"POST",
          data:{id:id,type:type},
          success:function(response){
            if (response === "1") {
              notify("Member account de-activated");
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
    $(document).on('click', '.active1', function(){
      var id = $(this).attr('id');
      var type = 1;
      if (confirm("Activate member account")) {
        $.ajax({
          url:"assets/scripts/active",
          method:"POST",
          data:{id:id,type:type},
          success:function(response){
            if (response === "1") {
              notify("Member account activated");
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