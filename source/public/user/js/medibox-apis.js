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

                login: function (params, successThenFn, errorThenFn){ ajaxCall('user/login', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                logout: function (params, successThenFn, errorThenFn){ ajaxCall('user/logout', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                isDupplicated: function (params, successThenFn, errorThenFn){ ajaxCall('user/check-dupplicate-id', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                add: function (params, successThenFn, errorThenFn){ ajaxCall('user/add', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, successThenFn, errorThenFn){ ajaxCall('user/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('user/approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                delete: function (params, successThenFn, errorThenFn){ ajaxCall('user/delete', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                                
            }, point:{
                // 나의 포인트
                mine: function (params, successThenFn, errorThenFn){ ajaxCall('user/points', 'POST', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                history: function (params, successThenFn, errorThenFn){ ajaxCall('user/payments', 'POST', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                use: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-use', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },

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