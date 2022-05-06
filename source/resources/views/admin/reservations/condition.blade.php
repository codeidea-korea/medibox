@php 
$page_title = '예약 현황';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">예약 현황</div>
	
	<div id="bookingContainer">
		<section class="topCon">
			<div class="dateSet">
				<button class="prev" onclick="findNextDate(-1)"></button>
				<input type="text" id="current_date" class="datepick">			
				<button class="next" onclick="findNextDate(1)"></button>
				<label for="current_date" class="calendar"></label>
			</div>
			<div class="btnSet">
				<a href="/admin/reservations" class="btn-list">예약내역</a>
				<a href="#" onclick="popOpen()" class="btn-write">예약등록</a>
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
				<a href="#" class="btn-day _reservationSearchDate">일<br>3/6</a>
				<a href="#" class="btn-day _reservationSearchDate">월<br>3/7</a>
				<a href="#" class="btn-day _reservationSearchDate active">화<br>3/8</a>
				<a href="#" class="btn-day _reservationSearchDate">수<br>3/9</a>
				<a href="#" class="btn-day _reservationSearchDate">목<br>3/10</a>
				<a href="#" class="btn-day _reservationSearchDate">금<br>3/11</a>
				<a href="#" class="btn-day _reservationSearchDate">토<br>3/12</a>
				<div class="navigation">
					<button class="prev" onclick="findNextDate(-7)"></button>
					<button class="next" onclick="findNextDate(7)"></button>
				</div>
				<a href="#" class="btn-setting" onclick="gotoConfig()">설정</a>
			</div>

			<div class="tableChart">
				
				<div class="leftContainer">
					<div class="col" id="storeOpendTime">

					</div>
				</div>

				<div class="bodyContainer">
					<div class="head">
						<div class="inner" style="width: 2182px;">
							<div class="row" id="_managers">

							</div>
						</div>
					</div>
				
					<div class="body">					
						<div class="inner" style="width: 2176px;" id="_reservateTime">
							
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

	var layer_select3 = '<ul class="layerSelect">';
	layer_select3 += '<li><a href="#" class="active">예약완료</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'E\')">고객입장</a></li>';
	layer_select3 += '<li><a href="#" onclick="wait()">예약수정</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'C\')">예약취소</a></li>';
	layer_select3 += '<li><a href="#" onclick="changeStatus(\'N\')">예약불이행</a></li>';
	layer_select3 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select3 += '</ul>';

	var layer_select4 = '<ul class="layerSelect">';
	layer_select4 += '<li><a href="#" class="active">고객입장</a></li>';
	layer_select4 += '<li><a href="#" onclick="changeStatus(\'D\')">서비스완료</a></li>';
	layer_select4 += '<li><a href="#" onclick="wait()">예약수정</a></li>';
	layer_select4 += '<li><a href="#" onclick="changeStatus(\'R\')">입장취소</a></li>';
	layer_select4 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select4 += '</ul>';

	var layer_select5 = '<ul class="layerSelect">';
	layer_select5 += '<li><a href="#" class="active">서비스완료</a></li>';
	layer_select5 += '<li><a href="#" onclick="wait()">예약수정</a></li>';
	layer_select5 += '<li><a href="#" onclick="changeStatus(\'E\')">완료취소</a></li>';
	layer_select5 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select5 += '</ul>';

	var layer_select6 = '<ul class="layerSelect">';
	layer_select6 += '<li><a href="#" class="active">예약불이행</a></li>';
	layer_select6 += '<li><a href="#" onclick="changeStatus(\'R\')">불이행취소</a></li>';
	layer_select6 += '<li><a href="#" onclick="gotoMemberDetail()">고객정보</a></li>';
	layer_select6 += '</ul>';

	$('html').click(function(e) {
		if(!$(e.target).hasClass("cell")) {
			$('.cell .layerSelect').remove();
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

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			/*
			var bodyData = '<a href="#" '+(partnerId && partnerId != '' ? 'class="active"' : '')+'>전체</a>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<a href="#" '
						+(response.data[inx].seqno == partnerId ? 'class="active"' : '')+' onclick="getStores('+response.data[inx].seqno+')">'
							+response.data[inx].cop_name +
					'</a>';
			}
			$('#_partners').html(bodyData);
			*/
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			partners = response.data;
			getStores(partnerId);
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
			if(code == inx) {
				$($('._reservationSearchDate')[inx]).addClass('active');
			}
		}
		$('#current_date').val(toDateFormatt3(toDate));
	}
	var searchDate = toDate();
	function findNextDate(pt){
		var targetDay = new Date(searchDate);
		targetDay.setDate(targetDay.getDate() + pt);
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
		if(!stores || !stores.managerInfo) {
			alert('해당 매장에는 예약 가능한 직원이 없습니다. 먼저 예약 가능한 직원을 등록해주세요.');
			return false;
		}
		var bodyData = '';
		if(stores.managerInfo.length){
			for(var inx=0; inx<stores.managerInfo.length; inx++){
				bodyData = bodyData + '<span class="cell">'+stores.managerInfo[inx].manager_type + ' ' + stores.managerInfo[inx].name+'</span>';
			}
		} else {
			bodyData = bodyData + '<span class="cell">'+stores.managerInfo.manager_type + ' ' + stores.managerInfo.name+'</span>';
		}
		loadStoreConfig();
		$('#_managers').html(bodyData);
	}
	function addEventCeil(){
		$('.tableChart .body .cell').click(function() {
			$('.cell .layerSelect').remove();
			
			if($(this).hasClass("label-3")) {
				$(this).html(layer_select3);
			} else if($(this).hasClass("label-4")) {
				$(this).html(layer_select4);
			} else if($(this).hasClass("label-5")) {
				$(this).html(layer_select5);
			} else if($(this).hasClass("label-6")) {
				$(this).html(layer_select6);
			}
		});
	}
	function dueDay(){
		// NOTICE: fake Time
		stores.conf = {
			dueDay: {
				startTime: '10:00',
				endTime: '15:00'
			}
		};
		
		var startTime = new Date(searchDate);
		startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
		startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);
		
		var endTime = new Date(searchDate);
		endTime.setHours(stores.conf.dueDay.endTime.split(':')[0]);
		endTime.setMinutes(stores.conf.dueDay.endTime.split(':')[1]);

		var bodyData = '';
		while(startTime.getTime() < endTime.getTime()){
			bodyData = bodyData + '<span class="cell">'+startTime.getHours()+':'+(startTime.getMinutes() < 10 ? '0'+startTime.getMinutes() : startTime.getMinutes())+'</span>';
			startTime.setMinutes(startTime.getMinutes() + timeGap);
		}
		$('#storeOpendTime').html(bodyData);
		
		bodyData = '';
		if(stores.managerInfo) {
			if(stores.managerInfo.length){
				for(var inx=0; inx<stores.managerInfo.length; inx++){
					bodyData = bodyData + '<div class="col _timeRow" data-alt="'+stores.managerInfo[inx].name+'" data-key="'+stores.managerInfo[inx].seqno+'">';

					var startTime = new Date(searchDate);
					startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
					startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);

					while(startTime.getTime() < endTime.getTime()){
						bodyData = bodyData + '<span class="cell " data-start="'+startTime.getHours()+':'+startTime.getMinutes()+'"></span>'; // 예약이 없는 시간에는 기본값 세팅
						startTime.setMinutes(startTime.getMinutes() + timeGap);
					}
					bodyData = bodyData + '</div>';
				}
			} else {
				bodyData = bodyData + '<div class="col _timeRow" data-alt="'+stores.managerInfo.name+'" data-key="'+stores.managerInfo.seqno+'">';

				var startTime = new Date(searchDate);
				startTime.setHours(stores.conf.dueDay.startTime.split(':')[0]);
				startTime.setMinutes(stores.conf.dueDay.startTime.split(':')[1]);

				while(startTime.getTime() < endTime.getTime()){
					bodyData = bodyData + '<span class="cell " data-start="'+startTime.getHours()+':'+startTime.getMinutes()+'"></span>'; // 예약이 없는 시간에는 기본값 세팅
					startTime.setMinutes(startTime.getMinutes() + timeGap);
				}
				bodyData = bodyData + '</div>';
			}
		}
		$('#_reservateTime').html(bodyData);
	}
	let partnerseqno;
	let storeseqno;
	let reservationseqno = 0;
	let userseqno = 0;
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
			for(var inx=0; inx<response.data.length; inx++){
				// custom_color
				var startTime = response.data[inx].start_dt.split(' ')[1].substring(0, 5);
				var countColor = Number(response.data[inx].estimated_time.split(':')[0]) * 6 + Number(response.data[inx].estimated_time.split(':')[1]) / 10;
				
				var timeCeils = $('._timeRow[data-key='+stores.managerInfo[inx].seqno+'] > span');
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
					barCaption = 'label-4';
				}
				else if(status == 'D'){
					barCaption = 'label-5';
				}
				else if(status == 'N'){
					barCaption = 'label-6';
				}

				for(var jnx=1; jnx <= countColor; jnx++){
					if(jnx == 1) {
						// 첫행에는 이모티콘 옵션 부여
						let reservationBoxText = '';
						if(response.data[inx].use_icon_important == 'Y') {
							reservationBoxText = reservationBoxText + ' ★';
						} 
						if(response.data[inx].use_icon_phone == 'Y') {
							reservationBoxText = reservationBoxText + ' ☏';
						} 
						$(timeCeils[targetIdx + jnx]).text(reservationBoxText + ' ' + response.data[inx].userInfo.user_name + ' 고객님');
					}
					$(timeCeils[targetIdx + jnx]).attr('data-reservation-id', response.data[inx].seqno);
					$(timeCeils[targetIdx + jnx]).attr('data-user-id', response.data[inx].user_seqno);
					$(timeCeils[targetIdx + jnx]).addClass(barCaption);
					$(timeCeils[targetIdx + jnx]).on('click', function(){
						userseqno = $(this).attr('data-user-id');
						reservationseqno = $(this).attr('data-reservation-id');
					});
				}
			}
			let len = 1;
			if(stores.managerInfo && stores.managerInfo.length){
				len = stores.managerInfo.length;
			}
			$('#_reservateTime').width(140 * len);
			$('#_managers').parent().width(140 * len);
			
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
		// 2. 결과를 바탕으로 세팅정보의 근무시간내 예약을 표로 생성
		// 3. 상태별 알럿이 다르게 노출
		// 4. 
		addEventCeil();
	}
	var isOnce = false;
	function getStores(partner_seqno, id){
		partnerseqno = partner_seqno;
		storeseqno = id;
		var data = { partner_seqno:partner_seqno, id: id, adminSeqno:{{ $seqno }} };

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			if(!isOnce) {
				isOnce = true;
				var bodyData = '<a href="#" '+(id && id != '' ? 'class="active"' : '')+' onclick="getStores(null, null)">전체</a>';
				for(var inx=0; inx<response.data.length; inx++){
					bodyData = bodyData 
						+'<a href="#" '
							+(response.data[inx].seqno == id ? 'class="active"' : '')+' onclick="getStores(null, '+response.data[inx].seqno+')">'
								+response.data[inx].name +
						'</a>';
				}
				$('#_store').html(bodyData);
			}
			stores = response.data;
			if(stores.length) {
				stores.managerInfo = stores.map(store => store.managerInfo).filter(manageInfo => manageInfo != null);
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
		alert('준비중입니다.');
//		location.href = '/admin/partners/0';
	}		
	function remove(seq){
		if(!confirm('정말 삭제 하시겠습니까?\n*기존 데이터는 모두 삭제됩니다.')) {
			return;
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
	}
	
	$(document).ready(function(){
		popHide();
		getPartners();
		searchDate = toDate();
		findNextDate(0);
	});
	</script>

</section>

@include('admin.pop.reservation')
@include('admin.footer')
