$(document).ready(function(){
$(".runstudent").hide();
$('#type').change(function () {
    if($(this).val() == "RUN"){
        $(".runstudent").show();
    } 
    else {
        $(".runstudent").hide();
    }
}) 
$(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        }else{
            input.attr("type", "password");
        }
});

$("#committee1").change(function () {
    var id= $("#committee1").val()
    $.ajax({
        url: 'user/assets/scripts/data',
        data: {committee:id},
        type: 'get',
        success: function(response){
            const countries = JSON.parse(response);
            var match = countries.split(',');
            $("#country1").empty().append('<option>Country 1</option>')
            match.forEach(element => {
                $('#country1').append($('<option>', {
                    value: element,
                    text: element
                }));
            });
        }
    })
})

$("#committee2").change(function () {
    var id= $("#committee2").val()
    $.ajax({
        url: 'user/assets/scripts/data',
        data: {committee:id},
        type: 'get',
        success: function(response){
            const countries = JSON.parse(response);
            var match = countries.split(',');
            $("#country2").empty().append('<option>Country 2</option>')
            match.forEach(element => {
                $('#country2').append($('<option>', {
                    value: element,
                    text: element
                }));
            });
        }
    })
})

$("#committee3").change(function () {
    var id= $("#committee3").val()
    $.ajax({
        url: 'user/assets/scripts/data',
        data: {committee:id},
        type: 'get',
        success: function(response){
            const countries = JSON.parse(response);
            var match = countries.split(',');
            $("#country3").empty().append('<option>Country 3</option>')
            match.forEach(element => {
                $('#country3').append($('<option>', {
                    value: element,
                    text: element
                }));
            });
        }
    })
})

$('#name_hint').text("");
$('#email_hint').text("");
$('#phone_hint').text("");

$('#experience_hint').text("");
$('#affiliation_hint').text("");
$('#position_hint').text("");
$('#city_hint').text("");
$('#state_hint').text("");
$('#country_hint').text("");
$('#zipcode_hint').text("");  
$('#medical_hint').text("");
$('#diet_hint').text("");
$('#referral_hint').text("");    

$('#password_hint').text("");
$('#password_hint2').text("");
$("#password").keyup(function(){
    var password = $(this).val();
    var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        if (!pattern.test(password)) {
        $("#password_hint").text("Password must contain at least 8 characters including an uppercase and a lower case letter and a number");
        }else{
            $("#password_hint").text("");
        }
});
$("#c_password").keyup(function(){
    var c_password = $(this).val();
    var password = $("#password").val();;
    var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        if (password != c_password) {
        $("#password_hint2").text("Passwords do not match");
        }else{
            $("#password_hint2").text("");
        }
});
$(document).on('submit', '#signup', function(event){
    $("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;Signing up');
    $("#submit").prop('disabled', true);
    $('#name_hint').text("");
    $('#email_hint').text("");
    $('#phone_hint').text("");
    $('#experience_hint').text("");
    $('#affiliation_hint').text("");
    $('#position_hint').text("");
    $('#city_hint').text("");
    $('#state_hint').text("");
    $('#country_hint').text("");
    $('#zipcode_hint').text(""); 
    $('#medical_hint').text("");
    $('#diet_hint').text("");
    $('#referral_hint').text("");  
    $('#password_hint').text("");
    $('#password_hint2').text("");
    event.preventDefault();
    $.ajax({
        url:"user/assets/scripts/signup",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        processData:false,
        dataType:"json",
        success:function(data){
            if (data.success) {
                alert("Registration was successful, proceed to log in");
                window.location = 'user/login';
                // setTimeout(function(){window.location = 'user/login'; }, 2000);
                // window.location = 'validate?request_from=validate&email='+data.mail+'&token='+data.token;
            }else if (data.error){
                $('#name_hint').text(data.error);
            }else{
                $('#name_hint').text(data.name);
                $('#email_hint').text(data.email);
                $('#phone_hint').text(data.phone);
                $('#password_hint').text(data.pass);
                $('#password_hint2').text(data.pass2);
                $("#submit").prop('disabled', false);
                $("#submit").html("Sign Up");
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Network error, please try again");
            $("#submit").prop('disabled', false);
            $("#submit").html("Sign Up");
            }
    });
});
});		