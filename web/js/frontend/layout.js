/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function loginFormShow(){
    
    $('#register-tab').removeClass('active');
    $('#login-tab').addClass('active');
    
    
    $('#register-form').addClass('hidden');
    $('#login-form').removeClass('hidden')

    return false
}

function registerFormShow(){
    
    $('#login-tab').removeClass('active');
    $('#register-tab').addClass('active');
    
    $('#login-form').addClass('hidden');
    $('#register-form').removeClass('hidden');
    
    
    return false
}

//
function doAjax(method_name, params, success, error){

    url = '/frontend_dev.php/api/index'
    //    console.log(url)


    console.log(params);
    var options = {
        url: url,
        type: 'GET',
        data: {
            method_name: method_name, 
            params:params
        },
        dataType: 'json',
        async: true,
        success: success,
        error: error
    }
      
    jQuery.ajax(options);
    return false;
}

// get places
function getPlaces(){
    doAjax('getPlaces', {
        "city_id": [1,2,3], 
        "ololo": 'ololo'
    }, 
    function(){
        console.log('success');
    },
    function(){
        console.log('error');
    });
    return false;
}