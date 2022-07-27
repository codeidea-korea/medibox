@php 
$page_title = '예약 현황';


$table_head_height = 64;  //테이블 헤드 높이
$cell_width = 136; //셀 가로사이즈
$cell_height = 48; //셀 세로사이즈


@endphp
@include('admin.header')

<style>
/*
#bookingContainer{
	--table-head-height:@php echo $table_head_height ; @endphp px;
	--cell-width:@php echo $cell_width; @endphp px; 
	--cell-height:@php echo $cell_height; @endphp px;
}	
*/
</style>

<section class="container">
	<!-- <div class="page-title">예약 현황</div> -->

	<div class="section-header">
		예약현황
		@php
		if(session()->get('admin_type') == 'A') {
			@endphp
			<select class="small right" id="_partners" onchange="getStores(this.value)">
				<option>제휴사 전체 (슈퍼어드민만 노출)</option>
				<option>OOO OOOOOO</option>
				<option>OOO OOOOOO</option>
				<option>OOO OOOOOO</option>
			</select>
			@php
		}
		@endphp
	</div>

	<div id="bookingContainer">
	<!--
		<section class="topCon _reservationTargetDate"> 
			<div class="dateSet">
				<a onclick="findTargetDate(this)" class="btn gray">1</a>
			</div>
		</section>

		<section class="topCon">
			<div class="dateSet">
				<button class="prev" onclick="findNextDate(-1)"></button>
				<input type="text" id="current_date" class="datepick">			
				<button class="next" onclick="findNextDate(1)"></button>
				<label for="current_date" class="calendar"></label>
			</div>
			<div class="btnSet">
				<a href="/admin/reservations" class="btn-list">예약내역</a>
				<a href="#" onclick="addItem()" class="btn-write">예약등록</a>
			</div>
		</section>
		-->

		<section class="topCon">
			<div class="today-info">
				<sub>오늘</sub>@php $yoil = array("일","월","화","수","목","금","토"); echo date('m/d', time()) . ' (' .$yoil[date('w', time())] . ')'; @endphp</div>
			<div class="topCon_d1 _reservationTargetDate">
				<a href="#" class="btn-day ">1</a>
				<a href="#" class="btn-day active">8</a>
			</div>
			<div class="topCon_d2">
				<div class="dateSet">
					<button class="prev" onclick="findNextDate(-1)"></button>
					<input type="text" id="current_date" class="datepick">			
					<button class="next" onclick="findNextDate(1)"></button>
					<label for="current_date" class="calendar"></label>
				</div>
				<div class="btnSet">
					<a href="/admin/reservations" class="btn-list">예약내역</a>
					<a href="#" onclick="addItem()" class="btn-write">예약등록</a>
				</div>
			</div>
		</section>

		<!--
		<section class="tabsCate" id="_partners">
			<a href="#" class="active">전체</a>
			<a href="#" class="">바라는 네일</a>
			<a href="#" class="">딥포커스 검안소</a>
			<a href="#" class="">포레스타 블랙</a>
			<a href="#" class="">미니쉬 스파</a>
			<a href="#" class="">발몽 스파</a>
			<a href="#" class="">미니쉬 도수</a>
		</section>
		-->
		<section class="tabsCate" id="_store">
			<a href="#" class="active">전체</a>
			<a href="#" class="">바라는 네일</a>
			<a href="#" class="">딥포커스 검안소</a>
			<a href="#" class="">포레스타 블랙</a>
			<a href="#" class="">미니쉬 스파</a>
			<a href="#" class="">발몽 스파</a>
			<a href="#" class="">미니쉬 도수</a>
		</section>

		<section class="bodyCon">
			<div class="leftCon">
				<!--
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">일<br>3/6</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">월<br>3/7</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate active">화<br>3/8</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">수<br>3/9</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">목<br>3/10</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">금<br>3/11</a>
				<a href="#" onclick="findTargetDate(this)" class="btn-day _reservationSearchDate">토<br>3/12</a>
				<div class="navigation">
					<button class="prev" onclick="findNextDate(-7)"></button>
					<button class="next" onclick="findNextDate(7)"></button>
				</div>
				<a href="#" class="btn-setting" onclick="gotoConfig()">설정</a>
	-->
			</div>

			<div class="tableChart">
				
				<div class="leftContainer">
					<div class="col" id="storeOpendTime">
						<span class="cell">10:10</span>
					</div>
				</div>

				<div class="bodyContainer">
					<div class="head">
						<div class="inner" style="width: 3678px;">
							<div class="row" id="_stores">
								<span class="cell col-3">발몽스파</span>
							</div>
							<div class="row" id="_managers">
								<span class="cell">발몽A</span>
							</div>
						</div>
					</div>
					
					<div class="body">					
						<div class="inner" id="_reservateTime">
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<div class="labelSet">
			<span class="label-1">예약가능</span>
			<span class="label-2">예약불가</span>
			<span class="label-3">예약완료</span>
			<span class="label-4">예약불이행</span>
			<span class="label-5">고객입장</span>
			<span class="label-6">서비스완료</span>
			<span class="label-7">예약취소</span>
		</div>
	</div>
	
	<script>	
	var pageNo = 1;
	var pageSize = 10;
	const timeGap = 10; // 10분 갭

	$('.datepick').each(function() {
		$(this).datepicker({
			language: 'ko-KR',
			autoPick: true,
			autoHide: true,
			format: 'yyyy년 m월 d 일'
		}).on('change', function(e) {
			var current_date = $('.datepick').val();
			searchDate = current_date.replace('년 ', '-').replace('월 ', '-').replace('일', '');
			var week = $(this).datepicker('getDayName');
			$(this).val(current_date + ' (' + week + ')');
			
			makeThisWeek(searchDate);
		});
		var current_date = $('.datepick').val();
		var week = $(this).datepicker('getDayName');
			$(this).val(current_date + ' (' + week + ')');
	});

	$('.head .row').each(function() {
		var cell_width = 136;
		var row_count = $(this).children('.cell').length;
		$(this).parent('.inner').css({'width':cell_width*row_count+6});
		$('.body .inner').css({'width':cell_width*row_count});
	});
	$(".tableChart .body").scroll(function () {
		$(".leftContainer").scrollTop($(this).scrollTop());
		$(".tableChart .head").scrollLeft($(this).scrollLeft());
	});
	$(".leftContainer").scroll(function () {
		$(".tableChart .body").scrollTop($(this).scrollTop());
	});

