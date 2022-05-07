
@include('user.header2')

    <section id="schedule">

        <div class="date_select_wrap">
            <h4>날짜 선택</h4>
            <div id="datepicker" value=""></div>
        </div>
        
        <div class="time_select_wrap">
            <h4>시간 선택</h4>
            <div class="time_inner">
                <ul>
                    <li><a href="#!">12:00</a></li>
                    <li><a href="#!">12:30</a></li>
                    <li><a href="#!">13:00</a></li>
                    <li><a href="#!">13:30</a></li>
                    <li class="active"><a href="#!">14:00</a></li>
                    <li class="active"><a href="#!">14:30</a></li>
                    <li class="active"><a href="#!">15:00</a></li>
                    <li class="active"><a href="#!">15:30</a></li>
                    <li class="active"><a href="#!">16:00</a></li>
                    <li class="active"><a href="#!">16:30</a></li>
                    <li><a href="#!">17:00</a></li>
                    <li class="active"><a href="#!">17:30</a></li>
                    <li class="active"><a href="#!">18:00</a></li>
                </ul>
            </div>
        </div>

        <!-- 버튼 비활성화 -->
        <button type="button" id="next_btn" class="btn on" onclick="save()">다음</button>
        <!-- 버튼 활성화 -->
        <!-- <button type="button" id="next_btn" class="btn on">다음</button> -->

    </section>


    <div id="popup24" class="popup">
        <div class="container">
            <div class="top">
                <strong class="popup_icon popup_icon_check">check</strong>
                <span>예약변경이 완료되었습니다.</span>
                <span class="des">
                    현장결제시 추가 금액이<br>
                    발생할 수 있습니다.
                </span>
            </div>
            <div class="bottom">
                <a href="#" onclick="gotoList()">확인</a>
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
                <a href="#" onclick="gotoList()">네</a>
            </div>
        </div>
    </div>        

    <script>
    var searchDate;
    var searchTime;
    function cancel(){
        $('#popup25').addClass('on');
    }
    function gotoList(){
        location.href = '/reservation/history';
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
        return true;
    }
    function validation2(){
        if(!searchDate || searchDate == '') {
            return false;
        }
        if(!searchTime || searchTime == '') {
            return false;
        }
        return true;
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
    var data;
    function loadHistory(){
        var param = { user_seqno:{{ $seqno }}, id: {{$historyNo}} };

		medibox.methods.store.reservation.one(param, {{$historyNo}}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
            }
            data = response.data;
            searchDate = response.data.start_dt.split(' ')[0];
            searchTime = response.data.start_dt.split(' ')[1];
            $('#datepicker').val(searchDate);
            $("#datepicker").datepicker('setDate', searchDate);
            /*
            $('.cancelPrice').text(medibox.methods.toNumber(response.data.price)+'원');
            $('.cancelDt').text(toReservationDate(response.data.start_dt));
            $('.cancelShop').text(response.data.storeInfo.name);
            $('.cancelService').text((response.data.serviceInfo ? response.data.serviceInfo.name : '-'));
            $('.cancelDesigner').text('['+(response.data.managerInfo ? response.data.managerInfo.manager_type : '기본')+'] '
                                                    +(response.data.managerInfo ? response.data.managerInfo.name : '-'));
                                                    */
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    function save(){
        if(!validation()) {
            return false;
        }
		var point_type = 'P';
        var memo = '사용자 예약';
		
		medibox.methods.store.reservation.modify({
            status: data.status
            , use_icon_important: data.use_icon_important
            , use_icon_phone: data.use_icon_phone
            , use_custom_color: data.use_custom_color
            , custom_color: data.custom_color
            , estimated_time: data.estimated_time
            , start_dt: $('#datepicker').val() + ' ' + searchTime
            , memo: data.memo + '\n[온라인] 고객 예약 수정됨'
            , apply_on_mobile: data.apply_on_mobile
            , partner_seqno: data.partner_seqno
            , store_seqno: data.store_seqno
            , service_seqno: data.service_seqno
            , manager_seqno: data.manager_seqno
            , user_seqno: {{$seqno}}
            , admin_seqno: 0
//                , user_name: $('#user_name').val()
//                , user_phone: $('#user_phone').val()
        }, {{$historyNo}}, function(request, response){
            console.log('output : ' + response);
            if(!response.result){
                alert(response.ment);
                return false;
            }
            $('#popup24').addClass('on');
        }, function(e){
            console.log(e);
            alert('서버 통신 에러');
        });
    }
    $(document).ready(function(){
        loadHistory();
    });
    </script>

    @include('user.footer')

</body>