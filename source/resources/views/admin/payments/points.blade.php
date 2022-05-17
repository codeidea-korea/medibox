@php 
$page_title = '포인트 사용내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">포인트 사용내역</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">회원 아이디</div> 
					<div class="wr-list-con">
						<input type="text" name="user_phone" id="id" value="" class="span250" onkeyup="enterkey()" placeholder="회원 아이디를 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">회원 이름</div> 
					<div class="wr-list-con">
						<input type="text" name="user_name" id="name" value="" class="span250" onkeyup="enterkey()" placeholder="회원 이름을 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">회원 번호</div> 
					<div class="wr-list-con">
						<input type="text" name="user_seqno" id="no" value="" class="span250" onkeyup="enterkey()" placeholder="회원 번호를 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">기간</div>
					<div class="wr-list-con">
						<a href="#" onclick="setDay(0)" class="btn">오늘</a>
						<a href="#" onclick="setDay(-7)" class="btn">1주</a>
						<a href="#" onclick="setDay(-30)" class="btn">1개월</a>
						<a href="#" onclick="setDay(-180)" class="btn">6개월</a>
						<a href="#" onclick="setDay(-365)" class="btn">1년</a>
						<input type="text" id="_start" class="datepick _start">			
						~
						<input type="text" id="_end" class="datepick _end">		
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">결제 종류</div>
					<div class="wr-list-con">
						<select class="default" id="point_type">
							<option value="">선택해주세요.</option>
							<option value="P">포인트</option>
							<option value="K">패키지</option>
							<option value="S1">통합</option>
							<option value="S2">바라는 네일</option>
							<option value="S3">발몽스파</option>
							<option value="S4">포레스타 블랙</option>
							<option value="S5">딥포커스 검안센터</option>
							<option value="S6">미니쉬 스파</option>
							<option value="S7">미니쉬 도수</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">결제 형태</div>
					<div class="wr-list-con">
						<label class="radio-wrap"><input type="radio" name="hst_type" value="" checked="checked"><span></span>전체</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="U"><span></span>사용</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="S"><span></span>적립</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="R"><span></span>환불</label>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">포인트</div> 
					<div class="wr-list-con">
						<input type="number" name="startPoint" id="startPoint" value="" class="span250" onkeyup="enterkey()" placeholder="0">P
						~
						<input type="number" name="endPoint" id="endPoint" value="" class="span250" onkeyup="enterkey()" placeholder="0">P
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">담당자</div> 
					<div class="wr-list-con">
						<input type="text" name="admin_name" id="admin_name" value="" class="span250" onkeyup="enterkey()" placeholder="담당자명를 입력하세요">
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
                <!-- <a href="#" onclick="addItem()" class="btn green small icon-add">멤버쉽 등록</a> -->
            </div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="90">
				<col width="60">
				<col width="60">
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
					<th>번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>결제종류</th>
					<th>결제형태</th>
					<th>결제일</th>
					<th>포인트</th>
					<th>제휴사</th>
					<th>매장</th>
					<th>서비스</th>
					<th>담당자</th>
				</tr>
			</thead>

			<tbody class="_tableBody">
				<tr>
					<td>1</td>
					<td>010-0000-0000</td>
					<td>홍길동</td>
					<td>홍길동</td>
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
	</div>	
	
	<script>	
	var pageNo = 1;
	var pageSize = 10;

	function wait(){
		alert('준비중입니다.');
	}
	
	var startDay = '';
	var endDay = '';

	$('.datepick').each(function() {
		const isStart = $(this).hasClass('_start');
		$(this).datepicker({
			language: 'ko-KR',
			autoPick: true,
			autoHide: true,
			format: 'yyyy년 m월 d 일'
		}).on('change', function(e) {
			if(isStart) {
				startDay = $(this).val();
			} else {
				endDay = $(this).val();
			}
		});
	});
	function toDateFormatt(times){
		var thisDay = new Date(times);
		return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
	}
	function setDay(terms) {
		var date = new Date();
		var prevDate = new Date();
		prevDate.setDate(prevDate.getDate() + terms);
		$(".datepick._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._end").datepicker('setDate', toDateFormatt(date.getTime()));
	}

	function loadList(no) {
		pageNo = no;
		getList();
	}
	function enterkey() {
		if (window.event.keyCode == 13) {
			loadList(1);
		}
		return false;
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
				return '-';
		}
	}
	function getPointType(type){
		switch(type){
			case 'S1':
				return '통합';
			case 'S2':
				return '바라는 네일';
			case 'S3':
				return '발몽스파';
			case 'S4':
				return '포레스타 블랙';
			case 'S5':
				return '딥포커스 검안센터';
			case 'S6':
				return '미니쉬 스파';
			case 'S7':
				return '미니쉬 도수';
			case 'P':
				return '포인트';
			case 'K':
				return '패키지';
			default:
				return '-';
		}
	}
    function getPointNameType(type){
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
				return '-';
		}
    }
    function getCalculate2HstType(type){
		switch(type){
			case 'U':
				return '-';
			case 'R':
				return '-';
			case 'S':
				return '+';
			default:
				return '';
		}
    }
	function safetyNull(str) {
		return !str ? '-' : str;
	}
	function getList(){
		var user_phone = $('#user_phone').val();
		var user_name = $('#user_name').val();
		var user_seqno = $('#user_seqno').val();
		var seqno = $('#seqno').val();
		var hst_type = $('input[name=hst_type]:checked').val();
		var point_type = $('#point_type').val();
		var startPoint = $('#startPoint').val();
		var endPoint = $('#endPoint').val();
		var admin_name = $('#admin_name').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		if(user_phone && user_phone != '') {
			data.user_phone = user_phone;
		}
		if(user_name && user_name != '') {
			data.user_name = user_name;
		}
		if(user_seqno && user_seqno != '') {
			data.user_seqno = user_seqno;
		}
		if(seqno && seqno != '') {
			data.seqno = seqno;
		}
		if(hst_type && hst_type != '') {
			data.hst_type = hst_type;
		}
		if(startDay && startDay != '') {
			data.start_dt = startDay;
		}
		if(endDay && endDay != '') {
			data.end_dt = endDay;
		}
		if(point_type && point_type != '') {
			data.point_type = point_type;
		}
		if(startPoint && startPoint != '') {
			data.startPoint = startPoint;
		}
		if(endPoint && endPoint != '') {
			data.endPoint = endPoint;
		}
		if(admin_name && admin_name != '') {
			data.admin_name = admin_name;
		}

		medibox.methods.point.history(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="11" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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

				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>'+getPointNameType(response.data[inx].point_type)+'</td>'
							+'	<td>'+getHstType(response.data[inx].hst_type)+'</td>'
							+'	<td>'+response.data[inx].create_dt+'</td>'
							+'	<td>'+getCalculate2HstType(response.data[inx].hst_type)+medibox.methods.toNumber(response.data[inx].point)+'</td>'
							
							+'	<td>'+getPointType(response.data[inx].point_type)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].service_name)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].type_name)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].admin_name)+'</td>'
							+'</tr>';
			}
			$('._tableBody').html(bodyData);

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
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
