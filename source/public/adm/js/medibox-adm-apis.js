/* 
    2021.08.28. Dev, botbinoo.
    botbinoo@naver.com
 */

var bfCall = (function(){
    var domain = '/api/';
    var splashTagId = 'test';

    function showSplashLoading()
    {
        $('#'+splashTagId).fadeIn();
    }
    function hideSplashLoading()
    {
        $('#'+splashTagId).fadeOut();
    }
    function ajaxCall(method, type, contentType, params, successThenFn, errorThenFn, async)
    {
        showSplashLoading();
        if(contentType == 'application/json') params = JSON.stringify(params);
        $.ajax({
            url: domain + method
            , data: params
            , type: type
            , async: async
            , contentType: contentType
            , cache: false
            , timeout: 20000
            , success: function(response){ 
              console.log(response); 
              hideSplashLoading();
              successThenFn(params, response);
            }
            , error: function(e, xpr, mm){ 
              console.log(e); 
              hideSplashLoading();
              errorThenFn(params);
            }
        });
    }
    function ajaxCallCust(method, type, contentType, params, successThenFn, errorThenFn, async)
    {
        showSplashLoading();
        if(contentType == 'application/json') params = JSON.stringify(params);
        $.ajax({
            url: method
            , data: params
            , type: type
            , async: async
            , contentType: contentType
            , cache: false
            , timeout: 20000
            , success: function(response){ 
              console.log(response); 
              hideSplashLoading();
              successThenFn(params, response);
            }
            , error: function(e, xpr, mm){ 
              console.log(e); 
              hideSplashLoading();
              errorThenFn(params);
            }
        });
    }
    
    function ajaxCallMulti(method, type, params, successThenFn, errorThenFn, async)
    {
        showSplashLoading();
        $.ajax({
            url: domain + method
            , data: params
            , type: type
            , async: async
            , processData: false
            , contentType: false
            , enctype: 'multipart/form-data'
            , cache: false
            , timeout: 20000
            , success: function(response){ 
              console.log(response);
              hideSplashLoading();
              successThenFn(params, response);
            }
            , error: function(e, xpr, mm){ 
              console.log(e); 
              hideSplashLoading();
              errorThenFn(params);
            }
        });
    }

    function initCodeIdea()
    {
        this.methods = {
            file:{ 
                atchBase64: '/atch/base64',
                atchUpload: '/atch/upload',
                imageUpload: '/common/image/upload',
                /* file, sub_path  */
                userUpload: function (params, successThenFn, errorThenFn){ ajaxCallMulti('/file/ajaxupload', 'POST', 'multipart/form-data', params, successThenFn, errorThenFn, true); }, 
            }, user:{
                members: function (params, successThenFn, errorThenFn){ ajaxCall('users', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                member: function (params, successThenFn, errorThenFn){ ajaxCall('user', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                isDupplicated: function (params, successThenFn, errorThenFn){ ajaxCall('user/check-dupplicate-id', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                add: function (params, successThenFn, errorThenFn){ ajaxCall('user/add', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, successThenFn, errorThenFn){ ajaxCall('user/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                delete: function (params, successThenFn, errorThenFn){ ajaxCall('user/delete', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('user/approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                memoModify: function (params, successThenFn, errorThenFn){ ajaxCall('user/memo-modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                                
            }, point:{
                list: function (params, successThenFn, errorThenFn){ ajaxCall('user/payments', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                collect: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-collect', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                refund: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                use: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-use', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                useSelf: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-use-self', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                cancel: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-cancel', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                types: function (params, successThenFn, errorThenFn){ ajaxCall('point-types', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                shops: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/shops', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                collects: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/collects', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                services: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/shops/services', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
            }
            ,toCurrency: function(x){
                return '&#x20a9;'+x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            ,toNumber: function(x){
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        };
        this.validation = {
        };        
        return this;
    }
    
    window.medibox = initCodeIdea() || [];
}());
