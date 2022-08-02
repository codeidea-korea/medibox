@php 
$page_title = '정산 내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">정산 내역</div>
	
	<div class="data-search-wrap">
		<div class="data-sel" style="width:100%;">
			<div class="wr-list">
				<div class="wr-list-label">이름/아이디</div>
				<div class="wr-list-con">
					<input type="text" name="searchField" id="searchField" value="" class="span250" placeholder="이름/아이디">
				</div>
			</div>
		</div>
		<div class="data-sel" style="width:100%;">
			<div class="wr-list">
				<div class="wr-list-label">추천인 이름/추천인 아이디</div>
				<div class="wr-list-con">
					<input type="text" name="searchFieldRecommand" id="searchFieldRecommand" value="" class="span250" placeholder="추천인 이름/추천인 아이디">
				</div>
			</div>
		</div>
		<div class="data-sel" style="width:100%;">
			<div class="wr-list-label">결제 메모</div>
			<div class="wr-list-con">
				<input type="text" name="memo" id="memo" value="" class="span250" placeholder="메모">
			</div>
		</div>
		<div class="data-sel" style="width:100%;">
			<div class="wr-list-label">예약 메모</div>
			<div class="wr-list-con">
				<input type="text" name="memo2" id="memo2" value="" class="span250" placeholder="메모2">
			</div>
		</div>

		<div class="data-sel" style="width:100%;">
			매장&nbsp;&nbsp;&nbsp;&nbsp;
			<select id="store_seqno" class="default">
				<option value="">선택해주세요.</option>
			</select>		
		</div>	
		<div class="data-sel" style="width:100%;">
			서비스 구분 > 결제 종류&nbsp;&nbsp;&nbsp;&nbsp;
			<select id="service_type" class="default">
				<option value="">전체</option>
				<option value="F">정액권</option>
				<option value="K">패키지</option>
				<option value="M">멤버쉽</option>
				<option value="V">바우처</option>
				<option value="R">예약</option>
			</select>
		</div>
		<!--
		<div class="data-sel" style="width:100%;">
			사용 구분&nbsp;&nbsp;&nbsp;&nbsp; 
			<label class="radio-wrap"><input type="radio" name="hst_type" value="" checked="checked"><span></span>전체</label>
			<label class="radio-wrap"><input type="radio" name="hst_type" value="S"><span></span>충전</label>
			<label class="radio-wrap"><input type="radio" name="hst_type" value="R"><span></span>환불</label>
			<label class="radio-wrap"><input type="radio" name="hst_type" value="U"><span></span>사용</label>
			<label class="radio-wrap"><input type="radio" name="hst_type" value="RD"><span></span>예약</label>
			<label class="radio-wrap"><input type="radio" name="hst_type" value="RC"><span></span>예약취소</label>
		</div>
		<div class="data-sel" style="width:100%;">
			고객 이름&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text" id="user_name" class="span250">
		</div>
		-->
		<div class="data-sel" style="width:100%;">
			결제일&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="#" onclick="setDay(this, 0)" class="btn _dayOption gray">오늘</a>
			<a href="#" onclick="setDay(this, -7)" class="btn _dayOption gray">1주</a>
			<a href="#" onclick="setDay(this, -30)" class="btn _dayOption gray">1개월</a>
			<a href="#" onclick="setDay(this, -180)" class="btn _dayOption gray">6개월</a>
			<a href="#" onclick="setDay(this, -365)" class="btn _dayOption gray">1년</a>

			<input type="text" id="_start" value="" class="span130 datepicker _start" data-label="날짜">
			&nbsp;&nbsp;~
			<input type="text" id="_end" value="" class="span130 datepicker _end" data-label="날짜">

			<a href="#" class="btn gray" onclick="getList()">검색</a>				
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption"><span style="font-weight:bold;font-size:16px;">매장정산내역</span>&nbsp;&nbsp;총 <b id="totalCnt">11</b>개 글이 있습니다</div>
			<!-- <div class="rightSet"><a href="#" class="btn green small icon-excel">엑셀 다운로드</a></div> -->
		</div>
		<table>
			<colgroup>
				<col>
				<col width="100">
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
				<col>
			</colgroup>
			<thead>
				<tr>
					<th><a href="#">최종예약일</a></th>
					<th><a href="#">매장명</a></th>
					<th><a href="#">회원ID</a></th>
					<th><a href="#">고객명</a></th>
					<th><a href="#">최초방문경로</a></th>
					<th><a href="#">고객구분</a></th>
					<th><a href="#">추천인아이디</a></th>
					<th><a href="#">추천인</a></th>
					<th><a href="#">서비스구분</a></th>
					<th><a href="#">결제일</a></th>
					<th><a href="#">결제종류</a></th>
					<th><a href="#">결제금액</a></th>
					<th><a href="#">P차감금액</a></th>
					<th><a href="#">P잔액</a></th>
				</tr>
			</thead>

			<tbody class="_tableBody">

			</tbody>			
		</table>

	</div>	
	
	<script>	
	var store_seqno;

	function wait(){
		alert('준비중입니다.');
	}
	var startDay = '';
	var endDay = '';
	
	$('._start').datepicker({
		language: 'ko-KR',
		autoPick: false,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		startDay = $(this).val();
	});
	$('._end').datepicker({
		language: 'ko-KR',
		autoPick: false,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		endDay = $(this).val();
	});

	function toDateFormatt(times){
		var thisDay = new Date(times);
		return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
	}
	function setDay(target, terms) {
		var date = new Date();
		date.setDate(date.getDate() + 1);
		var prevDate = new Date();
		prevDate.setDate(prevDate.getDate() + terms);
		$("._dayOption").removeClass('gray');
		$("._dayOption").addClass('gray');
		$(target).removeClass('gray');
		$(".datepicker._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepicker._end").datepicker('setDate', toDateFormatt(date.getTime()));
	}

	function enterkey() {
		if (window.event.keyCode == 13) {
			getList();
		}
		return false;
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
	function getDateType(code){
		if(code >= 365) {
			return Math.round(code / 365) + '년';
		} else if(code >= 30) {
			return Math.round(code / 30) + '개월';
		} else if(code >= 7) {
			return Math.round(code / 7) + '주';
		} else if(code == 0) {
			return '제한 없음';
		}
		return code + '일';
	}
	function getList(){
		var store_seqno = $('#store_seqno').val();
		var service_type = $('#service_type').val();
		var user_name = $('#user_name').val();
		var hst_type = $('input[name=hst_type]:checked').val();
		
		var searchField = $('#searchField').val();
		var searchFieldRecommand = $('#searchFieldRecommand').val();
		var memo = $('#memo').val();
		var memo2 = $('#memo2').val();
		
		var data = { adminSeqno:{{ $seqno }}, include_discontinued: 'Y' };

		if(store_seqno && store_seqno != '') {
			data.store_seqno = store_seqno;
		}
		if(service_type && service_type != '') {
			data.service_type = service_type;
		}
		if(user_name && user_name != '') {
			data.user_name = user_name;
		}
		if(hst_type && hst_type != '') {
			data.hst_type = hst_type;
		}
		if(startDay && startDay != '') {
			data.start_dt = startDay + ' 00:00:00';
		}
		if(endDay && endDay != '') {
			data.end_dt = endDay + ' 23:59:59';
		}
		if(searchField && searchField != '') {
			data.searchField = searchField;
		}
		if(searchFieldRecommand && searchFieldRecommand != '') {
			data.searchFieldRecommand = searchFieldRecommand;
		}
		if(memo && memo != '') {
			data.memo = memo;
		}
		if(memo2 && memo2 != '') {
			data.memo2 = memo2;
		}

		@php
		if(session()->get('admin_type') == 'P') {
//			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
//			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.point.calculate(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			var items = [];
			items = (response.pointHistory ? items.concat(response.pointHistory) : items);
			items = (response.membershipHistory ? items.concat(response.membershipHistory) : items);
			items = (response.voucherHistory ? items.concat(response.voucherHistory) : items);
			items = (response.couponHistory ? items.concat(response.couponHistory) : items);
			items = (response.reservationHistory ? items.concat(response.reservationHistory) : items);			

			$('#totalCnt').text( medibox.methods.toNumber(items.length) );

			if(items.length == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="14" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				return;
			}

			items.sort(function(a, b) { 
				return a.create_dt > b.create_dt ? -1 : 1;
			});

			var bodyData = '';
			var totalCost = 0;
			var salesCost = 0;
			var purchaseCost = 0;
			for(var inx=0; inx<items.length; inx++){
				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+safetyNull(items[inx].last_reservation_start_dt)+'</td>'
							+'	<td>'+safetyNull(items[inx].store_name)+'</td>'
							+'	<td'
								+ (items[inx].user_seqno 
									? ' onclick="medibox.methods.userPage('+items[inx].user_seqno+')" style="cursor: pointer;">' 
									: '>' 
								) + safetyNull(items[inx].user_phone)+'</td>'
							+'	<td'
								+ (items[inx].user_seqno 
									? ' onclick="medibox.methods.userPage('+items[inx].user_seqno+')" style="cursor: pointer;">' 
									: '>' 
								) + safetyNull(items[inx].user_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].join_path)+'</td>'
							+'	<td>'+safetyNull(items[inx].type)+'</td>'
							+'	<td'
								+ (items[inx].recommand_user_seqno 
									? ' onclick="medibox.methods.userPage('+items[inx].recommand_user_seqno+')" style="cursor: pointer;">' 
									: '>' 
								) + safetyNull(items[inx].recommand_user_phone)+'</td>'
							+'	<td'
								+ (items[inx].recommand_user_seqno 
									? ' onclick="medibox.methods.userPage('+items[inx].recommand_user_seqno+')" style="cursor: pointer;">' 
									: '>' 
								) + safetyNull(items[inx].recommand_user_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].service_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].create_dt)+'</td>'
							+'	<td>'+getPointTypeFullName(items[inx].point_type)+'</td>'
							+'	<td>'+medibox.methods.toNumber(items[inx].price)+'</td>'
							+'	<td>'+getCalculateCodeByHstType(items[inx].hst_type)+medibox.methods.toNumber(items[inx].price)+'</td>'
							+'	<td>'+medibox.methods.toNumber(items[inx].user_remain_point)+'</td>'
/*

							+'	<td onclick="medibox.methods.userPage('+items[inx].user_seqno+')" style="cursor: pointer;">'+items[inx].user_seqno+'</td>'
							+'	<td>'+getPointTypeFullName(items[inx].point_type)+'</td>'
							+'	<td>'+getHstType(items[inx].hst_type)+'</td>'
							+'	<td>'+safetyNull(items[inx].store_name)+'</td>'
							+'	<td'+(items[inx].admin_name ? '' : ' onclick="medibox.methods.userPage('+items[inx].user_seqno+')" style="cursor: pointer;"')+'>'+(items[inx].admin_name ? items[inx].admin_name : items[inx].user_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].store_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].service_name)+'</td>'
							+'	<td>'+safetyNull(items[inx].start_dt)+'</td>'
							+'	<td>'+safetyNull(items[inx].create_dt)+'</td>'
							+'	<td>'+getCalculateCodeByHstType(items[inx].hst_type)+medibox.methods.toNumber(items[inx].price)+'</td>'
							*/
							+'</tr>';
				var price = calculateCodeByHstType(items[inx].hst_type, items[inx].price);
				if(price > 0) {
					salesCost = salesCost + price;
				} else {
					purchaseCost = purchaseCost + price;
				}
				totalCost = totalCost + price;
			}
			bodyData = bodyData +'<tr><td>매입</td><td colspan="12">&nbsp;</td><td>'+medibox.methods.toNumber(purchaseCost)+'</td></tr>';
			bodyData = bodyData +'<tr><td>매출</td><td colspan="12">&nbsp;</td><td>'+medibox.methods.toNumber(salesCost)+'</td></tr>';
			bodyData = bodyData +'<tr><td>총계</td><td colspan="12">&nbsp;</td><td>'+medibox.methods.toNumber(totalCost)+'</td></tr>';

			$('._tableBody').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function safetyNull(str) {
		return !str ? '-' : str;
	}
	function getPointTypeFullName(type){
		switch(type){
			case 'S1':
				return '통합 정액권';
			case 'S2':
				return '네일 정액권';
			case 'S3':
				return '발몽 정액권';
			case 'S4':
				return '포레스타 정액권';
			case 'P':
				return '포인트';
			case 'K':
				return '패키지';
			default:
				return type;
		}
	}
	function getHstType(type){
		switch(type){
			case 'U':
				return '사용';
			case 'S':
				return '충전';
			case 'R':
				return '환불';
			default:
				return type;
		}
	}
	function getCalculateCodeByHstType(type){
		switch(type){
			case 'U':
			case '예약':
			case 'R':
				return '-';
			case 'S':
			case '예약취소':
				return '+';
			default:
				return type;
		}
	}
	function calculateCodeByHstType(type, price){
		switch(type){
			case 'U':
			case '예약':
			case 'R':
				return price * -1;
			case 'S':
			case '예약취소':
				return price;
			default:
				return price;
		}
	}
	function getStoresPop(){
		var data = { adminSeqno:{{ $seqno }} };
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
			$('#store_seqno').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	$(document).ready(function(){
		getStoresPop();
		getList();
	});
	</script>

</section>

@include('admin.footer')
