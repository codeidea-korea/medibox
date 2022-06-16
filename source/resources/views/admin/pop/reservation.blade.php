
<div class="layer-popup" id="popReservation">
	<button class="pop-closer" onclick="popHide()"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header">
				예약 등록
			</header>
			<div class="wr-wrap line label130 padding10">
				<div class="wr-list" style="width:50%;float:left;">
					<div class="wr-list-label ">
						<select class="default">
							<option data-subtext="">전화번호/이름</option>
						</select>
					</div>
					<div class="wr-list-con">			
						<input type="text" name="searchUserId" value="" required class="span" style="width:160px;">		
						<a href="#" onclick="getUserList()" class="btn large blue span100">조회</a>
						<a href="/admin/members/0" class="btn large blue span100">고객등록</a>
					</div>
					
					<div style="width:100%;clear:both;height:5px;"></div>
	
					<form name="fboardlist" action="" method="post">
					<div class="tbl-basic cell td-h1">
						<!-- <div class="tbl-header">
							<div class="caption">총 000건</div>
						</div> -->
						<table id="resident_list">
							<colgroup>
								<col width="60">
								<col>
								<col width="180">
								<col width="180">
							</colgroup>
							<thead>
								<tr>
									<th>이름</th>
									<th>고객번호</th>
									<th>휴대폰</th>
									<th>정보</th>
								</tr>
							</thead>
							<tbody id="_reservationTargetUsers">
								<!--
								<tr>
									<td>김메디</td>
									<td>1234565213</td>
									<td>010-1123-4123</td>
									<td><a href="#" class="btn large blue span100">고객정보</a></td>
								</tr>
								<tr>
-->
							</tbody>
						</table>
						
						<nav class="pg_wrap">
							<a href="#" class="pg_btn first"></a>
							<a href="#" class="pg_btn prev"></a>
							<a href="#" class="pg_btn active">1</a>
							<a href="#" class="pg_btn">2</a>
							<a href="#" class="pg_btn">3</a>
							<a href="#" class="pg_btn">4</a>
							<a href="#" class="pg_btn">5</a>
							<a href="#" class="pg_btn next"></a>
							<a href="#" class="pg_btn last"></a>
						</nav>
					</div>
					</form>	
				</div>		
				<div class="wr-list" style="width:50%;float:left;">	
						<form name="fboardlist" action="" method="post">
						<div class="tbl-basic cell td-h1">
							<table id="resident_list">
								<colgroup>
									<col width="120">
									<col width="120">
									<col width="120">
									<col width="120">
								</colgroup>
								<tbody>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">아이콘표시</td>
										<td  style="border:1px solid #000;" colspan="3">
											<label class="checkbox-wrap"><input type="checkbox" id="use_icon_important" name="use_icon_important" value="" checked  /><span></span>중요고객★</label>
											<label class="checkbox-wrap"><input type="checkbox" id="use_icon_phone" name="use_icon_phone" value=""  /><span></span>전화☏</label>
											<label class="checkbox-wrap"><input type="checkbox" id="use_custom_color" name="use_custom_color" value=""  /><span></span>색상선택</label>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">제휴사</td>
										<td  style="border:1px solid #000;">
											<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
												<option data-subtext="">제휴사</option>
												<option value="퇴사">제휴사A</option>
											</select>
										</td>
										<td  style="border:1px solid #000;">매장</td>
										<td  style="border:1px solid #000;">
											<select  class="default" id="storePop" onchange="getManagersPop()">
												<option data-subtext="" value="">제휴사를 먼저 선택해주세요.</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">디자이너</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="managerPop" onchange="getServicesPop(this.text)">
												<option data-subtext="" value="">매장을 먼저 선택해주세요.</option>
											</select>
										</td>
									</tr>
									
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약일시</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<label class="inp-wrap left-label"><span class="label">날짜</span><input type="text" id="startDate" name="" value="" class="span130"></label>
											<select class="default" id="startTime1" onchange="toggleHour(this)">
											<!--
												<option data-subtext="">12시</option>
												<option data-subtext="">12시</option>
												-->
											</select>
											<select class="default" id="startTime2">
											<!--
												<option data-subtext="">30분</option>
												<option data-subtext="">30분</option>
												-->
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약항목</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="servicePop">
											<!--
												<option data-subtext="">컷</option>
												<option>컷</option>
												-->
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">소요시간</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="estimated_time">
											<!--
												<option data-subtext="">1시간 50분</option>
												<option>1시간 50분</option>
												-->
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약메모</td>
										<td  style="border:1px solid #000;" colspan="3">
											<textarea id="memo" name="" class="mini autoSize" placeholder="메모"></textarea>
										</td>
									</tr>
									<tr style="border:1px solid #000;" id="status_select">
										<td  style="border:1px solid #000;">예약 상태</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="res_status">
												<option value="R">예약 완료</option>
												<option value="N">예약 불이행</option>
												<option value="E">고객 입장</option>
												<option value="D">서비스 완료</option>
												<option value="C">예약 취소</option>
											</select>
										</td>
									</tr>
								</tbody>
								</table> 
						</div>
						</form>
				</div>
			</div>	
			<div class="btnSet">
				<a href="#" id="_add" class="btn large blue span120" onclick="add()">저장</a>
				<a href="#" id="_modify" class="btn large blue span120" onclick="modify()">수정</a>
				<a href="#" class="btn large gray popClose" onclick="popHide()">취소</a>
			</div>
		</div>
	</div>

	<div class="pop-bg"></div>
