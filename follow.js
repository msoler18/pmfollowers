 $jq =jQuery.noConflict();
 
var emailValidation = function(email) {
 
    $jq("#frm_msg").html("");
    $jq("#frm_msg").removeAttr("class");
 
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
 
    if (email == '' || (!emailReg.test(email))) {
        $jq("#frm_msg").html("Please enter valid email");
        $jq("#frm_msg").addClass("error");
        return false;
    }
    else {
        return true;
    }
 
};
 
$jq(document).ready(function() {
 
    /*
     * Make initial subscription to service
     */
    $jq("#subscribeAuthors").live("click",function() {
 
        var email = $jq("#user_email").val();
        if (emailValidation(email)) {
 
            jQuery.ajax({
                type: "post",
                url: ajaxData.ajaxUrl,
                data: "action=subscribe_to_wp_authors&nonce="+ajaxData.ajaxNonce+"&url="+ajaxData.currentURL+"&email="+email,
                success: function(message) {
                    var result = eval('(' + message + ')');
                    if (result.error) {
                        $jq("#frm_msg").html(result.error);
                        $jq("#frm_msg").addClass("error");
                    }
                    if (result.success) {
                        $jq("#frm_msg").html(result.success);
                        $jq("#frm_msg").addClass("success");
                    }
                }
            });
        }
 
    });
 
}
 