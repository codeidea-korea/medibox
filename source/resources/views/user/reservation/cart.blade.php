
@include('user.header2')

    <section id="res_detail" class="depth01 nail">
        <div class="top">
            <div class="container">
                <div class="pic"></div>
                <div class="des">
                    <h3>바라는 네일</h3>
                    <address>서울시 강남구 도산대로49길9 2층<br>바라는네일 in 미니쉬라운지 청담</address>
                </div>
            </div>
        </div>
        <div class="date_open_wrap">
            <div class="container">
                <a href="#!" class="date_open_btn">
                    <span>날짜/시간 선택</span>
                </a>
            </div>
        </div>
        <div class="bottom">
            <div class="service_inner menu_inner">
                <h3>서비스(<span class="itm_num"></span>)</h3>

<!--
                <div class="menu">
                    <h4>베이직 케어</h4>
                    <ul>
                        <li><a href="#">
                            <span class="program">손기본케어 (60분)</span>
                            <span class="price">여 36,300원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">손기본케어 (60분)</span>
                            <span class="price">남 48,400원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">손교정케어 (60분)</span>
                            <span class="price">72,600원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">발기본케어 (60분)</span>
                            <span class="price">여 60,500원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">발기본케어 (60분)</span>
                            <span class="price">남 72,600원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">발교정케어 (90분)</span>
                            <span class="price">121,000원</span>
                        </a></li>
                    </ul>
                </div>

                <div class="menu">
                    <h4>젤</h4>
                    <ul>
                        <li><a href="#">
                            <span class="program">젤네일아트[베이직] (90분)</span>
                            <span class="price">96,800원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">젤패디아트[베이직] (90분)</span>
                            <span class="price">121,000원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">젤제거 (30분)</span>
                            <span class="price">36,300원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">젤아트[네일&패디] (120분)</span>
                            <span class="price">121,000원</span>
                        </a></li>
                    </ul>
                </div>

                <div class="menu">
                    <h4>각질관리 (베이직케어 제외)</h4>
                    <ul>
                        <li><a href="#">
                            <span class="program">각질1단계 (30분)</span>
                            <span class="price">96,800원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">각질2단계 (40분)</span>
                            <span class="price">133,100원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">각질3단계 (50분)</span>
                            <span class="price">169,400원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">각질4단계 (60분)</span>
                            <span class="price">217,800원</span>
                        </a></li>
                    </ul>
                </div>

                <div class="menu">
                    <h4>문제성 특수관리</h4>
                    <ul>
                        <li><a href="#">
                            <span class="program">
                                물어뜯는손톱 (120분)<br>
                                [베이직교정케어포함]
                            </span>
                            <span class="price">193,600원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">
                                파고드는발톱 (100분)<br>
                                [베이직교정패디큐어포함]
                            </span>
                            <span class="price">1회 181,500원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">
                                파고드는발톱 (100분)<br>
                                [베이직교정패디큐어포함]
                            </span>
                            <span class="price">2회 242,000원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">
                                파고드는발톱 (120분)<br>
                                [베이직교정패디큐어포함]
                            </span>
                            <span class="price">1회 240,900원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">
                                파고드는발톱 (120분)<br>
                                [베이직교정패디큐어포함]
                            </span>
                            <span class="price">2회 350,900원</span>
                        </a></li>
                    </ul>
                </div>

                <div class="menu">
                    <h4>멤버십 서비스</h4>
                    <ul>
                        <li><a href="#">
                            <span class="program">
                                베이직케어 (90분)
                            </span>
                            <span class="price">100,000원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">
                                베이직케어 (120분)<br>
                                [네일+패디+각질]
                            </span>
                            <span class="price">250,000원</span>
                        </a></li>
                        <li><a href="#">
                            <span class="program">베이직젤네일+젤패디 (180분)</span>
                            <span class="price">250,000원</span>
                        </a></li>
                    </ul>
                </div>                    
