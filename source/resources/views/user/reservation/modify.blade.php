
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
                    <li class="active"><a href="#!" onclick="saveSearchDate('14:00', this)">14:00</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('14:30', this)">14:30</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('15:00', this)">15:00</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('15:30', this)">15:30</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('16:00', this)">16:00</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('16:30', this)">16:30</a></li>
                    <li><a href="#!">17:00</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('17:30', this)">17:30</a></li>
                    <li class="active"><a href="#!" onclick="saveSearchDate('18:00', this)">18:00</a></li>
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
    var stores = [];
    var targetStoreSeqno = 0;
	function disableAllTheseDays(date) {
		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		var toDay = new Date();
        toDay.setHours(0); toDay.setMinutes(0); toDay.setMilliseconds(0); toDay.setSeconds(0);
		if(date.getTime() < toDay.getTime()){
			return [false];
		}

		var targetStore = stores.filter(store => store.seqno == targetStoreSeqno);
		if(targetStore.length != 1) {
			return [true];
		}
		targetStore = targetStore[0];
		// due_day 에 있는 요일인가?
		if(targetStore.due_day && targetStore.due_day.indexOf(date.getDay()) < 0) {
			return [false];
		}
		// 특수 휴무 사용할 경우 
		if(targetStore.allow_ext_holiday) {
			// 특수 요일 휴무일에 예약하는 경우
			if(targetStore.ext_holiday_weekly && targetStore.ext_holiday_weekly == date.getDay()) {
				return [false];
			}
			// 특수 주차 요일 휴무일에 예약하는 경우 
			if(targetStore.ext_holiday_weekend_day) {
				var holidayInfo = targetStore.ext_holiday_weekend_day.split('-');

				if(holidayInfo[0] && holidayInfo[0] == getWeek(date)
					&& holidayInfo[1] && holidayInfo[1] == date.getDay()) {
					return [false];
				}
			}
			// 지정일 휴무일에 예약하는 경우
			if(targetStore.ext_holiday_montly) {
				var holidays = targetStore.ext_holiday_montly.split(',');
				if(holidays.length > 0 && holidays.includes(date.getDate()+'')) {
					return [false];
				}
			}
		}
		return [true];
    }
    function cancel(){
        $('#popup25').addClass('on');
    }
    function gotoList(){
        location.href = '/reservation-history';
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
            stores[0] = response.data.storeInfo;
            $('#datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                prevText: '이전 달',
                nextText: '다음 달',
                monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                showMonthAfterYear: true,
                yearSuffix: '년',
                beforeShowDay: disableAllTheseDays
            });
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

<style>
    .time_select_wrap .time_inner>ul>li.active>a:focus {background:none;color:black;}
    .time_select_wrap .time_inner>ul>li.active.on {background:black;color:white;}
    .time_select_wrap .time_inner>ul>li.active.on>a {color:white;}
</style>

    @include('user.footer')

</body>