</div>

<script>
	var upageNo = 1;
	var upageSize = 10;

	function loadUserList(no) {
		upageNo = no;
		getUserList();
	}

	function getUserList(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchUserId]').val();
		
		var data = { pageNo: upageNo, pageSize: upageSize, adminSeqno:{{ $seqno }} };

		if(startDay && startDay != '') {
			data.start_day = startDay.replace('.', '-').replace('.', '-');
		}
		if(endDay && endDay != '') {
			data.end_day = endDay.replace('.', '-').replace('.', '-');
		}
		if(searchField && searchField != '') {
			data.search = searchField;
		}

		medibox.methods.user.members(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			if(response.count == 0){
				$('#_reservationTargetUsers').html('<tr>'
									+'    <td colspan="4" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				$('.pg_wrap').html('<nav class="pg_wrap">'
									+'    <a href="#" class="pg_btn first"></a>'
									+'    <a href="#" class="pg_btn prev"></a>'
									+'    <a href="#" class="pg_btn active">1</a>'
									+'    <a href="#" class="pg_btn next"></a>'
									+'    <a href="#" class="pg_btn last"></a>'
									+'</nav>');
				return;
			}

			var bodyData = '';
			userInfos = [];
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
							+'<tr data-key="'+response.data[inx].user_seqno+'" onclick="chooseUser('+response.data[inx].user_seqno+')" style="cursor:pointer;">'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>MEDIBOX-'+response.data[inx].user_seqno+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td><a href="#" class="btn large blue span100" onclick="gotoInfoDetail(\''+response.data[inx].user_seqno+'\')">고객정보</a></td>'
							+'</tr>';
				array_push(userInfos, response.data[inx]);
			}
			if(response.count > 0)
			{
				var totSize = response.count;
				var totPagePt = Math.ceil(totSize / pageSize);
				var pageStt = (Math.ceil(request.pageNo/5)-1)*5 +1;
				var pageEnd = Math.ceil(request.pageNo/5)*5;
				pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
				var eventName = 'onclick'; var pageTmp = '';
				
				pageTmp+= '<nav class="pg_wrap">'
						+'    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadUserList(1)"' : '')+'></a>'
						+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadUserList('+(pageStt-1)+')"' : '')+'></a>';
				for(var inx=pageStt; inx <= pageEnd; inx++)
				{
					pageTmp+='<a href="#" class="pg_btn '+(inx == request.pageNo ? 'active' : '')+'" '+eventName+'="loadUserList('+(inx)+')">'+(inx)+'</a>';
				}
				pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadUserList('+(pageEnd+1)+')"' : '')+'></a>'
						+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadUserList('+(totPagePt)+')"' : '')+'></a>'
						+'</nav>';

				$('.pg_wrap').html(pageTmp);
			}

			$('#_reservationTargetUsers').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function getStoresPop(partner_seqno){
		var data = { partner_seqno:partner_seqno, adminSeqno:{{ $seqno }} };

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" onclick="getManagersPop('+response.data[inx].seqno+')">'+response.data[inx].name+'</option>';
			}
			$('#storePop').html(bodyData);
			/*
			stores = response.data;
			if(stores.length) {
				stores.managerInfo = stores.map(store => store.managerInfo).filter(manageInfo => manageInfo != null);
			}
			makeManagers();
			*/
			getServicesPop();
			getManagersPop();
