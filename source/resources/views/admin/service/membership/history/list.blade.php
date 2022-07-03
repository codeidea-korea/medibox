@php 
$page_title = '멤버쉽 사용내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">멤버쉽 사용내역</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">회원 아이디</div> 
					<div class="wr-list-con">
						<input type="text" name="user_phone" id="user_phone" value="" class="span250" onkeyup="enterkey()" placeholder="회원 아이디를 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">회원 이름</div> 
					<div class="wr-list-con">
						<input type="text" name="user_name" id="user_name" value="" class="span250" onkeyup="enterkey()" placeholder="회원 이름을 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">회원 번호</div> 
					<div class="wr-list-con">
						<input type="text" name="user_seqno" id="user_seqno" value="" class="span250" onkeyup="enterkey()" placeholder="회원 번호를 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">기간</div>
					<div class="wr-list-con">
						<select class="default" id="dt_option_type">
							<option value="">선택해주세요.</option>
							<option value="use">사용일자</option>
							<option value="join">(멤버쉽) 가입일자</option>
							<option value="end">(멤버쉽) 종료일자</option>
						</select>

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
				<div class="wr-list">
					<div class="wr-list-label">사용 유형</div>
					<div class="wr-list-con">
						<label class="radio-wrap"><input type="radio" name="hst_type" value="" checked="checked"><span></span>전체</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="U"><span></span>사용</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="S"><span></span>적립</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="R"><span></span>환불</label>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">멤버쉽</div>
					<div class="wr-list-con">
						<select class="default" id="seqno">
						@php
						if(!empty($contents)) {
							for($inx = 0; $inx < count($contents); $inx++) {
								echo '<option value="'. $contents[$inx]->seqno . 'use">'. $contents[$inx]->name .'</option>';
							}
						}
						@endphp
						</select>
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
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>고객번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>멤버쉽</th>
					<th>가입일</th>
					<th>종료일</th>
					<th>바우처</th>
					<th>사용유형</th>
					<th>실행일자</th>
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

	$('._start').datepicker({
		language: 'ko-KR',
		autoPick: false,
		autoHide: true,
		format: 'yyyy년 m월 d 일'
	}).on('change', function(e) {
		startDay = $(this).val();
	});
	$('._end').datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy년 m월 d 일'
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
	function safetyNull(str) {
		return !str ? '-' : str;
	}
	function getList(){
		var user_phone = $('#user_phone').val();
		var user_name = $('#user_name').val();
		var user_seqno = $('#user_seqno').val();
		var dt_option_type = $('#dt_option_type').val();
		var seqno = $('#seqno').val();
		var hst_type = $('input[name=hst_type]:checked').val();
		
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
		if(dt_option_type && dt_option_type != '') {
			if(startDay && startDay != '') {
				data.start_dt = startDay;
			}
			if(endDay && endDay != '') {
				data.end_dt = endDay;
			}
		}

		medibox.methods.point.membership.history.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="10" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
							+'	<td>'+response.data[inx].user_seqno+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td>'+response.data[inx].user_name+'</td>'
							
							+'	<td>'+response.data[inx].membership_name+'</td>'
							+'	<td>'+response.data[inx].real_start_dt+'</td>'
							+'	<td>'+response.data[inx].real_end_dt+'</td>'

							+'	<td>'+safetyNull(response.data[inx].service_name)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].voucher_name)+'</td>'
							+'	<td>'+safetyNull(response.data[inx].coupon_name)+'</td>'
							
							+'	<td>'+getHstType(response.data[inx].hst_type)+'</td>'
							+'	<td>'+response.data[inx].create_dt+'</td>'
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
