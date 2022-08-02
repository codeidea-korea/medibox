/* 
    2021.08.28. Dev, botbinoo.
    botbinoo@naver.com
 */

var bfCall = (function(){
    var domain = '/api/';
    var splashTagId = 'test';

    function showSplashLoading()
    {
//        $('#'+splashTagId).fadeIn();
    }
    function hideSplashLoading()
    {
        $('#'+splashTagId).fadeOut();
    }
    function ajaxCallHistory(action, params)
    {
        var menu = $('.loaction').html().replace('</span><span>', '>').replaceAll('<span>', '').replaceAll('</span>', '');
        if(menu == '' || action == '') return;

        $.ajax({
            url: domain + 'admin/history/action'
            , data: JSON.stringify({
                admin_seqno: admin_seqno,
                admin_id: admin_id,
                menu: menu,
                action: action,
                params: params,
            })
            , type: 'POST'
            , async: false
            , contentType: 'application/json'
            , cache: false
            , timeout: 20000
            , success: function(response){ 
              console.log(response); 
            }, error: function(e, xpr, mm){ 
              console.log(e); 
            }
        });
    }
    function ajaxCall(action, method, type, contentType, params, successThenFn, errorThenFn, async)
    {
        showSplashLoading();

        if(contentType == 'application/json') params = JSON.stringify(params);

        ajaxCallHistory(action, params);

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
                members: function (params, successThenFn, errorThenFn){ ajaxCall('', 'users', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                member: function (params, successThenFn, errorThenFn){ ajaxCall('회원 단건 조회', 'user', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                isDupplicated: function (params, successThenFn, errorThenFn){ ajaxCall('회원 등록에서 아이디 중복 확인', 'user/check-dupplicate-id', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                add: function (params, successThenFn, errorThenFn){ ajaxCall('회원 등록', 'user/add', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, successThenFn, errorThenFn){ ajaxCall('회원 수정', 'user/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                delete: function (params, successThenFn, errorThenFn){ ajaxCall('회원 삭제', 'user/delete', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('회원 가입 승인', 'user/approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                
                memoModify: function (params, successThenFn, errorThenFn){ ajaxCall('회원 메모 수정', 'user/memo-modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                membershipCardNo: function (params, successThenFn, errorThenFn){ ajaxCall('회원 멤버쉽 카드정보 수정', 'user/membership-card/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                                
            }, point:{
                list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'user/payments', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                collect: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트/패키지 적립', 'user/point-collect', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                refund: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트/패키지 환불', 'user/point-refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                use: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트/패키지 사용', 'user/point-use', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                useSelf: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트/패키지 사용', 'user/point-use-self', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                cancel: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트 결제 서비스 사용취소', 'user/point-cancel', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                approve: function (params, successThenFn, errorThenFn){ ajaxCall('회원 포인트 결제 서비스 승인취소', 'user/point-approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                types: function (params, successThenFn, errorThenFn){ ajaxCall('', 'point-types', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                shops: function (params, successThenFn, errorThenFn){ ajaxCall('', 'point-types/shops', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                collects: function (params, successThenFn, errorThenFn){ ajaxCall('', 'point-types/collects', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                calculate: function (params, successThenFn, errorThenFn){ ajaxCall('', 'store/calculate', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                
                history: function (params, successThenFn, errorThenFn){ ajaxCall('', 'point/history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                conf: function (params, successThenFn, errorThenFn){ ajaxCall('메디박스 포인트 설정 변경', 'point/auto-conf', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                services: function (params, successThenFn, errorThenFn){ ajaxCall('', 'point-types/shops/services', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                products: {
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('포인트 서비스 등록', 'products', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('포인트 서비스 수정', 'products/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('포인트 서비스 삭제', 'products/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'products/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'products', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                }, 
                vouchers: {
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('바우처 등록', 'vouchers', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('바우처 수정', 'vouchers/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('바우처 삭제', 'vouchers/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'vouchers/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'vouchers', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                    cancel: function (params, successThenFn, errorThenFn){ ajaxCall('회원 바우처 결제 서비스 사용취소', 'user/voucher-cancel', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    approve: function (params, successThenFn, errorThenFn){ ajaxCall('회원 바우처 결제 서비스 승인취소', 'user/voucher-approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    
                    collect: function (params, successThenFn, errorThenFn){ ajaxCall('바우처 적립', 'user/voucher-collect', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    refund: function (params, successThenFn, errorThenFn){ ajaxCall('바우처 환불', 'user/voucher-refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    own: function (params, successThenFn, errorThenFn){ ajaxCall('', 'my-voucher', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    
                },
                coupon: {
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('쿠폰 등록', 'coupon', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('쿠폰 수정', 'coupon/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    status: function (params, id, successThenFn, errorThenFn){ ajaxCall('쿠폰 발급상태 변경', 'coupon/'+id+'/status', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('쿠폰 삭제', 'coupon/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'coupon/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'coupon', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                    cancel: function (params, successThenFn, errorThenFn){ ajaxCall('회원 쿠폰 서비스 사용취소', 'user/coupon-cancel', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    approve: function (params, successThenFn, errorThenFn){ ajaxCall('회원 쿠폰 서비스 승인취소', 'user/coupon-approve', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                
                    history:{
                        one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'coupon-history/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'coupon-history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                },
                membership: {
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('멤버쉽 등록', 'membership', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('멤버쉽 수정', 'membership/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    status: function (params, id, successThenFn, errorThenFn){ ajaxCall('멤버쉽 발급 상태 변경', 'membership/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('멤버쉽 삭제', 'membership/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    collect: function (params, successThenFn, errorThenFn){ ajaxCall('멤버쉽 적립', 'membership-user/collect', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    refund: function (params, successThenFn, errorThenFn){ ajaxCall('멤버쉽 환불', 'membership-user/refund', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    own: function (params, successThenFn, errorThenFn){ ajaxCall('', 'membership-history/user', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'membership/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'membership', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                    history:{
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'membership-history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                },
            }, contents:{
                notice:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('공지사항 등록', 'contents/notice/app', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('공지사항 삭제', 'contents/notice/app/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/notice/app/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/notice/app', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                partnerNotice:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('파트너 공지사항 등록', 'contents/notice/partner', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('파트너 공지사항 삭제', 'contents/notice/partner/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/notice/partner/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/notice/partner', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                faq:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('자주 묻는 질문 등록', 'contents/faq', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('자주 묻는 질문 삭제', 'contents/faq/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/faq/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/faq', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                help:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('도움말 등록', 'contents/help', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('도움말 삭제', 'contents/help/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/help/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/help', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                usage:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('이용방침 등록', 'contents/usage', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('이용방침 수정', 'contents/usage/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('이용방침 삭제', 'contents/usage/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/usage/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/usage', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                privacy:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('개인정보처리방침 등록', 'contents/privacies', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('개인정보처리방침 수정', 'contents/privacies/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('개인정보처리방침 삭제', 'contents/privacies/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/privacies/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/privacies', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                },
                template:{
                    choose: function (params, successThenFn, errorThenFn){ ajaxCall('프론트 메인 화면 템플릿 변경', 'contents/template/choose', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    choosen: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'contents/template/choosen', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'contents/template', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                }
            }, partner:{
                add: function (params, successThenFn, errorThenFn){ ajaxCall('제휴사 등록', 'partners', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('제휴사 삭제', 'partners/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('제휴사 수정', 'partners/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'partners/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'partners', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, false); },            
                findAll: function (params, successThenFn, errorThenFn){ ajaxCall('', 'partners-all', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, false); },            
            }, store:{
                add: function (params, successThenFn, errorThenFn){ ajaxCall('매장 등록', 'stores', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 수정', 'stores/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                modifyTime: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장별 예약가능시간 수정', 'stores/'+id+'/modifyTime', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 삭제', 'stores/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'stores/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'stores', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                findAll: function (params, successThenFn, errorThenFn){ ajaxCall('', 'stores-all', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, false); },  

                manager:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('매장에 소속된 디자이너 등록', 'managers', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장에 소속된 디자이너 수정', 'managers/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장에 소속된 디자이너 삭제', 'managers/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'managers/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'managers', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, false); },  

                    services:{
                        add: function (params, successThenFn, errorThenFn){ ajaxCall('매장 서비스 등록', 'manager-services', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                        modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 서비스 수정', 'manager-services/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                        remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 서비스 삭제', 'manager-services/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                        one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'manager-services/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'manager-services', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, false); },  

                    }
                }, holiday:{
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'manager-holiday', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 휴일 설정', 'manager-holiday/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('매장 휴일 삭제', 'manager-holiday/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    
                }, reservation:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('예약 정보 추가', 'reservations', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('예약 정보 수정', 'reservations/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('예약 정보 삭제', 'reservations/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    status: function (params, id, successThenFn, errorThenFn){ ajaxCall('예약 상태 변경', 'reservations/'+id+'/status', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'reservations/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'reservations', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                    day: function (params, successThenFn, errorThenFn){ ajaxCall('', 'reservations/day', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  
                    check: function (params, successThenFn, errorThenFn){ ajaxCall('', 'reservations/check-available', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },  

                }
            }, 
            event:{
                
                coupon: {
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('이벤트 쿠폰 등록', 'event-coupon', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('이벤트 쿠폰 수정', 'event-coupon/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    status: function (params, id, successThenFn, errorThenFn){ ajaxCall('이벤트 쿠폰 발급 상태 수정', 'event-coupon/'+id+'/status', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('이벤트 쿠폰 삭제', 'event-coupon/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'event-coupon/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'event-coupon', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },

                    history:{
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'event-coupon-history', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                }
            }, admin:{
                level:{
                    add: function (params, successThenFn, errorThenFn){ ajaxCall('관리자 정보 등록', 'admin/level', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    modify: function (params, id, successThenFn, errorThenFn){ ajaxCall('관리자 정보 수정', 'admin/level/'+id+'/modify', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    remove: function (params, id, successThenFn, errorThenFn){ ajaxCall('관리자 정보 삭제', 'admin/level/'+id+'/remove', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                    one: function (params, id, successThenFn, errorThenFn){ ajaxCall('', 'admin/level/'+id, 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'admin/level', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                }, history:{
                    action:{
                        add: function (params, successThenFn, errorThenFn){ ajaxCall('관리자 액션 히스토리 추가', 'admin/history/action', 'POST', 'application/json', params, successThenFn, errorThenFn, true); },
                        list: function (params, successThenFn, errorThenFn){ ajaxCall('', 'admin/history/action', 'GET', 'application/x-www-form-urlencoded', params, successThenFn, errorThenFn, true); },
                    }
                }
            }
            ,toCurrency: function(x){
                return '&#x20a9;'+x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            ,toNumber: function(x){
                return !x || isNaN(x) || x == null ? 0 : (x + '').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            , userPage: function(no){
                if(!no || no < 0) {
                    alert('존재하지 않는 사용자입니다.');
                    return false;
                }
                location.href = '/admin/members/'+no+'/infos';
            }
        };
        this.validation = {
        };        
        return this;
    }
    
    window.medibox = initCodeIdea() || [];
}());
