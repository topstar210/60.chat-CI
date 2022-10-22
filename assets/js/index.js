$(document).ready(function(){
    let currYear = new Date().getFullYear();
    for( let y = currYear-18; y >= currYear-65; y-- ){
        $('#birthday_year').append('<option value="'+y+'">'+y+'</option>');
    }
    for( let m = 1; m <= 12; m++ ){
        $('#birthday_month').append('<option value="'+m+'">'+m+'</option>');
    }
    var today = new Date();
    var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth()+1, 0);
    for( let d = 1; d <= lastDayOfMonth.getDate(); d++ ){
        $('#birthday_day').append('<option value="'+d+'">'+d+'</option>');
    }
})

function checkForm() {
    let ok = true;
    let year = $('#birthday_year').val() * 1;
    $('.input_error').removeClass('input_error');
    $('.text_red').removeClass('text_red');
    $('#error_gender').hide();
    
    let currYear = new Date().getFullYear();

    if(year == 0){
        $('#error_message').addClass('text_red');
        ok = false;
    } else if($('#birthday_month').val() * 1 == 0) {
        $('#error_message').addClass('text_red');
        ok = false;
    } else if($('#birthday_day').val() * 1 == 0) {
        $('#error_message').addClass('text_red');
        ok = false;
    }
    if(year + 18 > currYear * 1){
        $('#birthday_year').addClass('input_error');
        $('#birthday_month').addClass('input_error');
        $('#birthday_day').addClass('input_error');
        $('#error_message').addClass('text_red');
        ok = false;
    }
    
    /*let gender = $('#groub_gender :checked').val();
     
    if(!gender){
        $('#error_gender').show();
        ok = false;
    }*/

    return ok;
}