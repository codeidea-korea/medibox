
@include('user.header2')
    
    <!-- header -->
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                <g id="back_arrow" transform="translate(-22.295 -60)">
                    <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)"
                        fill="none" />
                    <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                        <g id="그룹_388" data-name="그룹 388">
                            <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none"
                                stroke="#1d1d1b" stroke-miterlimit="10" stroke-width="1" />
                            <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331"
                                transform="translate(-3352 -1077.894)" fill="none" stroke="#000" stroke-linecap="square"
                                stroke-width="1" />
                            <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331"
                                transform="translate(-3352 -1071.563)" fill="none" stroke="#000" stroke-linecap="square"
                                stroke-width="1" />
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
    <!-- 이벤트 상세 페이지-->
    <section id="event_detail">
        <div class="container">
            <span class="img">
                <img src="{{ $event_coupon->img }}">
            </span>
            <h3 id="title">{{$event_coupon->name}}</h3>
            <span id="createDt">이벤트기간 : {{$event_coupon->start_dt}} ~ {{$event_coupon->end_dt}}</span>
            <p id="contents">
            @php
                echo $event_coupon->context;
            @endphp
            </p>
            
            @php
            // used_coupon 와 관계없이 사용자가 신청이 가능할 수 있음
                echo '<button onclick="joinEvent()">이벤트 신청</button>';
            @endphp
            
        </div>
    </section>  

    <script>
            var userNo = '{{$userSeqno}}';
            
            function toDateFormatt(){
                var thisDay = new Date();
                return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
            }
            @php
            if(!empty($userSeqno) && $userSeqno > 0) {
                @endphp
                    function joinEvent(){                
                        var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:0, user_seqno: userNo };

                        medibox.methods.event.coupon.jon(data, {{$id}}, function(request, response){
                            console.log('output : ' + response);
                            if(!response.result){
                                alert(response.ment);
                                return false;
                            }
                            alert('이벤트 신청이 되었습니다.');
                            location.href= '/profile/events';
                        }, function(e){
                            console.log(e);
                            blocked = false;
                            alert('서버 통신 에러');
                        });
                    }
                @php
            } else {
                @endphp
                function joinEvent(){
                    alert('로그인을 먼저 해주세요.');
                }
                @php
            }
            @endphp
        </script>
        @include('user.footer')
</body>
</html>