// 예약 완료
	var layer_select3 = '<ul class="layerSelect">';
	layer_select3 += '<li><a href="#" class="active">예약완료</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'E\')">고객입장</a></li>';
	layer_select3 += '<li><a href="#" onclick="modifyItem()">예약수정</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'C\')">예약취소</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'N\')">예약불이행</a></li>';
	layer_select3 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select3 += '</ul>';

// 예약 불이행
	var layer_select4 = '<ul class="layerSelect">';
	layer_select4 += '<li><a href="#" class="active">예약불이행</a></li>';
	layer_select4 += '<li><a href="#" onclick="changeStatus(\'R\')">불이행취소</a></li>';
	layer_select4 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select4 += '</ul>';

// 고객 입장
	var layer_select5 = '<ul class="layerSelect">';
	layer_select5 += '<li><a href="#" class="active">고객입장</a></li>';
	layer_select5 += '<li><a href="#" onclick="changeStatus(\'D\')">서비스완료</a></li>';
	layer_select5 += '<li><a href="#" onclick="modifyItem()">예약수정</a></li>';
	layer_select5 += '<li><a href="#" onclick="changeStatus(\'R\')">입장취소</a></li>';
	layer_select5 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select5 += '</ul>';

// 서비스 완료
var layer_select6 = '<ul class="layerSelect">';
	layer_select6 += '<li><a href="#" class="active">서비스완료</a></li>';
	layer_select6 += '<li><a href="#" onclick="modifyItem()">예약수정</a></li>';
	layer_select6 += '<li><a href="#" onclick="changeStatus(\'E\')">완료취소</a></li>';
	layer_select6 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select6 += '</ul>';
