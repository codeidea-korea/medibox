@php 
$page_title = '회원관리';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">회원관리</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">이름/아이디</div>
					<div class="wr-list-con">
						<input type="text" name="searchField" id="searchField" value="" class="span250" placeholder="이름/아이디">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">추천인 이름/추천인 아이디</div>
					<div class="wr-list-con">
						<input type="text" name="searchFieldRecommand" id="searchFieldRecommand" value="" class="span250" placeholder="추천인 이름/추천인 아이디">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">메모1</div>
					<div class="wr-list-con">
						<input type="text" name="memo" id="memo" value="" class="span250" placeholder="메모">
					</div>
					<div class="wr-list-label">메모2</div>
					<div class="wr-list-con">
						<input type="text" name="memo2" id="memo2" value="" class="span250" placeholder="메모2">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">최초추천샵</div>
					<div class="wr-list-con">
						<select class="default" name="recommended_shop" id="recommended_shop">
							<option value="">선택해주세요.</option>
							<option value="포레스타 블랙">포레스타 블랙</option>
							<option value="바라는 네일">바라는 네일</option>
							<option value="딥포커스 검안센터">딥포커스 검안센터</option>
							<option value="발몽스파">발몽스파</option>
							<option value="미니쉬 도수">미니쉬 도수</option>
							<option value="미니쉬 스파">미니쉬 스파</option>
							<option value="미니쉬 치과병원">미니쉬 치과병원</option>
							<option value="기타">기타</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">고객구분</div>
					<div class="wr-list-con">
						<select class="default" id="type">
							<option value="">선택해주세요.</option>
							<!--
							<option value="VIP">VIP</option>
							<option value="일반">일반</option>
							-->
							<option value="1. BLACK">1. BLACK</option>
							<option value="2. PLATINUM">1. PLATINUM</option>
							<option value="3. GOLD">1. GOLD</option>
							<option value="4. CLASSIC">1. CLASSIC</option>
						</select>
					</div>
					<div class="wr-list-label">방문유형</div>
					<div class="wr-list-con">
						<select class="default" id="join_path">
							<option value="">선택해주세요.</option>
							<!--
							<option value="미니쉬직원">미니쉬직원</option>
							<option value="강원장님소개">강원장님소개</option>
							<option value="미니쉬중요고객">미니쉬중요고객</option>
							<option value="주주">주주</option>
							-->
							<option value="1.미니쉬_고객">1.미니쉬_고객</option>
							<option value="1.미니쉬_중요고객">1.미니쉬_중요고객</option>
							<option value="2.라운지고객_딥포커스">2.라운지고객_딥포커스</option>
							<option value="2.라운지고객_바라는네일">2.라운지고객_바라는네일</option>
							<option value="2.라운지고객_포레스타">2.라운지고객_포레스타</option>
							<option value="3.직원_미니쉬">3.직원_미니쉬</option>
							<option value="3.직원_MMC">3.직원_MMC</option>
							<option value="4.소개_직원">4.소개_직원</option>
							<option value="4.소개_고객">4.소개_고객</option>
							<option value="4.소개_국장님">4.소개_국장님</option>
							<option value="4.소개_강원장님">4.소개_강원장님</option>
							<option value="5.기타_MOU">5.기타_MOU</option>
							<option value="5.기타_체험단">5.기타_체험단</option>
							<option value="5.기타_일반문의">5.기타_일반문의</option>
							<option value="5.기타_테크주주">5.기타_테크주주</option>
							<option value="5.기타_바우처구매">5.기타_바우처구매</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">최종 예약일</div>
					<div class="wr-list-con">
						<a href="#" onclick="setReservateDay(this, 0)" class="btn _dayOption2 gray">오늘</a>
						<a href="#" onclick="setReservateDay(this, -7)" class="btn _dayOption2 gray">1주</a>
						<a href="#" onclick="setReservateDay(this, -30)" class="btn _dayOption2 gray">1개월</a>
						<a href="#" onclick="setReservateDay(this, -180)" class="btn _dayOption2 gray">6개월</a>
						<a href="#" onclick="setReservateDay(this, -365)" class="btn _dayOption2 gray">1년</a>
						<input type="text" id="_startReservateAt" class="datepick _startReservateAt">			
						~
						<input type="text" id="_endReservateAt" class="datepick _endReservateAt">		
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">회원 가입일</div>
					<div class="wr-list-con">
						<a href="#" onclick="setDay(this, 0)" class="btn _dayOption gray">오늘</a>
						<a href="#" onclick="setDay(this, -7)" class="btn _dayOption gray">1주</a>
						<a href="#" onclick="setDay(this, -30)" class="btn _dayOption gray">1개월</a>
						<a href="#" onclick="setDay(this, -180)" class="btn _dayOption gray">6개월</a>
						<a href="#" onclick="setDay(this, -365)" class="btn _dayOption gray">1년</a>
						<input type="text" id="_start" class="datepick _start">			
						~
						<input type="text" id="_end" class="datepick _end">		
					</div>
				</div>
			</div>

			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
				<a href="#" onclick="excelDownload()" class="btn green small icon-excel">엑셀 다운로드</a>
				<a href="/admin/point/conf" class="btn green small icon-add">포인트 자동 적립 관리</a>
			</div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="90">
				<col width="60">
				<col width="140">
				<col width="60">

				<col width="140">
				<col width="160">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
			</colgroup>
			<thead>
				<tr>
					<th><a href="#">번호</a></th>
					<th><a href="#">최종예약일</a></th>
					<th><a href="#">최초추천샵</a></th>
					<th><a href="#">회원명</a></th>
					<th><a href="#">아이디</a></th>
					<th><a href="#">방문유형</a></th>
					<th><a href="#">고객구분</a></th>
					
					<th><a href="#">추천인아이디</a></th>
					<th><a href="#">추천인</a></th>
					<th><a href="#">결제구분</a></th>

					<th><a href="#">회원가입일</a></th>
					<th><a href="#">고객메모1</a></th>
					<th><a href="#">고객메모2</a></th>
					<th>수정</th>
				</tr>
			</thead>

			<tbody class="_tableBody">
				<tr>
					<td>1</td>
					<td>010-0000-0000</td>
					<td>홍길동</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>100,000 P</td>
					<td>통합정액권 1,000,000</td>
					<td></td>
					<td><a href="#" class="btnEdit">수정</a></td>
				</tr>
				<tr>
					<td>2</td>
					<td>010-0000-0000</td>
					<td>홍길동</td>
					<td class="date">탈퇴</td>
					<td>100,000 P</td>
					<td></td>
					<td></td>
					<td><a href="#" class="btnEdit">수정</a></td>
				</tr>
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
			<a href="#" class="pg_btn">6</a>
			<a href="#" class="pg_btn">7</a>
			<a href="#" class="pg_btn">8</a>
			<a href="#" class="pg_btn">9</a>
			<a href="#" class="pg_btn">10</a>
			<a href="#" class="pg_btn next"></a>
			<a href="#" class="pg_btn last"></a>
		</nav>

		<div class="btnSet">
			<a href="#" onclick="addUser()" class="btn large">회원등록</a>
		</div>
	</div>	
	
	<script>	
	var pageNo = 1;
	var pageSize = 10;
	
	var startDay = '';
	var endDay = '';
	var startReservateDay = '';
	var endReservateDay = '';

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

	$('._startReservateAt').datepicker({
		language: 'ko-KR',
		autoPick: false,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		startReservateDay = $(this).val();
	});
	$('._endReservateAt').datepicker({
		language: 'ko-KR',
		autoPick: false,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		endReservateDay = $(this).val();
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
		$(".datepick._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._end").datepicker('setDate', toDateFormatt(date.getTime()));
	}
	function setReservateDay(target, terms) {
		var date = new Date();
		date.setDate(date.getDate() + 1);
		var prevDate = new Date();
		prevDate.setDate(prevDate.getDate() + terms);
		$("._dayOption2").removeClass('gray');
		$("._dayOption2").addClass('gray');
		$(target).removeClass('gray');
		$(".datepick._startReservateAt").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._endReservateAt").datepicker('setDate', toDateFormatt(date.getTime()));
	}

	function wait(){
		alert('준비중입니다.');
	}
	function loadList(no) {
		pageNo = no;
		getList();
	}
	function enterkey() {
		if (window.event.keyCode == 13) {
			loadList(1);
		}
	}
	function viewUserInfo(row){
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
	function getList(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchField]').val();
		
		var memo = $('#memo').val();
		var memo2 = $('#memo2').val();
		var type = $('#type').val();
		var join_path = $('#join_path').val();
		
		var recommended_shop = $('#recommended_shop').val();
		var searchFieldRecommand = $('#searchFieldRecommand').val();

		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		if(startDay && startDay != '') {
			data.start_day = startDay.replace('.', '-').replace('.', '-');
		}
		if(endDay && endDay != '') {
			data.end_day = endDay.replace('.', '-').replace('.', '-');
		}
		if(searchField && searchField != '') {
			data.search = searchField;
		}
		if(memo && memo != '') {
			data.memo = memo;
		}
		if(memo2 && memo2 != '') {
			data.memo2 = memo2;
		}
		if(type && type != '') {
			data.type = type;
		}
		if(join_path && join_path != '') {
			data.join_path = join_path;
		}
		if(recommended_shop && recommended_shop != '') {
			data.recommended_shop = recommended_shop;
		}
		if(searchFieldRecommand && searchFieldRecommand != '') {
			data.searchFieldRecommand = searchFieldRecommand;
		}
		
		if(startReservateDay && startReservateDay != '') {
			data.startReservateDay = startReservateDay;
		}
		if(endReservateDay && endReservateDay != '') {
			data.endReservateDay = endReservateDay;
		}

		medibox.methods.user.members(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			// _tableBody
			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="14" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
			for(var inx=0; inx<response.data.length; inx++){
				var no = (response.count - (request.pageNo - 1)*pageSize) - inx;
				var pointsDescription = '';
				/*
				if(response.data[inx].points.length < 1) {
					try{
						throw ('정상적으로 가입되지 않은 고객입니다.');
					}catch(e){
						console.error(e);
						continue;
					}
				}
				for(var jnx=0; jnx<response.data[inx].points.length; jnx++){
					if(response.data[inx].points[jnx].point_type == 'K' || response.data[inx].points[jnx].point_type == 'P') continue;

					pointsDescription = (pointsDescription != '' ? pointsDescription + '<br>' : '') 
						+ getPointType(response.data[inx].points[jnx].point_type) + '정액권 ' + medibox.methods.toNumber(response.data[inx].points[jnx].point) + ' P';
				}
				*/
				bodyData = bodyData 
				/*
							+'<tr style="cursor:pointer;" data-key="'+response.data[inx].user_seqno+'">'
							+'	<td>'+no+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>'+(response.data[inx].delete_yn == 'Y' ? '탈퇴' : response.data[inx].create_dt)+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].points.filter(a => a.point_type == 'P')[0].point)+' P</td>'
							+'	<td>'+pointsDescription+'</td>' 
							+'	<td>'+medibox.methods.toNumber((response.data[inx].packageHistory ? response.data[inx].packageHistory.point : 0))+' P</td>'
							+'	<td data-action-type="none"><a href="#" onclick="gotoInfoDetail(\''+response.data[inx].user_seqno+'\')" class="btnEdit">수정</a></td>'
							+'</tr>';
							*/
							+'<tr style="cursor:pointer;" data-key="'+response.data[inx].user_seqno+'">'
							+'	<td>'+no+'</td>'
							+'	<td>'+safetyNull(response.data[inx].lastReservation ? response.data[inx].lastReservation.start_dt : '-')+'</td>'
							+'	<td>'+safetyNull(response.data[inx].recommended_shop)+'</td>'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td>'+safetyNull(response.data[inx].join_path)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].type)+'</td>'

							+'	<td>'+safetyNull(response.data[inx].recommended_code)+'</td>'
							+'	<td>'+safetyNull((response.data[inx].recommendedUser ? response.data[inx].recommendedUser.user_name : '-'))+'</td>'
							+'	<td>'+safetyNull(response.data[inx].product_type)+'</td>' // NOTICE: 결제 구분 정의 질의

							+'	<td>'+(response.data[inx].delete_yn == 'Y' ? '탈퇴' : response.data[inx].create_dt)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].memo)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].memo2)+'</td>'
							+'	<td data-action-type="none"><a href="#" onclick="gotoInfoDetail(\''+response.data[inx].user_seqno+'\')" class="btnEdit">수정</a></td>'
							+'</tr>';
				
			}
			$('._tableBody').html(bodyData);
			$('._tableBody > tr > td').not('._tableBody > tr > td[data-action-type=none]').off().on('click', viewUserInfo);

			if(response.count > 0)
			{
				var totSize = response.count;
				var totPagePt = Math.ceil(totSize / pageSize);
				var pageStt = (Math.ceil(request.pageNo/pageSize)-1)*pageSize +1;
				var pageEnd = Math.ceil(request.pageNo/pageSize)*pageSize;
				pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
				var eventName = 'onclick'; var pageTmp = '';
				
				pageTmp+= '<nav class="pg_wrap">'
						+'    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadList(1)"' : '')+'></a>'
						+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadList('+(pageStt-1)+')"' : '')+'></a>';
				for(var inx=pageStt; inx <= pageEnd; inx++)
				{
					pageTmp+='<a href="#" class="pg_btn '+(inx == request.pageNo ? 'active' : '')+'" '+eventName+'="loadList('+(inx)+')">'+(inx)+'</a>';
				}
				pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadList('+(pageEnd+1)+')"' : '')+'></a>'
						+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadList('+(totPagePt)+')"' : '')+'></a>'
						+'</nav>';

				$('.pg_wrap').html(pageTmp);
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getPointType(type){
		switch(type){
			case 'S1':
				return '통합';
			case 'S2':
				return '네일';
			case 'S3':
				return '발몽';
			case 'S4':
				return '포레스타';
			case 'P':
				return '포인트';
			case 'K':
				return '패키지';
			default:
				return '-';
		}
	}
	function gotoDetail(seq){
		location.href = '/admin/members/'+seq+'/infos';
	}
	function gotoInfoDetail(seq){
		location.href = '/admin/members/'+seq;
	}		
	function addUser(){
		location.href = '/admin/members/0';
	}
	function excelDownload(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchField]').val();
		
		var url = '/admin/members-download/excel?';

		if(startDay && startDay != '') {
			url = url + 'start_day=' + startDay.replace('.', '-').replace('.', '-') + '&';
		}
		if(endDay && endDay != '') {
			url = url + 'end_day=' + endDay.replace('.', '-').replace('.', '-') + '&';
		}
		if(searchField && searchField != '') {
			url = url + 'search=' + searchField + '&';
		}

		window.open(url);
	}
	function safetyNull(str) {
		return !str ? '-' : str;
	}
	
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