//			dueDay();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var targetStoreSeqno = 0;
	var prevtargetStoreSeqno = 0;
	function getWeek(date) {
		var currentDate = date;
		var copyDate = date;
		var startOfMonth = new Date(copyDate.setDate(1));
		var weekDay = startOfMonth.getDay();
		return parseInt(((weekDay - 1) + currentDate) / 7) + 1;
	}
	function disableAllTheseDays(date) {
		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		var toDay = new Date();
        toDay.setHours(0); toDay.setMinutes(0); toDay.setMilliseconds(0); toDay.setSeconds(0);
		if(date.getTime() < toDay.getTime()){
			return false;
		}

		var targetStore = stores.filter(store => store.seqno == targetStoreSeqno);
		if(targetStore.length != 1) {
			return true;
		}
		targetStore = targetStore[0];
		// due_day 에 있는 요일인가?
		if(targetStore.due_day && targetStore.due_day.indexOf(date.getDay()) < 0) {
			return false;
		}
		// 특수 휴무 사용할 경우 
		if(targetStore.allow_ext_holiday) {
			// 특수 요일 휴무일에 예약하는 경우
			if(targetStore.ext_holiday_weekly && targetStore.ext_holiday_weekly == date.getDay()) {
				return false;
			}
			// 특수 주차 요일 휴무일에 예약하는 경우 
			if(targetStore.ext_holiday_weekend_day) {
				var holidayInfo = targetStore.ext_holiday_weekend_day.split('-');

				if(holidayInfo[0] && holidayInfo[0] == getWeek(date)
					&& holidayInfo[1] && holidayInfo[1] == date.getDay()) {
					return false;
				}
			}
			// 지정일 휴무일에 예약하는 경우
			if(targetStore.ext_holiday_montly) {
				var holidays = targetStore.ext_holiday_montly.split(',');
				if(holidays.length > 0 && holidays.includes(date.getDate()+'')) {
					return false;
				}
			}
		}
		return true;
	}
	function isDueTime(targetTime){
		var targetStore = stores.filter(store => store.seqno == targetStoreSeqno);
		if(targetStore.length != 1) {
			return true;
		}
		targetStore = targetStore[0];
		if(targetStore.start_dt && targetStore.start_dt <= targetTime
			&& targetStore.end_dt && targetStore.end_dt >= targetTime) {
				return true;
		}
		return false;
	}
	function disableAllTheseTimes(targetTime){
		var targetStore = stores.filter(store => store.seqno == targetStoreSeqno);
		if(targetStore.length != 1) {
			return true;
		}
		targetStore = targetStore[0];

		if(targetStore.allow_lunch_reservate == 'N') {
			if(targetStore.lunch_start_dt && targetStore.lunch_start_dt <= targetTime
				&& targetStore.lunch_end_dt && targetStore.lunch_end_dt > targetTime) {
					return false;
			}
		}
		return true;
	}
	function setDueTime(store_seqno){
		var targetStore = stores.filter(store => store.seqno == store_seqno);
		if(targetStore.length != 1) {
			return false;
		}
		var hours = '<option value="">선택해주세요.</option>';
		var times = '<option value="">선택해주세요.</option>';

		if(!stores.conf) {
			return false;
		}
		var minTime = stores.conf.dueDay.startTime;
		var maxTime = stores.conf.dueDay.endTime;
		targetStore = targetStore[0];

//		if(targetStore.start_dt && targetStore.start_dt != '' && targetStore.start_dt < minTime) {
			minTime = targetStore.start_dt;
//		}
//		if(targetStore.end_dt && targetStore.end_dt != '' && targetStore.end_dt > maxTime) {
			maxTime = targetStore.end_dt;
//		}
		targetStoreSeqno = store_seqno;
		
		$('#startDate').each(function() {
			$(this).datepicker({
				language: 'ko-KR',
				autoPick: true,
				autoHide: true,
				format: 'yyyy-mm-dd',
				minDate: 0,
				isHolyday: disableAllTheseDays
			}).on('change', function(e) {
				// filter
			});
		});
		var targetTime = minTime;
		var prevHour = 0;
		var minArr = [];
		while(targetTime <= maxTime){
			var timeinfos = targetTime.split(':');
			var isDueTime = true;
			timeinfos[0] = Number(timeinfos[0]);
			timeinfos[1] = Number(timeinfos[1]);
            
            // 점심 시간을 사용하는 매장의 경우
            if(targetStore.allow_lunch_reservate == 'Y') {
                if(targetStore.lunch_start_dt && targetStore.lunch_start_dt <= targetTime
                    && targetStore.lunch_end_dt && targetStore.lunch_end_dt > targetTime) {
                        isDueTime = false;
                }
            }

			// 점심시간을 제외하고 넣기
			if(isDueTime) {
				if(prevHour != timeinfos[0]) {
					prevHour = timeinfos[0];
					hours = hours + '<option value="'+(timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0])+'">'+(timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0])+'시</option>';
				}
				times = times + '<option data-hour="'+(timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0])+'" value="'+(timeinfos[1] < 10 ? '00' : timeinfos[1])+'">'+(timeinfos[1] < 10 ? '0' : timeinfos[1])+'분</option>';
			}

			timeinfos[1] = Number(timeinfos[1]) + 10;
			if(timeinfos[1] >= 60) {
				timeinfos[0] = Number(timeinfos[0]) + 1;
				timeinfos[1] = '00';
			}
			targetTime = (timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0]) + ':' + (timeinfos[1] < 10 ? '00' : timeinfos[1]);
		}
		// 업무 시간에 예약을 하는 것인가 start_dt end_dt
		// 점심 시간을 사용하는 매장의 경우 allow_lunch_reservate lunch_start_dt lunch_end_dt
		$('#startTime1').html(hours);
		$('#startTime2').html(times);

		toggleHour(0);
	}
	function toggleHour(target) {
		var hour = $(target).val();
		$('#startTime2 > option').hide();
		$('#startTime2 > option[data-hour='+hour+']').show();
	}

	function getManagersPop(){
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();

		if(partner && partner != '') {
			data.partner_seqno = partner;
		}
		if(store && store != '') {
			data.store_seqno = store;
		}
		setDueTime(store);

		medibox.methods.store.manager.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			var bodyData = '<option value="0">기본 (특정 담당 직원/직위 지정 없음)</option>';
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].manager_type + ' ' +response.data[inx].name +'</option>';
			}
			$('#managerPop').html(bodyData);
			getServicesPop();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var userInfos;
	var user_name; var user_phone;
	function chooseUser(seq){
		user_seqno = seq;
		$('#_reservationTargetUsers > tr > td').attr('style', '');
		$('#_reservationTargetUsers > tr[data-key='+seq+'] > td').attr('style', 'background:green;color:#fff;');
		var userInfo = userInfos.filter(user => user.user_seqno == seq);
		userInfo = userInfo[0];
		user_name = userInfo.user_name;
		user_phone = userInfo.user_phone;
	}
	function getServicesPop(manager_type){
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();

		if(partner && partner != '') {
			data.partner_seqno = partner;
		}
		if(store && store != '') {
			data.store_seqno = store;
		}
		if(manager_type && manager_type != '') {
			data.manager_type = manager_type.split(' ')[0];
		}
		
		medibox.methods.store.manager.services.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			if(!response.data || response.data.length == 0) {
				return;
			}
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seqno+'">['+response.data[inx].dept + '] ' +response.data[inx].name +'</option>';
			}
			$('#servicePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var user_seqno;
	var prevDataId;
	function add(){
		if(!checkValidation()) {
			return;
		}
		if(!user_seqno || user_seqno == '') {
			alert('예약할 고객을 선택해주세요.');
			return false;
		}
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').is(":checked") ? 'Y' : 'N';
		var use_icon_phone = $('#use_icon_phone').is(":checked") ? 'Y' : 'N';
		var use_custom_color = $('#use_custom_color').is(":checked") ? 'Y' : 'N';
		var estimated_time = $('#estimated_time').val(); 
		var start_dt = ($('#startDate').val()).replaceAll('.', '-') + ' ' + $('#startTime1').val() + ':' + $('#startTime2').val();
		var memo = $('#memo').val(); 
		var apply_on_mobile = 'N';

		var point_type = 'P';
		var memo = '관리자 예약';
		
		var data = { admin_seqno:1, user_seqno:user_seqno, service_seqno: service_seqno,
            point_type:point_type, memo:memo, admin_name: '' };
            
		medibox.methods.store.reservation.check({
            estimated_time: estimated_time
            , partner_seqno: partner
            , store_seqno: store
            , start_dt: start_dt
            , service_seqno: service_seqno
            , manager_seqno: manager
            , user_seqno: user_seqno
            , id: 0
        }, function(request5, response5){
            console.log('output : ' + response5);
            if(!response5.result){
				alert(response5.ment.replace('\\r', '\n'));
                return false;
			}
			
			medibox.methods.point.use(data, function(request1, response1){
				console.log('output : ' + response1);
				if(!response1.result){
					alert(response1.ment.replace('\\r', '\n'));
					return false;
				}
				medibox.methods.store.reservation.add({
					status: 'R'
					, use_icon_important: use_icon_important
					, use_icon_phone: use_icon_phone
					, use_custom_color: use_custom_color
					
					, custom_color: '#000000'
					, estimated_time: estimated_time
					, start_dt: start_dt
					, memo: memo
					, apply_on_mobile: apply_on_mobile

					, partner_seqno: partner
					, store_seqno: store
					, manager_seqno: manager
					, service_seqno: service_seqno
					, user_seqno: user_seqno
					, admin_seqno: {{ $seqno }}
					, user_name: user_name
					, user_phone: user_phone
				}, function(request, response){
					console.log('output : ' + response);
					if(!response.result){
						alert(response.ment);
						return false;
					}
					alert('추가 되었습니다.');
		//			cancel();
					location.reload();
				}, function(e){
					console.log(e);
				});
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});
        }, function(e){
            console.log(e);
            alert('서버 통신 에러');
		});		
		
	}

	function modify(){
		if(!checkValidation()) {
			return;
		}
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').is(":checked") ? 'Y' : 'N';
		var use_icon_phone = $('#use_icon_phone').is(":checked") ? 'Y' : 'N';
		var use_custom_color = $('#use_custom_color').is(":checked") ? 'Y' : 'N';
		var estimated_time = $('#estimated_time').val(); 
		var start_dt = ($('#startDate').val()).replaceAll('.', '-') + ' ' + $('#startTime1').val() + ':' + $('#startTime2').val();
		var memox = $('#memo').val(); 
		var apply_on_mobile = 'N';
		var res_status = $('#res_status').val(); 

		var point_type = 'P';
        var price = reservation_old_price;
		var memo = '관리자 예약 수정으로 인한 사용 포인트 반환 (예약번호: ['+reservationseqno+'])';
		var data = { admin_seqno:1, user_seqno:user_seqno, product_seqno: 0, reIssueCoupon: reIssueCoupon,
            point_type:point_type, memo:memo, amount: price, admin_name: '' };
        
		medibox.methods.store.reservation.check({
            estimated_time: estimated_time
            , partner_seqno: partner
            , store_seqno: store
            , start_dt: start_dt
            , service_seqno: service_seqno
            , manager_seqno: manager
            , user_seqno: user_seqno
            , id: reservationseqno
        }, function(request5, response5){
            console.log('output : ' + response5);
            if(!response5.result){
				alert(response5.ment.replace('\\r', '\n'));
                return false;
			}
			
			medibox.methods.point.collect(data, function(request1, response1){
				console.log('output : ' + response1);
				if(!response1.result){
					alert(response1.ment.replace('\\r', '\n'));
					return false;
				}
				var point_type2 = 'P';
				var memo2 = '관리자 예약 수정 (반환된 서비스 포인트: '+medibox.methods.toNumber(reservation_old_price)+')';
				
				var data2 = { admin_seqno:1, user_seqno:user_seqno, service_seqno: service_seqno,
					point_type:point_type2, memo:memo2, admin_name: '' };
					
				medibox.methods.point.use(data2, function(request2, response2){
					console.log('output : ' + response2);
					if(!response2.result){
						alert(response2.ment.replace('\\r', '\n'));
						return false;
					}
					
					medibox.methods.store.reservation.modify({
						status: res_status
						, use_icon_important: use_icon_important
						, use_icon_phone: use_icon_phone
						, use_custom_color: use_custom_color
						
						, custom_color: '#000000'
						, estimated_time: estimated_time
						, start_dt: start_dt
						, memo: memox
						, apply_on_mobile: apply_on_mobile

						, partner_seqno: partner
						, store_seqno: store
						, manager_seqno: manager
						, service_seqno: service_seqno
						, user_seqno: user_seqno
						, admin_seqno: {{ $seqno }}
						, user_name: user_name
						, user_phone: user_phone
					}, reservationseqno, function(request, response){
						console.log('output : ' + response);
						if(!response.result){
							alert(response.ment);
							return false;
						}
						alert('수정 되었습니다.');
			//			cancel();
						location.reload();
					}, function(e){
						console.log(e);
						alert('서버 통신 에러');
					});
				}, function(e){
					console.log(e);
					alert('서버 통신 에러');
				});
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});		
        }, function(e){
            console.log(e);
            alert('서버 통신 에러');
        });		
			
	}
	function checkValidation(){
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').val();
		var use_icon_phone = $('#use_icon_phone').val();
		var use_custom_color = $('#use_custom_color').val();
		var estimated_time = $('#estimated_time').val(); 
		var start_dt1 = $('#startTime1').val(); 
		var start_dt2 = $('#startTime2').val(); 
		var memo = $('#memo').val(); 
		
		if(!user_seqno || user_seqno == '') {
			alert('예약할 고객을 선택해 주세요.');
			return false;
		}
		if(!partner || partner == '') {
			alert('제휴사를 선택해 주세요.');
			return false;
		}
		if(!store || store == '') {
			alert('매장을 선택해 주세요.');
			return false;
		}
		if(!manager || manager == '') {
			alert('담당자를 선택해 주세요.');
			return false;
		}		
		if(!service_seqno || service_seqno == '') {
			alert('서비스를 선택해 주세요.');
			return false;
		}
		if (!start_dt1 || start_dt1 == '' || !start_dt2 || start_dt2 == '') {
			alert('서비스 시작시간을 입력해 주세요.');
			return false;
		}
		if (!estimated_time || estimated_time == '') {
			alert('예상 소요시간 선택해 주세요.');
			return false;
		}

		return true;
	}

	function gotoInfoDetail(seq){
		location.href = '/admin/members/'+seq+'/infos';
	}		
	function popOpen(id){
		$('body, html').css('overflow', 'hidden');
		if(id && id != '') {
			// 
		}
		$('#popReservation').show();
	}
	function popHide(){
		$('body, html').css('overflow', 'none');
		$('#popReservation').hide();
	}
	
	$(document).ready(function(){
		var _bodyContents = '<option value="">선택해주세요.</option>';
		for(var idx = 10; idx < 16; idx++){
			_bodyContents = _bodyContents + '<option value="'+idx+'">'+(idx == 0 ? '' : idx+'시 ')+'</option>';
		}
		$('#startTime1').html(_bodyContents);
		_bodyContents = '<option value="">선택해주세요.</option>';
		for(var jdx = 0; jdx < 6; jdx++){
			_bodyContents = _bodyContents + '<option value="'+(jdx*10)+'">'+(jdx*10+'분')+'</option>';
		}
		$('#startTime2').html(_bodyContents);
		_bodyContents = '<option value="">선택해주세요.</option>';
		for(var idx = 0; idx < 3; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="0'+idx+':'+(jdx*10 < 10 ? '00' : jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#estimated_time').html(_bodyContents);
	});
</script>