// 예약 취소
	var layer_select7 = '<ul class="layerSelect">';
	layer_select7 += '<li><a href="#" class="active">예약취소</a></li>';
	layer_select7 += '<li><a href="#" onclick="modifyItem()">예약수정</a></li>';
	layer_select7 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select7 += '</ul>';


	$('html').click(function(e) {
		if(!$(e.target).hasClass("cell")) {
			$('.layerSelect').remove();
		}
	});

	function wait(){
		alert('준비중입니다.');
	}
	function loadList(no) {
		pageNo = no;
	}
	function enterkey() {
		if (window.event.keyCode == 13) {
			loadList(1);
		}
	}
	function viewInfo(row){
		var key;
		var target = $(row.target).parent();
		
		if(target.dataset && target.dataset.key) {
			key = target.dataset.key;
		} else {
			// NOTICE: IE 11+ 이하버전, 엣지 구버전, 크롬 84 아래버전의 안드로이드 웹뷰를 사용하는 인앱
			key = $(target).attr('data-key');
		}
		gotoDetail(key);
	}


	// 1 특정 제휴사(최고 관리자는 모든 제휴사) 조회, 제휴사 selet 만들고 전체 제휴사 체크
	var partners;
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
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'"; partnerId = '.session()->get('partner_seqno').';';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			
			var bodyData = '<option value="">제휴사 전체</option>'; // '<a href="#" '+(partnerId && partnerId != '' ? 'class="active"' : '')+'>전체</a>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
				/*
					+'<a href="#" '
						+(response.data[inx].seqno == partnerId ? 'class="active"' : '')+' onclick="getStores('+response.data[inx].seqno+')">'
							+response.data[inx].cop_name +
					'</a>';
					*/
					+ '<option value="'+response.data[inx].seqno+'">'+response.data[inx].cop_name+'</option>';
			}
			$('#_partners').html(bodyData);
			
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			partners = response.data;
			getStores(partnerId);
			getStoresPop(partnerId)
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	// 2 제휴사 식별자로 매장 조회하고 selet 만들고 전체 선택
	var stores;
	function toDate(){
		var thisDay = new Date();
		return toDateFormatt(thisDay.getTime());
	}
	function toDateFormatt(times){
		var thisDay = new Date(times);
		return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
	}
	function toDateFormatt2(times){
		var thisDay = new Date(times);
		return (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '/' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
	}
	function toDateFormatt3(times){
		var thisDay = new Date(times);
		return thisDay.getFullYear() + '년 ' + (thisDay.getMonth()+1) + '월 ' + thisDay.getDate() + '일 (' +convert2Day(thisDay.getDay())+ '요일)';
	}
	function convert2Day(code){
		switch(code){
			case 0: return '일';
			case 1: return '월';
			case 2: return '화';
			case 3: return '수';
			case 4: return '목';
			case 5: return '금';
			case 6: return '토';
			default: break;
		}
	}
	function makeThisWeek(toDate){
		var code = new Date(toDate).getDay();
		$('._reservationSearchDate').removeClass('active');
		
		for(var inx = 0; inx < 7; inx++) {
			var targetDate = new Date(toDate);
			var targetDay = targetDate.setDate(targetDate.getDate() - (code - inx));
			$($('._reservationSearchDate')[inx]).html(convert2Day(targetDate.getDay()) + '<br>' + toDateFormatt2(targetDay));
			$($('._reservationSearchDate')[inx]).attr('data-key', toDateFormatt(targetDate.getTime()));
			if(code == inx) {
				$($('._reservationSearchDate')[inx]).addClass('active');
			}
		}
		makeThisMonth(toDate);
		$('#current_date').val(toDateFormatt3(toDate));
		makeReservationBodyCeil();
	}
	function makeThisMonth(toDate){
		var code = new Date(toDate).getDate();
		$('._reservationTargetDate > a').remove();

		// code : 선택일자
		// 이달 마지막 일자
		var lastDay = new Date(toDate);
		lastDay.setMonth(lastDay.getMonth() + 1);
		lastDay.setDate(1);
		lastDay.setDate(lastDay.getDate() - 1);
		lastDay = lastDay.getDate();

		var tmpHtml = '';

		for(var inx = 0; inx < lastDay; inx++) {
			var targetDate = new Date(toDate);
			targetDate.setDate(inx+1);
			
			if((code-1) == inx) {
				tmpHtml = tmpHtml + '<a class="btn-day active" data-key="'+toDateFormatt(targetDate.getTime())+'" onclick="findTargetDate(this)">'+(inx+1)+'</a>';
			} else {
				tmpHtml = tmpHtml + '<a class="btn-day" data-key="'+toDateFormatt(targetDate.getTime())+'" onclick="findTargetDate(this)">'+(inx+1)+'</a>';
			}
		}
		$('._reservationTargetDate').html(tmpHtml);
	}

	var searchDate = toDate();
	function findNextDate(pt){
		var targetDay = new Date(searchDate);
		targetDay.setDate(targetDay.getDate() + pt);
		searchDate = toDateFormatt(targetDay.getTime());
		makeThisWeek(searchDate);
	}
	function findTargetDate(target){
		var targetDay = $(target).attr('data-key');
		targetDay = new Date(targetDay);
		searchDate = toDateFormatt(targetDay.getTime());
		makeThisWeek(searchDate);
	}
	function loadStoreConfig(){
		// TODO: 특정 제휴 > 매장의 휴일/근무시간, 담당 디자이너별 휴무일을 확인하여 예약이 가능한 상황인지 아닌지 판단한다.
		// 우선 스킵
	}
	function gotoConfig(){
		// TODO: 예약 설정 옵션 페이지로 이동한다.
		wait();
	}
	function makeManagers(){
		if(!stores || !stores.managerInfo || stores.managerInfo.length == 0) {
			alert('해당 매장에는 예약 가능한 직원이 없습니다. 먼저 예약 가능한 직원을 등록해주세요.');
//			return false;
		}
//		var bodyData = ''; // '<span class="cell">미지정</span>';
		// 2022-05-27, 기본값 매장별 추가
		// 2022-07-12 매장별 기본값 삭제
		var bodyData = '';
		for(var idx = 0; idx < stores.length; idx++)
		{
			// <span class="cell col-3">발몽스파</span>
//			bodyData = bodyData + '<span class="cell">'+stores[idx].name+' (미지정)</span>';
			bodyData = bodyData + '<span class="cell col-'+stores[idx].managerInfo.filter(manager => manager.deleted == 'N').length+'">'+stores[idx].name+'</span>';
		}
		// _stores
		$('#_stores').html(bodyData);
		var bodyDataManagers = '';
		if(stores.managerInfo.length){
			for(var inx=0; inx<stores.managerInfo.length; inx++){
				bodyDataManagers = bodyDataManagers + '<span class="cell">'+stores.managerInfo[inx].manager_type + ' ' + stores.managerInfo[inx].name+'</span>';
			}
		} else {
			bodyDataManagers = bodyDataManagers + '<span class="cell">'+stores.managerInfo.manager_type + ' ' + stores.managerInfo.name+'</span>';
		}
		loadStoreConfig();
		$('#_managers').html(bodyDataManagers);
	}
	function addEventCeil(){
		$('.tableChart .body .cell').click(function() {
			$('.layerSelect').remove();
			
			if($(this).hasClass("label-3")) {
				$(this).html($(this).html() + layer_select3);
			} else if($(this).hasClass("label-4")) {
				$(this).html($(this).html() + layer_select4);
			} else if($(this).hasClass("label-5")) {
				$(this).html($(this).html() + layer_select5);
			} else if($(this).hasClass("label-6")) {
				$(this).html($(this).html() + layer_select6);
			} else if($(this).hasClass("label-7")) {
				$(this).html($(this).html() + layer_select7);
			} 
		});
	}
	function dueDay(){
		// NOTICE: fake Time
		stores.conf = {
			dueDay: {
				startTime: '05:00',
				endTime: '21:30'
			}
		};
		if(stores && stores[0]) {

			// 2022-05-27, 시작-종료일 설정 (최소/최대)
			var minTime = '11:00';
			var maxTime = '15:30';

			for(var idx = 0; idx < stores.length; idx++){
				if(stores[idx].start_dt && stores[idx].start_dt != '' && stores[idx].start_dt < minTime) {
					minTime = stores[idx].start_dt;
				}
				if(stores[idx].end_dt && stores[idx].end_dt != '' && stores[idx].end_dt > maxTime) {
					maxTime = stores[idx].end_dt;
				}
			}
			stores.conf = {
				dueDay: {
					startTime: minTime,
					endTime: maxTime
				}
			};
		}
		
		var startTime = new Date(searchDate);
		startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
		startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);
		
		var endTime = new Date(searchDate);
		endTime.setHours(stores.conf.dueDay.endTime.split(':')[0]);
		endTime.setMinutes(stores.conf.dueDay.endTime.split(':')[1]);

		var bodyData = '';
		while(startTime.getTime() < endTime.getTime()){
			bodyData = bodyData + '<span class="cell">'+(startTime.getHours() < 10 ? '0'+startTime.getHours() : startTime.getHours())+':'+(startTime.getMinutes() < 10 ? '00' : startTime.getMinutes())+'</span>';
			startTime.setMinutes(startTime.getMinutes() + timeGap);
		}
		$('#storeOpendTime').html(bodyData);
		
		bodyData = '';
		// 기본 값 추가
		// 2022-05-27, 기본값 매장별 추가
		// 2022-07-12, 매장별 기본값 삭제
		prevtargetStoreSeqno = targetStoreSeqno;
		/*
		for(var idx = 0; idx < stores.length; idx++)
		{
//			bodyData = bodyData + '<div class="col _timeRow" data-alt="'+stores[idx].name+' (미지정)" data-key="0" data-store-key="'+stores[idx].seqno+'">';
			var startTime = new Date(searchDate);
			startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
			startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);

			targetStoreSeqno = stores[idx].seqno;
			var isHoliday = !disableAllTheseDays(startTime);
			var ment = '';
			var isFisrt = false;
			var isNotDueTime = true;

			while(startTime.getTime() < endTime.getTime()){
				var isLaunchTime = false;
				var targetTime = (startTime.getHours() < 10 ? '0'+startTime.getHours() : startTime.getHours())+':'+(startTime.getMinutes() < 10 ? '00' : startTime.getMinutes());
				
				// 업무 시간 체크
				isNotDueTime = !isDueTime(targetTime);
				if(!isNotDueTime) {
					// 업무 시간인 경우
					// 점심 시간을 사용하는 매장의 경우
					if(!disableAllTheseTimes(targetTime)) {
						isLaunchTime = true;
					}
				}
				if(!isHoliday && !isLaunchTime && !isNotDueTime){
					ment = '';
				}
				if(ment != '점심시간' && (isLaunchTime)){
					ment = '점심시간';
					isFisrt = true;
				} else if(isLaunchTime){
					isFisrt = false;
				} else if(ment != '휴일' && (isHoliday)){
					ment = '휴일';
					isFisrt = true;
				} else if(isHoliday){
					isFisrt = false;
				} else if(ment != '근무시간 외' && (isNotDueTime)){
					ment = '근무시간 외';
					isFisrt = true;
				} else if(isNotDueTime){
					isFisrt = false;
				}

				bodyData = bodyData + '<span class="cell '+(isHoliday || isLaunchTime || isNotDueTime ? 'label-2' : '')+'" data-start="'+targetTime+'">'+(isFisrt ? ment : '')+'</span>'; // 예약이 없는 시간에는 기본값 세팅
				startTime.setMinutes(startTime.getMinutes() + timeGap);
			}
			bodyData = bodyData + '</div>';
		}
		*/
		if(stores.managerInfo) {
			if(stores.managerInfo.length){
				for(var inx=0; inx<stores.managerInfo.length; inx++){
					bodyData = bodyData + '<div class="col _timeRow" data-alt="'+stores.managerInfo[inx].name+'" data-key="'+stores.managerInfo[inx].seqno+'" data-store-key="'+stores.managerInfo[inx].store_seqno+'">';

					var startTime = new Date(searchDate);
					startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
					startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);
					targetStoreSeqno = stores.managerInfo[inx].store_seqno;
					var isHoliday = !disableAllTheseDays(startTime);
					var ment = '';
					var isFisrt = false;
					var isNotDueTime = true;

					while(startTime.getTime() < endTime.getTime()){
						var isLaunchTime = false;
						var targetTime = (startTime.getHours() < 10 ? '0'+startTime.getHours() : startTime.getHours())+':'+(startTime.getMinutes() < 10 ? '00' : startTime.getMinutes());
						
						// 업무 시간 체크
						isNotDueTime = !isDueTime(targetTime);
						if(!isNotDueTime) {
							// 업무 시간인 경우
							// 점심 시간을 사용하는 매장의 경우
							if(!disableAllTheseTimes(targetTime)) {
								isLaunchTime = true;
							}
						}
						if(!isHoliday && !isLaunchTime && !isNotDueTime){
							ment = '';
						}
						if(ment != '점심시간' && (isLaunchTime)){
							ment = '점심시간';
							isFisrt = true;
						} else if(isLaunchTime){
							isFisrt = false;
						} else if(ment != '휴일' && (isHoliday)){
							ment = '휴일';
							isFisrt = true;
						} else if(isHoliday){
							isFisrt = false;
						} else if(ment != '근무시간 외' && (isNotDueTime)){
							ment = '근무시간 외';
							isFisrt = true;
						} else if(isNotDueTime){
							isFisrt = false;
						}
						bodyData = bodyData + '<span class="cell '+(isHoliday || isLaunchTime || isNotDueTime ? 'label-2' : '')+'" data-start="'+targetTime+'">'+(isFisrt ? ment : '')+'</span>'; // 예약이 없는 시간에는 기본값 세팅
						startTime.setMinutes(startTime.getMinutes() + timeGap);
					}
					bodyData = bodyData + '</div>';
				}
			} else {
				bodyData = bodyData + '<div class="col _timeRow" data-alt="'+stores.managerInfo.name+'" data-key="'+stores.managerInfo.seqno+'" data-store-key="'+stores.managerInfo.store_seqno+'">';

				var startTime = new Date(searchDate);
				startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
				startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);
				targetStoreSeqno = stores.managerInfo.store_seqno;
				var isHoliday = !disableAllTheseDays(startTime);
				var ment = '';
				var isFisrt = false;
				var isNotDueTime = true;

				while(startTime.getTime() < endTime.getTime()){
					var isLaunchTime = false;
					var targetTime = (startTime.getHours() < 10 ? '0'+startTime.getHours() : startTime.getHours())+':'+(startTime.getMinutes() < 10 ? '00' : startTime.getMinutes());
					
					// 업무 시간 체크
					isNotDueTime = !isDueTime(targetTime);
					if(!isNotDueTime) {
						// 업무 시간인 경우
						// 점심 시간을 사용하는 매장의 경우
						if(!disableAllTheseTimes(targetTime)) {
							isLaunchTime = true;
						}
					}
					if(!isHoliday && !isLaunchTime && !isNotDueTime){
						ment = '';
					}
					if(ment != '점심시간' && (isLaunchTime)){
						ment = '점심시간';
						isFisrt = true;
					} else if(isLaunchTime){
						isFisrt = false;
					} else if(ment != '휴일' && (isHoliday)){
						ment = '휴일';
						isFisrt = true;
					} else if(isHoliday){
						isFisrt = false;
					} else if(ment != '근무시간 외' && (isNotDueTime)){
						ment = '근무시간 외';
						isFisrt = true;
					} else if(isNotDueTime){
						isFisrt = false;
					}
					bodyData = bodyData + '<span class="cell '+(isHoliday || isLaunchTime || isNotDueTime ? 'label-2' : '')+'" data-start="'+targetTime+'">'+(isFisrt ? ment : '')+'</span>'; // 예약이 없는 시간에는 기본값 세팅
					startTime.setMinutes(startTime.getMinutes() + timeGap);
				}
				bodyData = bodyData + '</div>';
			}
		}
		targetStoreSeqno = prevtargetStoreSeqno;
		$('#_reservateTime').html(bodyData);
	}
	let partnerseqno;
	let storeseqno;
	let reservationseqno = 0;
	let userseqno = 0;
	var reservationInfos;
	var cellHeight = 1;
	function makeReservationBodyCeil(){
		// TODO: 실제 예약이 발생하는, 발생한 내역을 표로 보여준다.
		// 1. 제휴사, 매장, searchDate 날자 -> 예약정보를 조회
		medibox.methods.store.reservation.day({
			partner_seqno: partnerseqno,
			store_seqno: storeseqno,
			start_dt: searchDate + ' 00:00:00',
			end_dt: searchDate + ' 23:59:59',
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			// 아티스트 x 근로시간 2차 배열
			var bodyData = '<a href="#" class="active">전체</a>';
			if(!stores) {
				return;
			}
			$('._timeRow[data-key=0] > span').removeClass('label-1');
			$('._timeRow[data-key=0] > span').removeClass('label-2');
			$('._timeRow[data-key=0] > span').removeClass('label-3');
			$('._timeRow[data-key=0] > span').removeClass('label-4');
			$('._timeRow[data-key=0] > span').removeClass('label-5');
			$('._timeRow[data-key=0] > span').removeClass('label-6');
//			$('._timeRow[data-key=0] > span').removeClass('label-7');
			$('._timeRow[data-key=0] > span').text('');

			if(stores.managerInfo && stores.managerInfo.length > 0) {
				
				for(var inx=0; inx<stores.managerInfo.length; inx++){
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-1');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-2');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-3');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-4');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-5');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-6');
//					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').removeClass('label-7');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').html('');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').attr('style', '');
					$('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span').show();
				}
			}
			dueDay();
			addEventCeil();
			cellHeight = $('._timeRow > .cell').height();

			var reservationCancel = response.data.filter(reservation => reservation.status == 'C');
			var reservations = response.data.filter(reservation => reservation.status != 'C');

			response.data = reservationCancel;
