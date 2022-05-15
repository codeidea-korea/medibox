
@include('user.header2')
    
        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="history.back();">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                    <g id="back_arrow" transform="translate(-22.295 -60)">
                      <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)" fill="none"/>
                      <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                        <g id="그룹_388" data-name="그룹 388">
                          <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none" stroke="#1d1d1b" stroke-miterlimit="10" stroke-width="1"/>
                          <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331" transform="translate(-3352 -1077.894)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                          <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331" transform="translate(-3352 -1071.563)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                        </g>
                      </g>
                    </g>
                  </svg>
            </button>
            <!-- page title -->
            <div class="title">
                <span>이벤트</span>
            </div>
        </header>

        <!-- 이벤트 -->
        <section id="event">
            <div class="event_wrap">
                <a href="/profile/events/1">
                    <figure>
                        <img src="/user/img/img_event_banner01.jpg" alt="미니쉬 치과 리얼 모델 모집 이벤트 연장">
                    </figure>
                    <h3>미니쉬 치과 리얼 모델 모집 이벤트 연장</h3>
                    <p>이벤트기간 : 11.01 ~ 11.27</p>
                </a>
            </div>
            <div class="event_wrap">
                <a href="/profile/events/2">
                    <figure>
                        <img src="/user/img/img_event_banner02.jpg" alt="미니쉬 치과 리얼 모델 모집 이벤트 연장">
                    </figure>
                    <h3>미니쉬 치과 리얼 모델 모집 이벤트 연장</h3>
                    <p>이벤트기간 : 11.01 ~ 11.27</p>
                </a>
            </div>
            <div class="event_wrap">
                <a href="/profile/events/3">
                    <figure>
                        <img src="/user/img/img_event_banner03.jpg" alt="미니쉬 치과 리얼 모델 모집 이벤트 연장">
                    </figure>
                    <h3>미니쉬 치과 리얼 모델 모집 이벤트 연장</h3>
                    <p>이벤트기간 : 11.01 ~ 11.27</p>
                </a>
            </div>
        </section>

        @include('user.footer')

        <script>
            var pageNo = 1;
            var pageSize = 20;
            var blocked = false;
            var firstH = $('#event > .event_wrap')[0].clientHeight * 9;
            var eachH = $('#event > .event_wrap')[0].clientHeight * 20;
            
            function toDateFormatt(){
                var thisDay = new Date();
                return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
            }
            function gotoDetail(seq){
                location.href = '/profile/faqs/' + seq;
            }
            function getList(){                
                var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:0, lend_dt:toDateFormatt()  };

                medibox.methods.event.coupon.list(data, function(request, response){
                    console.log('output : ' + response);
                    if(!response.result){
                        alert(response.ment);
                        return false;
                    }
//                    $('#totalCnt').text( medibox.methods.toNumber(response.count) );

                    if(pageNo == 1) $('#event').html('');
                    if(response.count == 0){
                        $('#event').html(
                            '<figure class="empty_reservation">'
                            +'    <img src="/user/img/icon_empty_reservation.png" alt="자주 묻는 질문이 없습니다.">'
                            +'    <p>자주 묻는 질문이 없습니다.</p>'
                            +'</figure>');
                        return;
                    }

                    var bodyData = '';
                    for(var inx=0; inx<response.data.length; inx++){
                        var no = (response.count - (request.pageNo - 1)*pageSize) - inx;
                        
                        bodyData = bodyData 
                                +'<div class="event_wrap">'
                                +'    <a href="/profile/events/'+response.data[inx].seqno+'">'
                                +'        <figure>'
                                +'            <img src="'+response.data[inx].thumbnail+'" alt="'+response.data[inx].name+'">'
                                +'        </figure>'
                                +'        <h3>'+response.data[inx].name+'</h3>'
                                +'        <p>이벤트기간 : '+response.data[inx].start_dt.substring(0, 10) + ' ~ ' + response.data[inx].end_dt.substring(0, 10)+'</p>'
                                +'    </a>'
                                +'</div>';
                    }
                    $('#event').html($('#event').html()+bodyData);
                    blocked = false;
                }, function(e){
                    console.log(e);
                    blocked = false;
                    alert('서버 통신 에러');
                });
            }
            $(document).ready(function(){
                getList();

                $(window).scroll(function () {
                    var height = $(document).scrollTop();
//                    console.log(height);
                    if((firstH + (eachH*(pageNo-1))) - 100 < height && !blocked){
                        pageNo = pageNo + 1;
                        blocked = true;
                        getList();
                    }
                }); 
            });
        </script>
</body>
</html>