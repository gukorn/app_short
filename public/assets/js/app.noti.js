var tabNotificationLoading,loadBoxNoit = true;
$(function($) {
	tabNotificationLoading = $('#tab-notification').html();
    $("#dropdown-notification").click(function(){ 
        if($(this).attr("aria-expanded")!="true" && loadBoxNoit == true){
            $("#tab-notification").html(tabNotificationLoading);
            $.ajax({ 
                url : $("#tab-notification").data('loadnotification'), type: "GET", timeout: 30000 ,
                success:function(e) {
                    loadBoxNoit = false;
                    $("#tab-notification").html(e);
                }
            });
        }
    });
    function loadNotification(){ 
        $.ajax({ 
            url : $("#dropdown-notification").data('loadnotification') , type: "GET",  dataType: "json", timeout: 10000 ,async: false,cache: false,   contentType: false,    processData: false,
            complete:function(data) {  setTimeout(function(){  loadNotification();},30000); },
            success:function(e) {
                if(e.status){  
                    var spanNoti = $("#dropdown-notification").find('span');
                    if(e.data.countNoti>0){
                        spanNoti.html(e.data.countNoti);
                        spanNoti.removeClass('d-none');
                    }else{
                        spanNoti.addClass('d-none');
                    }
                    if(e.data.code != $("#ul-notification").data('code')){
                        loadBoxNoit = true;
                    }  
                }
            }
        });
        
    }
    loadNotification();	
    $("body").on("click","#nav-notification li", function(e){ 
        e.preventDefault();
        $("#nav-notification ,#nav-notification .dropdown-menu").removeClass('show');
        $("#dropdown-notification").attr("aria-expanded",false) ;
        fliemodule = $(this).find($("a")).attr("href");
        iframeBox.attr("src", fliemodule);
    }); 
});
