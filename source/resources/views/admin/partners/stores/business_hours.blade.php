
@php 
$page_title = '예약가능시간 관리';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">예약가능시간 관리</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">매장</div>
				<div class="wr-list-con">
					<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
						<option>검색가능 셀렉트</option>
					</select>
					<select class="default" id="storePop" onchange="chooseStore(this.value)">
						<option>검색가능 셀렉트</option>
					</select>
				</div>
			</div>
			
			<div class="wr-list">
				<div class="wr-list-label">영업시간</div>
				<div class="wr-list-con">
					<div class="wr-list">
						<div class="wr-list-con">시작시간</div>
						<div class="wr-list-con">종료시간</div>
						<div class="wr-list-con">해당 요일</div>
						<div class="wr-list-con">수정</div>
					</div>
					<div class="wr-list">
						<div class="wr-list-con">
							<select id="start_dt" class="default">
								<option>일반 셀렉트</option>
							</select>
						</div>
						<div class="wr-list-con">
							<select id="end_dt" class="default">
								<option>일반 셀렉트</option>
							</select>
						</div>
						<div class="wr-list-con">
							<label class="checkbox-wrap"><input type="checkbox" name="due_day1" value=""><span></span>월</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day2" value=""><span></span>화</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day3" value=""><span></span>수</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day4" value=""><span></span>목</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day5" value=""><span></span>금</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day6" value=""><span></span>토</label>
							<label class="checkbox-wrap"><input type="checkbox" name="due_day0" value=""><span></span>일</label>
						</div>
						<div class="wr-list-con">
							<a href="#" class="btn black ml5" onclick="updateDueTime()">수정</a>
						</div>
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">점심시간</div>
				<div class="wr-list-con">
					<div>
						<label class="radio-wrap"><input type="radio" name="allow_lunch_reservate" value="Y"><span></span>예약 받음</label>
						<label class="radio-wrap"><input type="radio" name="allow_lunch_reservate" value="N" checked="checked"><span></span>예약 받지 않음</label>
						<a href="#" class="btn black ml5" onclick="updateLunchTime()">수정</a>
					</div>
					<div>
						<select id="lunch_start_dt" class="default">
							<option>일반 셀렉트</option>
						</select>
						~
						<select id="lunch_end_dt" class="default">
							<option>일반 셀렉트</option>
						</select>
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장휴일</div>
				<div class="wr-list-con">
					<div>
						<label class="radio-wrap"><input type="radio" name="allow_ext_holiday" value="N"><span></span>없음 (직원별 순환휴일)</label>
					</div>
					<div>
						<label class="radio-wrap"><input type="radio" name="allow_ext_holiday" value="W"><span></span>매주</label>
						<select id="ext_holiday_weekly" class="default">
							<option>일반 셀렉트</option>
						</select>
					</div>
					<div>
						<label class="radio-wrap"><input type="radio" name="allow_ext_holiday" value="M"><span></span>매월</label>
						<select id="ext_holiday_weekend_week" class="default">
							<option>일반 셀렉트</option>
						</select>
						<select id="ext_holiday_weekend_day" class="default">
							<option>일반 셀렉트</option>
						</select>
					</div>
					<div>
						<label class="radio-wrap"><input type="radio" name="allow_ext_holiday" value="D"><span></span>매월</label>
						<input type="text" id="ext_holiday_montly" name="" value="" class="span200" placeholder="1,10,20">
						일 (입력 예 1,10,20)
						<a href="#" class="btn black ml5" onclick="updateStoreHoliday()">수정</a>
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장휴일 (날짜별 설정)</div>
				<div class="wr-list-con">
					<a href="#" class="btn black ml5">등록</a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
	</div>

	<script>
		function clearForm(){
			$('#start_dt').val('');
			$('#end_dt').val('');

			for(var inx = 0; inx<7; inx++){
				$('input[name=due_day'+inx+']').prop('checked', false); 
			}
			$('input[name=allow_lunch_reservate]').prop('checked', false); 
			$('#lunch_start_dt').val('');
			$('#lunch_end_dt').val('');
			
			$('#ext_holiday_weekly').val('');
			$('#ext_holiday_weekend_week').val('');
			$('#ext_holiday_weekend_day').val('');
			$('#ext_holiday_montly').val('');
			$('input[name=allow_ext_holiday][value=N]').prop('checked', true);
		}
		function updateDueTime(){
			const start_dt = $('#start_dt').val();
			const end_dt = $('#end_dt').val();
			var dueDay = '';

			for(var inx = 0; inx<7; inx++){
				if($('input[name=due_day'+inx+']').is(":checked")) {
					dueDay = dueDay + (dueDay == '' ? inx : ','+inx);
				}
			}
			if(!start_dt || start_dt == '') {
				alert('시작 시간을 입력해주세요.');
				return false;
			}
			if(!end_dt || end_dt == '') {
				alert('종료 시간을 입력해주세요.');
				return false;
			}
			if(!dueDay || dueDay == '') {
				alert('근무 요일을 선택해주세요.');
				return false;
			}
			data.start_dt = start_dt;
			data.end_dt = end_dt;
			data.due_day = dueDay;
			updateStore();
		}
		function updateLunchTime(){
			const lunch_start_dt = $('#lunch_start_dt').val();
			const lunch_end_dt = $('#lunch_end_dt').val();
			const allow_lunch_reservate = $('input[name=allow_lunch_reservate]:checked').val();

			if(!lunch_start_dt || lunch_start_dt == '') {
				alert('시작 시간을 입력해주세요.');
				return false;
			}
			if(!lunch_end_dt || lunch_end_dt == '') {
				alert('종료 시간을 입력해주세요.');
				return false;
			}
			if(!allow_lunch_reservate || allow_lunch_reservate == '') {
				alert('점심시간에 예약을 받을지 선택해주세요.');
				return false;
			}
			data.lunch_start_dt = lunch_start_dt;
			data.lunch_end_dt = lunch_end_dt;
			data.allow_lunch_reservate = allow_lunch_reservate;
			updateStore();
		}
		function updateStoreHoliday(){
			const ext_holiday_weekly = $('#ext_holiday_weekly').val();
			const ext_holiday_weekend_week = $('#ext_holiday_weekend_week').val();
			const ext_holiday_weekend_day = $('#ext_holiday_weekend_day').val();
			const ext_holiday_montly = $('#ext_holiday_montly').val();
			const allow_ext_holiday = $('input[name=allow_ext_holiday]:checked').val();

			if(!allow_ext_holiday || allow_ext_holiday == '') {
				alert('휴일 설정을 선택해주세요.');
				return false;
			} else if(allow_ext_holiday == 'W'){
				if(!ext_holiday_weekly || ext_holiday_weekly == '') {
					alert('요일을 선택해주세요.');
					return false;
				}
			} else if(allow_ext_holiday == 'M'){
				if(!ext_holiday_weekend_week || ext_holiday_weekend_week == '') {
					alert('주차를 선택해주세요.');
					return false;
				}
				if(!ext_holiday_weekend_day || ext_holiday_weekend_day == '') {
					alert('요일을 선택해주세요.');
					return false;
				}
			} else if(allow_ext_holiday == 'D'){
				if(!ext_holiday_montly || ext_holiday_montly == '') {
					alert('날짜를 입력해주세요.');
					return false;
				}
			}
			data.ext_holiday_weekly = ext_holiday_weekly;
			data.ext_holiday_weekend_day = ext_holiday_weekend_week + '-' + ext_holiday_weekend_day;
			data.ext_holiday_montly = ext_holiday_montly;
			data.allow_ext_holiday = allow_ext_holiday;
			updateStore();
		}
		</script>
	<script>
	var data;
	
	function cancel(){
		window.location.href = '/admin/services';
	}

	function updateStore(){
		medibox.methods.store.modify({
			name: data.name
			, phone: data.phone
			, address: data.address
			, address_detail: data.address_detail
			, zipcode: data.zipcode
			, partner_seqno: data.partner_seqno
			, in_manager: data.in_manager
			, manager_type: data.manager_type

			, start_dt: data.start_dt
			, end_dt: data.end_dt
			, due_day: data.due_day
			
			, lunch_start_dt: data.lunch_start_dt
			, lunch_end_dt: data.lunch_end_dt
			, allow_lunch_reservate: data.allow_lunch_reservate
			
			, allow_ext_holiday: data.allow_ext_holiday
			, ext_holiday_weekly: data.ext_holiday_weekly
			, ext_holiday_weekend_day: data.ext_holiday_weekend_day
			, ext_holiday_montly: data.ext_holiday_montly

			, admin_seqno: {{ $seqno }}
		}, data.seqno, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
		});
	}

	function getPartners(){
		// TODO: 제휴사 로그인시에는 해당 값에 할당
		var partnerId = '';
		var data = { adminSeqno:{{ $seqno }} };

		if(partnerId && partnerId != '') {
			data.id = partnerId;
		}
// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option>선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')" '
						+(data.partner_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			getStoresPop(partnerId);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var store;
	function getStoresPop(partner_seqno){
		var data = { partner_seqno:partner_seqno, adminSeqno:{{ $seqno }} };
// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" '
					+(data.store_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].name+'</option>';
			}
			store = response.data;
			$('#storePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function chooseStore(idx){
		clearForm();
		data = store.filter(s => s.seqno == idx)[0];
		setInfo();
	}
	function setInfo(){
		// 
		$('#start_dt').val(data.start_dt);
		$('#end_dt').val(data.end_dt);

		for(var inx = 0; inx<7; inx++){
			$('input[name=due_day'+inx+']').prop('checked', false); 
		}
		if(data.due_day && data.due_day.indexOf(',') > 0) {
			const targetDay = data.due_day.split(',');
			for(var inx = 0; inx<7; inx++){
				if(targetDay.hasOwnProperty(inx)) $('input[name=due_day'+inx+']').prop('checked', true); 
			}
		}
		$('input[name=allow_lunch_reservate][value='+data.allow_lunch_reservate+']').prop('checked', true); 
		$('#lunch_start_dt').val(data.lunch_start_dt);
		$('#lunch_end_dt').val(data.lunch_end_dt);
		
		$('#ext_holiday_weekly').val(data.ext_holiday_weekly);
		$('#ext_holiday_weekend_week').val(data.end_dt);
		$('#ext_holiday_weekend_day').val(data.end_dt);
		$('#ext_holiday_montly').val(data.ext_holiday_montly);
		$('input[name=allow_ext_holiday][value='+data.allow_ext_holiday+']').prop('checked', true); 
	}
	function generateTime(){
		
		var _bodyContents = '<option value="">선택해주세요.</option>';
		for(var idx = 5; idx < 22; idx++){
			for(var jdx = 0; jdx < 2; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="'+(idx < 10 ? '0'+idx : idx)+':'+(jdx == 0? '0' : '')+''+(jdx*30)+'">'+(idx == 0 ? '' : idx+'시 ')+(jdx == 0 ? '' : jdx*30+'분')+'</option>';
			}
		}
		$('#start_dt').html(_bodyContents);
		$('#end_dt').html(_bodyContents);
		$('#lunch_start_dt').html(_bodyContents);
		$('#lunch_end_dt').html(_bodyContents);
		$('#lunch_end_dt').html(_bodyContents);

		_bodyContents = '';
		const dayOfWeek = ['일','월','화','수','목','금','토'];
		for(var idx = 1; idx < 8; idx++){
			_bodyContents = _bodyContents + '<option value="'+(idx % 7)+'">'+dayOfWeek[idx%7]+'요일</option>';
		}
		$('#ext_holiday_weekly').html(_bodyContents);
		$('#ext_holiday_weekend_day').html(_bodyContents);

		_bodyContents = '';
		const weekOfMonth = ['첫번째','두번째','세번째','네번째','다섯번째'];
		for(var idx = 0; idx < 5; idx++){
			_bodyContents = _bodyContents + '<option value="'+(idx+1)+'">'+weekOfMonth[idx]+'주</option>';
		}
		$('#ext_holiday_weekend_week').html(_bodyContents);
	}
	
	$(document).ready(function(){
		generateTime();
		getPartners();
	});
	</script>
</section>

@include('admin.footer')
