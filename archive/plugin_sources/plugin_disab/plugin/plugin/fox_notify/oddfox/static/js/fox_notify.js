//$.cookie("isClose",'');
if ($.cookie("isClose") != 'yes') {
    $('#fox_notify_modal').modal('show')
}
$("#isClose").click(function(e){
    $(this).parent().fadeOut(500);
    $('#fox_notify_modal').modal('hide');
    $.cookie("isClose", 'yes', 86400); //60 * 60 * 24
});