//			reservationInfos = response.data;
			{
				for(var inx=0; inx<response.data.length; inx++){
					var manager_seqno = 0;
					var store_seqno = 0;
					if(stores.managerInfo.filter(m => m.seqno == response.data[inx].manager_seqno).length > 0) {
						manager_seqno = stores.managerInfo.filter(m => m.seqno == response.data[inx].manager_seqno)[0].seqno;
					}
					store_seqno = response.data[inx].store_seqno;
					// custom_color
					var startTime = response.data[inx].start_dt.split(' ')[1].substring(0, 5);
					var countColor = Number(response.data[inx].estimated_time.split(':')[0]) * 6 + Number(response.data[inx].estimated_time.split(':')[1]) / 10;				
					var timeCeils = $('._timeRow[data-key='+manager_seqno+'][data-store-key='+store_seqno+'] > span');

					var targetIdx = 0;
					for(var jnx=0; jnx<timeCeils.length; jnx++){
						if($(timeCeils[jnx]).attr('data-start') == response.data[inx].start_dt.split(' ')[1].substring(0, 5)) {
							targetIdx = jnx;
							break;
						}
					}
					// 예약 상태에 따른 help툴바 세팅
					var status = response.data[inx].status;
					var barCaption = 'label-3';
					if(status == 'R') {}
					else if(status == 'E'){
						barCaption = 'label-5';
					}
					else if(status == 'D'){
						barCaption = 'label-6';
					}
					else if(status == 'N'){
						barCaption = 'label-4';
					}
					else if(status == 'C'){
						barCaption = 'label-7';
	//					continue;
					}
					if(!reservationInfos){
						reservationInfos = [];
					}
					reservationInfos.push(response.data[inx]);

					for(var jnx=0; jnx < countColor; jnx++){
						if(jnx == 0) {
							// 첫행에는 이모티콘 옵션 부여
							let reservationBoxText = '';
							if(response.data[inx].use_icon_important == 'Y') {
								reservationBoxText = reservationBoxText + ' ★';
							} 
							if(response.data[inx].use_icon_phone == 'Y') {
								reservationBoxText = reservationBoxText + ' ☏';
							} 
							if(response.data[inx].provisional == 'Y') {
								reservationBoxText = reservationBoxText + ' ※';
							} 					
							if((!$(timeCeils[targetIdx + jnx]).html() && $(timeCeils[targetIdx + jnx]).html() != '') 
								|| $(timeCeils[targetIdx + jnx]).html().indexOf('info cancel') > -1 && status == 'C') {
								continue;
							}
							var timeinfos = response.data[inx].estimated_time.split(':');
							var isDueTime = true;
							timeinfos[0] = Number(timeinfos[0]);
							timeinfos[1] = Number(timeinfos[1]);
							/*
							$(timeCeils[targetIdx + jnx]).html(reservationBoxText + ' ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name) + ' 고객님 <br>'
								+ response.data[inx].serviceInfo.dept + ' ' + response.data[inx].serviceInfo.name + ' <br>'
								+ ((timeinfos[0]*60 + timeinfos[1])+'분')
							);
							*/
							$(timeCeils[targetIdx + jnx]).attr('style', 'height:'+(cellHeight * countColor)+'px;');

							$(timeCeils[targetIdx + jnx]).removeClass('label-2');
							$(timeCeils[targetIdx + jnx]).attr('data-reservation-id', response.data[inx].seqno);
							$(timeCeils[targetIdx + jnx]).attr('data-user-id', response.data[inx].user_seqno);
							/*
							$(timeCeils[targetIdx + jnx]).attr('title', 
								'이름 : ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name) + '\n'
								+ '전화번호 : ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)  + '\n'
								+ '추천인 : ' + (response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '') + '\n'
								+ '메모 : ' + response.data[inx].memo + '');
								*/		
							$(timeCeils[targetIdx + jnx]).html(
								(status == 'C'
									? $(timeCeils[targetIdx + jnx]).html() 
										+ '<span class="info cancel">'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+' 고객 '+response.data[inx].serviceInfo.name+' '+((timeinfos[0]*60 + timeinfos[1])+'분')
										+'<div class="hover-mb-info hover-mb-info1">'
										+'	<a href="#" class="btn-edit" onclick="reservationseqno = '+response.data[inx].seqno+'; modifyItem()">예약수정</a>'
										+'	<p>예약자 이름 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+'</b></p>'
										+'	<p>예약자 전화번호 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)+'</b></p>'
										+'	<p>추천인 : <b>'+(response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '')+'</b></p>'
										+'	<p>메모 : <b>'+(response.data[inx].memo)+'</b></p>'
										+'	<p>예약서비스 : <b>'+response.data[inx].serviceInfo.name+'</b></p>'
										+'	<p>서비스 시간 : <b>'+((timeinfos[0]*60 + timeinfos[1])+'분')+'</b></p>'
										+'</div></span>'
									: $(timeCeils[targetIdx + jnx]).html() 
										+ '<span class="info">'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+' 고객 '+response.data[inx].serviceInfo.name+' '+((timeinfos[0]*60 + timeinfos[1])+'분')
										+'<div class="hover-mb-info hover-mb-info1">'
										+'	<a href="#" class="btn-edit" onclick="reservationseqno = '+response.data[inx].seqno+'; modifyItem()">예약수정</a>'
										+'	<p>예약자 이름 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+'</b></p>'
										+'	<p>예약자 전화번호 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)+'</b></p>'
										+'	<p>추천인 : <b>'+(response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '')+'</b></p>'
										+'	<p>메모 : <b>'+(response.data[inx].memo)+'</b></p>'
										+'	<p>예약서비스 : <b>'+response.data[inx].serviceInfo.name+'</b></p>'
										+'	<p>서비스 시간 : <b>'+((timeinfos[0]*60 + timeinfos[1])+'분')+'</b></p>'
										+'</div></span>')
							);

							$(timeCeils[targetIdx + jnx]).addClass(barCaption);
							$(timeCeils[targetIdx + jnx]).on('click', function(){
								userseqno = $(this).attr('data-user-id');
								reservationseqno = $(this).attr('data-reservation-id');
							});
						} else {
							// 나머지 행 hide()
							$(timeCeils[targetIdx + jnx]).hide();
						}
						/*
						$(timeCeils[targetIdx + jnx]).removeClass('label-2');
						$(timeCeils[targetIdx + jnx]).attr('data-reservation-id', response.data[inx].seqno);
						$(timeCeils[targetIdx + jnx]).attr('data-user-id', response.data[inx].user_seqno);
						$(timeCeils[targetIdx + jnx]).attr('title', 
							'이름 : ' + response.data[inx].userInfo.user_name + '\n'
							+ '전화번호 : ' + response.data[inx].userInfo.user_phone + '\n'
							+ '추천인 : ' + (response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '') + '\n'
							+ '메모 : ' + response.data[inx].memo + '');
						$(timeCeils[targetIdx + jnx]).addClass(barCaption);
						$(timeCeils[targetIdx + jnx]).on('click', function(){
							userseqno = $(this).attr('data-user-id');
							reservationseqno = $(this).attr('data-reservation-id');
						});
						*/
					}
				}
			}
			response.data = reservations;
			{
				for(var inx=0; inx<response.data.length; inx++){
					var manager_seqno = 0;
					var store_seqno = 0;
					if(stores.managerInfo.filter(m => m.seqno == response.data[inx].manager_seqno).length > 0) {
						manager_seqno = stores.managerInfo.filter(m => m.seqno == response.data[inx].manager_seqno)[0].seqno;
					}
					store_seqno = response.data[inx].store_seqno;
					if(!reservationInfos){
						reservationInfos = [];
					}
					reservationInfos.push(response.data[inx]);
					
					// custom_color
					var startTime = response.data[inx].start_dt.split(' ')[1].substring(0, 5);
					var countColor = Number(response.data[inx].estimated_time.split(':')[0]) * 6 + Number(response.data[inx].estimated_time.split(':')[1]) / 10;				
					var timeCeils = $('._timeRow[data-key='+manager_seqno+'][data-store-key='+store_seqno+'] > span');

					var targetIdx = 0;
					for(var jnx=0; jnx<timeCeils.length; jnx++){
						if($(timeCeils[jnx]).attr('data-start') == response.data[inx].start_dt.split(' ')[1].substring(0, 5)) {
							targetIdx = jnx;
							break;
						}
					}
					// 예약 상태에 따른 help툴바 세팅
					var status = response.data[inx].status;
					var barCaption = 'label-3';
					if(status == 'R') {}
					else if(status == 'E'){
						barCaption = 'label-5';
					}
					else if(status == 'D'){
						barCaption = 'label-6';
					}
					else if(status == 'N'){
						barCaption = 'label-4';
					}
					else if(status == 'C'){
						barCaption = 'label-7';
	//					continue;
					}

					for(var jnx=0; jnx < countColor; jnx++){
						if(jnx == 0) {
							// 첫행에는 이모티콘 옵션 부여
							let reservationBoxText = '';
							if(response.data[inx].use_icon_important == 'Y') {
								reservationBoxText = reservationBoxText + ' ★';
							} 
							if(response.data[inx].use_icon_phone == 'Y') {
								reservationBoxText = reservationBoxText + ' ☏';
							} 
							if(response.data[inx].provisional == 'Y') {
								reservationBoxText = reservationBoxText + ' ※';
							} 					
							var timeinfos = response.data[inx].estimated_time.split(':');
							var isDueTime = true;
							timeinfos[0] = Number(timeinfos[0]);
							timeinfos[1] = Number(timeinfos[1]);
							/*
							$(timeCeils[targetIdx + jnx]).html(reservationBoxText + ' ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name) + ' 고객님 <br>'
								+ response.data[inx].serviceInfo.dept + ' ' + response.data[inx].serviceInfo.name + ' <br>'
								+ ((timeinfos[0]*60 + timeinfos[1])+'분')
							);
							*/
							$(timeCeils[targetIdx + jnx]).attr('style', 'height:'+(cellHeight * countColor)+'px;');

							$(timeCeils[targetIdx + jnx]).removeClass('label-2');
							$(timeCeils[targetIdx + jnx]).attr('data-reservation-id', response.data[inx].seqno);
							$(timeCeils[targetIdx + jnx]).attr('data-user-id', response.data[inx].user_seqno);
							/*
							$(timeCeils[targetIdx + jnx]).attr('title', 
								'이름 : ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name) + '\n'
								+ '전화번호 : ' + (response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)  + '\n'
								+ '추천인 : ' + (response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '') + '\n'
								+ '메모 : ' + response.data[inx].memo + '');
								*/		
							/*
							var isOverlapReservation = $(timeCeils[targetIdx + jnx]).find('.hover-mb-info').length > 0;
							if(isOverlapReservation) {
								var hoverInfoLeft = $(timeCeils[targetIdx + jnx]).find('.hover-mb-info').html();
								var infoLeft = $(timeCeils[targetIdx + jnx]).find('.info.cancel').html();
								infoLeft = '<span class="info cancel">' + infoLeft 
												+ '<div class="hover-mb-info hover-mb-info1">' + hoverInfoLeft + '</div>'
											+ '</span>';
								$(timeCeils[targetIdx + jnx]).html(infoLeft
									+ '<span class="info">'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+' 고객 '+response.data[inx].serviceInfo.name+' '+((timeinfos[0]*60 + timeinfos[1])+'분')
										+'<div class="hover-mb-info hover-mb-info2">'
										+'	<a href="#" class="btn-edit" onclick="reservationseqno = '+response.data[inx].seqno+'; modifyItem()">예약수정</a>'
										+'	<p>예약자 이름 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+'</b></p>'
										+'	<p>예약자 전화번호 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)+'</b></p>'
										+'	<p>추천인 : <b>'+(response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '')+'</b></p>'
										+'	<p>메모 : <b>'+(response.data[inx].memo)+'</b></p>'
										+'	<p>예약서비스 : <b>'+response.data[inx].serviceInfo.name+'</b></p>'
										+'	<p>서비스 시간 : <b>'+((timeinfos[0]*60 + timeinfos[1])+'분')+'</b></p>'
										+'</div></span>');
							} else {
							}
							*/
							$(timeCeils[targetIdx + jnx]).html(
								(status == 'C'
									? $(timeCeils[targetIdx + jnx]).html() 
										+ '<span class="info cancel">'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+' 고객 '+response.data[inx].serviceInfo.name+' '+((timeinfos[0]*60 + timeinfos[1])+'분')
										+'<div class="hover-mb-info hover-mb-info1">'
										+'	<a href="#" class="btn-edit" onclick="reservationseqno = '+response.data[inx].seqno+'; modifyItem()">예약수정</a>'
										+'	<p>예약자 이름 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+'</b></p>'
										+'	<p>예약자 전화번호 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)+'</b></p>'
										+'	<p>추천인 : <b>'+(response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '')+'</b></p>'
										+'	<p>메모 : <b>'+(response.data[inx].memo)+'</b></p>'
										+'	<p>예약서비스 : <b>'+response.data[inx].serviceInfo.name+'</b></p>'
										+'	<p>서비스 시간 : <b>'+((timeinfos[0]*60 + timeinfos[1])+'분')+'</b></p>'
										+'</div></span>'
									: $(timeCeils[targetIdx + jnx]).html() 
										+ '<span class="info">'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+' 고객 '+response.data[inx].serviceInfo.name+' '+((timeinfos[0]*60 + timeinfos[1])+'분')
										+'<div class="hover-mb-info hover-mb-info1">'
										+'	<a href="#" class="btn-edit" onclick="reservationseqno = '+response.data[inx].seqno+'; modifyItem()">예약수정</a>'
										+'	<p>예약자 이름 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_name : response.data[inx].user_name)+'</b></p>'
										+'	<p>예약자 전화번호 : <b>'+(response.data[inx].userInfo ? response.data[inx].userInfo.user_phone : response.data[inx].user_phone)+'</b></p>'
										+'	<p>추천인 : <b>'+(response.data[inx].userInfo && response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '')+'</b></p>'
										+'	<p>메모 : <b>'+(response.data[inx].memo)+'</b></p>'
										+'	<p>예약서비스 : <b>'+response.data[inx].serviceInfo.name+'</b></p>'
										+'	<p>서비스 시간 : <b>'+((timeinfos[0]*60 + timeinfos[1])+'분')+'</b></p>'
										+'</div></span>')
							);

							$(timeCeils[targetIdx + jnx]).addClass(barCaption);
							$(timeCeils[targetIdx + jnx]).on('click', function(){
								userseqno = $(this).attr('data-user-id');
								reservationseqno = $(this).attr('data-reservation-id');
							});
						} else {
							// 나머지 행 hide()
							$(timeCeils[targetIdx + jnx]).hide();
						}
						/*
						$(timeCeils[targetIdx + jnx]).removeClass('label-2');
						$(timeCeils[targetIdx + jnx]).attr('data-reservation-id', response.data[inx].seqno);
						$(timeCeils[targetIdx + jnx]).attr('data-user-id', response.data[inx].user_seqno);
						$(timeCeils[targetIdx + jnx]).attr('title', 
							'이름 : ' + response.data[inx].userInfo.user_name + '\n'
							+ '전화번호 : ' + response.data[inx].userInfo.user_phone + '\n'
							+ '추천인 : ' + (response.data[inx].userInfo.recommendedUser ? response.data[inx].userInfo.recommendedUser.user_name : '') + '\n'
							+ '메모 : ' + response.data[inx].memo + '');
						$(timeCeils[targetIdx + jnx]).addClass(barCaption);
						$(timeCeils[targetIdx + jnx]).on('click', function(){
							userseqno = $(this).attr('data-user-id');
							reservationseqno = $(this).attr('data-reservation-id');
						});
						*/
					}
				}
			}

			let len = 1;
			if(stores.managerInfo && stores.managerInfo.length){
				len = stores.managerInfo.length + 1;
			}
			$('#_reservateTime').width(140 * len);
			$('#_managers').parent().width(140 * len);
			
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var isOnce = false;
	function getStores(partner_seqno, id){
		partnerseqno = partner_seqno;
		storeseqno = id;
		var data = { partner_seqno:partner_seqno, id: id, adminSeqno:{{ $seqno }} };

// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		$('.stores').removeClass("active");
		$('#storesPick'+(id ? id : '')).addClass("active");

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			if(!isOnce) {
				isOnce = true;
				var bodyData = '<a href="#" class="stores active" id="storesPick" onclick="getStores(null, null)">전체</a>';
				for(var inx=0; inx<response.data.length; inx++){
					bodyData = bodyData 
						+'<a href="#" class="stores '
							+(response.data[inx].seqno == id ? 'active' : '')+'" id="storesPick'+response.data[inx].seqno+'" onclick="getStores(null, '+response.data[inx].seqno+')">'
								+response.data[inx].name +
						'</a>';
				}
				$('#_store').html(bodyData);
			}
			stores = response.data;
			if(stores.length) {
				stores.managerInfo = stores.map(store => store.managerInfo).filter(manageInfo => manageInfo != null);
				if(stores.managerInfo && stores.managerInfo.length > 0)
				stores.managerInfo = stores.managerInfo.reduce((a, b) => a.concat(b));

				stores.managerInfo = stores.managerInfo.filter(manageInfo => manageInfo.deleted == 'N');
			}
			makeManagers();
			dueDay();
			makeReservationBodyCeil();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function changeStatus(status){
		// NOTICE: 예약중 상태를 바꾼다.
		if(!reservationseqno || reservationseqno == '' || !status || status == '') {
			alert('상태 변경에 실패하였습니다.');
			return false;
		}

		if(status == 'C') {
			// 
			var res = reservationInfos.filter(r => r.seqno == reservationseqno);

			if(!res || res.length == 0) {
				alert('존재 하지 않는 예약입니다.');
				return false;
			}
			res = res[0];
			reservation_old_price = res.serviceInfo.price - res.discount_price;
			reIssueCoupon = res.coupon_seqno;

			var point_type = 'P';
			var price = reservation_old_price;
			var memo = '관리자 예약 취소로 인한 사용 포인트 반환 (예약번호: ['+reservationseqno+'])';
			var data = { admin_seqno:1, user_seqno:res.user_seqno, product_seqno: 0, reIssueCoupon: reIssueCoupon,
				point_type:point_type, memo:memo, amount: price, admin_name: '' };

			medibox.methods.point.collect(data, function(request1, response1){
				console.log('output : ' + response1);
				if(!response1.result){
					alert(response1.ment.replace('\\r', '\n'));
					return false;
				}
				
				medibox.methods.store.reservation.status({
					status: status
				}, reservationseqno, function(request, response){
					console.log('output : ' + response);
					if(!response.result){
						alert(response.ment);
						return false;
					}
					alert('상태가 변경되었습니다.');
					makeReservationBodyCeil();
				}, function(e){
					console.log(e);
					alert('서버 통신 에러');
				});
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});
		} else {
			medibox.methods.store.reservation.status({
				status: status
			}, reservationseqno, function(request, response){
				console.log('output : ' + response);
				if(!response.result){
					alert(response.ment);
					return false;
				}
				alert('상태가 변경되었습니다.');
				makeReservationBodyCeil();
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});
		}
	}
	// 3 선택된 매장의 모든 매니저 조회 -> list 생성
	// 4 일자, 매장으로 선택된 모든 예약정보 조회 -> 매니저별 filter 로 ceil 생성
	// 5 일자가 변경되면 4를 재실행
	function gotoMemberDetail(){
		location.href = '/admin/members/' + userseqno;
	}
	function gotoDetail(seq){
		alert('준비중입니다.');
//		location.href = '/admin/partners/'+seq;
	}
	function addItem(){
		$('.pop-header').text(' 예약 등록 ');
		$('#_reservationTargetUsers').html('');
		$('input[name=searchUserId]').val('');
		$('#_add').show();
		$('#_modify').hide();
		

		$('#partnersPop').val('');
		$('#storePop').val('');
		$('#managerPop').val('');
		$('#servicePop').val('');
		$('#use_icon_important').prop('checked', true);
		$('#use_icon_phone').prop('checked', '');
		$('#use_custom_color').prop('checked', '');
		$('#estimated_time').val('');
		$('#startDate').val('');
		$('#startTime1').val('');
		$('#startTime2').val('');
		$('#memo').val('');
		$('#status_select').hide();
		$('#btnProvisional').show();
		$('#servicePop').prop('disabled', false);

		popOpen();
	}		
    var reIssueCoupon = 0;
	function remove(seq){
		if(!confirm('정말 삭제 하시겠습니까?\n*기존 데이터는 모두 삭제됩니다.')) {
			return;
		}
		var res = reservationInfos.filter(r => r.seqno == reservationseqno);

		if(!res || res.length == 0) {
			alert('존재 하지 않는 예약입니다.');
			return false;
		}
		res = res[0];

		var point_type = 'P';
        var price = reservation_old_price;
		var memo = '관리자 예약 삭제로 인한 사용 포인트 반환 (예약번호: ['+reservationseqno+'])';
		var data = { admin_seqno:1, user_seqno:res.user_seqno, product_seqno: 0, reIssueCoupon: reIssueCoupon,
            point_type:point_type, memo:memo, amount: price, admin_name: '' };
        
        medibox.methods.point.collect(data, function(request1, response1){
            console.log('output : ' + response1);
            if(!response1.result){
				alert(response1.ment.replace('\\r', '\n'));
                return false;
			}
			
			medibox.methods.store.reservation.remove({}, seq, function(request, response){
				console.log('output : ' + response);
				if(!response.result){
					alert(response.ment);
					return false;
				}
				alert('삭제 되었습니다.');
				location.reload();
			}, function(e){
				console.log(e);
			});
        }, function(e){
            console.log(e);
            alert('서버 통신 에러');
        });	
	}
	var userInfos;
	userInfos = [];
	function modifyItem(){
		$('.pop-header').text(' 예약 수정 ');
		$('#_reservationTargetUsers').html('');
		$('input[name=searchUserId]').val('');
		
		var res = reservationInfos.filter(r => r.seqno == reservationseqno);

		if(!res || res.length == 0) {
			alert('존재 하지 않는 예약입니다.');
			return false;
		}
		res = res[0];

		// syncronized
		$('#partnersPop').val(res.partner_seqno);
		getManagersPop();
		$('#storePop').val(res.store_seqno);
		getManagersPop();
		$('#managerPop').val(res.manager_seqno);
		getServicesPop();
		$('#servicePop').val(res.service_seqno);
		// end syncronized

		$('#use_icon_important').prop('checked', res.use_icon_important == 'Y');
		$('#use_icon_phone').prop('checked', res.use_icon_phone == 'Y');
		$('#use_custom_color').prop('checked', res.use_custom_color == 'Y');
		$('#estimated_time').val(res.estimated_time);
		$('#_add').hide();
		$('#_modify').show();
		$('#servicePop').prop('disabled', true);

		reservation_old_price = res.serviceInfo.price - res.discount_price;
		reIssueCoupon = res.coupon_seqno;
		
		if(res.userInfo) {
			var bodyData = '<tr data-key="'+res.userInfo.user_seqno+'" onclick="chooseUser('+res.userInfo.user_seqno+')" style="cursor:pointer;">'
								+'	<td>'+res.userInfo.user_name+'</td>'
								+'	<td>MEDIBOX-'+res.userInfo.user_seqno+'</td>'
								+'	<td>'+res.userInfo.user_phone+'</td>'
								+'	<td><a href="#" class="btn large blue span100" onclick="gotoInfoDetail(\''+res.userInfo.user_seqno+'\')">고객정보</a></td>'
								+'</tr>';
			$('#_reservationTargetUsers').html(bodyData);
			userInfos.push(res.userInfo);
			chooseUser(res.userInfo.user_seqno);
			
			$('#resident_list').show();
			$('#provisional_resident_list').hide();
			$('#is_provisional_user').prop('checked', false);
		} else {
			$('#provisional_user_name').text(res.user_name);
			$('#provisional_user_phone').text(res.user_phone);
			$('#provisional_user_memo').text(res.user_memo);

			$('#resident_list').hide();
			$('#provisional_resident_list').show();
			isProvisional = true;
			$('#is_provisional_user').prop('checked', true);
		}

		var startTimes = res.start_dt.split(' ');
		$('#startDate').val(startTimes[0]);
		var startDetailTimes = startTimes[1].split(':');
		$('#startTime1').val(startDetailTimes[0]);
		$('#startTime2').val(startDetailTimes[1]);
		$('#memo').val(res.memo);

		$('#status_select').show();
		$('#res_status').val(res.status);

//		$('#btnProvisional').hide();

		popOpen();
	}
	
	$(document).ready(function(){
		cellHeight = $('._timeRow > .cell').height();
		popHide();
		getPartners();
		searchDate = toDate();
		findNextDate(0);
	});
	</script>

</section>

@include('admin.pop.reservation')
@include('admin.footer')
