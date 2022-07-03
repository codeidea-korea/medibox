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
                changePassword: function (params, successThenFn, errorThenFn){ ajaxCall('user/change-password', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                add: function (params, successThenFn, errorThenFn){ ajaxCall('user/add', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, successThenFn, errorThenFn){ ajaxCall('user/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                refund: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('user/approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                delete: function (params, successThenFn, errorThenFn){ ajaxCall('user/delete', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                                                
            }, point:{
                // 나의 포인트
                mine: function (params, successThenFn, errorThenFn){ ajaxCall('user/points', 'POST', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                history: function (params, successThenFn, errorThenFn){ ajaxCall('user/payments', 'POST', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                use: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-use', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                refund: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                collect: function (params, successThenFn, errorThenFn){ ajaxCall('user/point-collect', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                types: function (params, successThenFn, errorThenFn){ ajaxCall('point-types', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                shops: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/shops', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                collects: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/collects', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                services: function (params, successThenFn, errorThenFn){ ajaxCall('point-types/shops/services', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                checkApprove: function (params, successThenFn, errorThenFn){ ajaxCall('point/check-approve', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                coupon: {
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('coupon/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('coupon', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    mine: function (params, successThenFn, errorThenFn){ ajaxCall('coupons/mine', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    checkApprove: function (params, successThenFn, errorThenFn){ ajaxCall('coupon-check-approve', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                    history:{
                        one: function (params, id, successThenFn, errorThenFn){ ajaxCall('coupon-history/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('coupon-history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                },
                membership: {
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('membership/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('membership', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    checkApprove: function (params, successThenFn, errorThenFn){ ajaxCall('voucher-check-approve', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                    history:{
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('membership-history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                },
            }, partner:{
                one: function (params, id, successThenFn, errorThenFn){ ajaxCall('partners/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                findAll: function (params, successThenFn, errorThenFn){ ajaxCall('partners-all', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },            
            }, store:{
                one: function (params, id, successThenFn, errorThenFn){ ajaxCall('stores/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                findAll: function (params, successThenFn, errorThenFn){ ajaxCall('stores-all', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                serviceAll: function (params, successThenFn, errorThenFn){ ajaxCall('stores-services', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  

                reservation:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('reservations', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('reservations/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('reservations/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    status: function (params, id, successThenFn, errorThenFn){ ajaxCall('reservations/'+id+'/status', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('reservations/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('reservations', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                    day: function (params, successThenFn, errorThenFn){ ajaxCall('reservations/day', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                    check: function (params, successThenFn, errorThenFn){ ajaxCall('reservations/check-available', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  

                }
            }, contents:{
                notice:{
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('contents/notice/app/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('contents/notice/app', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                faq:{
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('contents/faq/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('contents/faq', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                help:{
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('contents/help/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('contents/help', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                }
            },
            event:{
                coupon: {
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('event-coupon/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('event-coupon', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    join: function (params, id, successThenFn, errorThenFn){ ajaxCall('event-coupon/'+id+'/join', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    
                }
            }, sms:{

                sendAuth: function (params, successThenFn, errorThenFn){ ajaxCall('auth/sms/send', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                checkAuth: function (params, successThenFn, errorThenFn){ ajaxCall('auth/sms/check', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },                            
            }
            ,toCurrency: function(x){
                return '&#x20a9;'+(x + '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            ,toNumber: function(x){
                return (x + '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }, share:function(info){
                if(window.navigator && window.navigator.share) {
                    window.navigator.share({
                        title: info.title,
                        text: info.text,
                        url: info.url,
                    });
                } else {
                    alert('공유 기능이 제한된 브라우저입니다.');
                }
            }
        };
        this.validation = {
        };        
        return this;
    }
    
    window.medibox = initCodeIdea() || [];
}());