-->
            </div>
        </div>


        <!-- 버튼 비활성화 -->
        <button type="button" id="next_btn" class="btn">다음</button>
        <!-- 버튼 활성화 -->
        <!-- <button type="submit" id="next_btn" class="btn on">다음</button> -->

    </section>

    <!-- 날짜 선택 모달창 -->
    <div class="modal_wrap date">
        <div class="modal_inner">
            <div class="top_bar_wrap">
                <div class="top_bar"></div>
            </div>

            <div class="date_select_wrap">
                <h4>날짜 선택</h4>
                <div id="datepicker"></div>
            </div>
            
            <div class="time_select_wrap">
                <h4>시간 선택</h4>
                <div class="time_inner">
                    <ul>
                        <li><a href="#!">12:00</a></li>
                        <li><a href="#!">12:30</a></li>
                        <li><a href="#!">13:00</a></li>
                        <li><a href="#!">13:30</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('14:00', this)">14:00</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('14:30', this)">14:30</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('15:00', this)">15:00</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('15:30', this)">15:30</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('16:30', this)">16:00</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('17:00', this)">16:30</a></li>
                        <li><a href="#!">17:00</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('17:30', this)">17:30</a></li>
                        <li class="active"><a href="#!" onclick="saveSearchDate('18:00', this)">18:00</a></li>
                    </ul>
                </div>
            </div>

            <div class="bottom">
                <a href="#!" class="close_btn">취소</a>
                <a href="#!" class="close_btn">적용</a>
            </div>
        </div>
    </div>   

    <div id="popup25" class="popup reservation select">
        <div class="container">
            <div class="top">
                <span>예약변경취소</span>
                <span class="des">
                    예약 변경시 수정된 사항이 저장되지 않습니다.<br>
                    그래도 뒤로 돌아가시겠습니까?
                </span>
            </div>
            <div class="bottom">
                <a href="#" class="close_btn">아니오</a>
                <a href="#" onclick="history.back();">네</a>
            </div>
        </div>
    </div>      

    <script>
    var searchDate = '';
    var searchTime = '';
    var targetServiceId = '';
    function openCalendar(){
        // 일자/시간 선택전에 데이터를 세팅한다.
    }
    function saveSearchDate(time, target){
        searchDate = $('#datepicker').val();
        searchTime = time;
        $(target).parent().parent().find('li').removeClass('on');
        $(target).parent().addClass('on');
        if(validation2()) {
            $('#next_btn').addClass('on');
        }
    }
    function saveServiceId(id){
        targetServiceId = id;
        if(validation2()) {
            $('#next_btn').addClass('on');
        }
    }
    function cancel(){
        $('#popup25').addClass('on');
    }
    function validation(){
        if(!searchDate || searchDate == '') {
            alert('예약하실 날짜를 선택해주세요.');
            return false;
        }
        if(!searchTime || searchTime == '') {
            alert('예약하실 시간을 선택해주세요.');
            return false;
        }
        if(!targetServiceId || targetServiceId == '') {
            alert('예약하실 서비스를 선택해주세요.');
            return false;
        }
        return true;
    }
    function validation2(){
        if(!searchDate || searchDate == '') {
            return false;
        }
        if(!searchTime || searchTime == '') {
            return false;
        }
        if(!targetServiceId || targetServiceId == '') {
            return false;
        }
        return true;
    }
    function gotoNext(){
        if(!validation()) {
            return false;
        }
        location.href = '/brands/{{$brandNo}}/shops/{{$shopNo}}/reservation/payment?date='+searchDate+'&time='+searchTime+'&serviceId='+targetServiceId;
    }
    function convertTimeFormat(format){
        return format;
    }
    function loadTimes(){
        // 
    }
    function loadServices(){
        medibox.methods.store.serviceAll({
            partner_seqno: {{$brandNo}},
            store_seqno: {{$shopNo}}
        }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('.itm_num').text( medibox.methods.toNumber(response.count) );

			if(!response.data || response.data.length == 0 || response.count == 0){
                alert('해당 매장에는 현재 온라인 예약 가능한 서비스가 없습니다.');
                history.back();
				return;
			}
            var bodyData = '';
            var prevDeptName = '';
			for(var inx=0; inx<response.data.length; inx++){
                if(prevDeptName != response.data[inx].dept) {
                    bodyData = bodyData 
                        + '<div class="menu">'
                        + '    <h4>'+response.data[inx].dept+'</h4>'
                        + '    <ul>';
                    prevDeptName = response.data[inx].dept;
                }

                bodyData = bodyData 
                        + '<li>'
                        + '    <a href="#" onclick="saveServiceId('+response.data[inx].seqno+')">'
                        + '        <span class="program">'+response.data[inx].name+' ('+convertTimeFormat(response.data[inx].estimated_time)+')</span>'
                        + '        <span class="price">'+medibox.methods.toNumber(response.data[inx].price)+'원</span>'
                        + '    </a>'
                        + '</li>';

                if(inx + 1 >= response.data.length || prevDeptName != response.data[inx + 1].dept) {
                    bodyData = bodyData + '</ul></div>';
                }
			}
			$('.service_inner').html($('.service_inner').html() + bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    $(document).ready(function(){
        loadServices();
    });
    </script>

    @include('user.footer')

</body>