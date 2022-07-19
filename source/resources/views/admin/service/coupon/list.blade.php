@php 
$page_title = '쿠폰 관리';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">쿠폰 관리</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">쿠폰 제휴사</div>
					<div class="wr-list-con">
						<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
							<option value="">검색가능 셀렉트</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">쿠폰 검색</div> 
					<div class="wr-list-con">
						<select class="default" id="coupon_search_type">
							<option value="name">쿠폰명</option>
							<option value="seqno">쿠폰번호</option>
						</select>
						<input type="text" name="search_field1" id="search_field1" value="" class="span250" onkeyup="enterkey()" placeholder="검색어를 입력하세요">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">쿠폰 사용기간</div>
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
				<div class="wr-list">
					<div class="wr-list-label">쿠폰 할인유형</div>
					<div class="wr-list-con">
						<label class="radio-wrap"><input type="radio" name="type" value="" checked="checked"><span></span>전체</label>
						<label class="radio-wrap"><input type="radio" name="type" value="F"><span></span>정액할인</label>
						<label class="radio-wrap"><input type="radio" name="type" value="P"><span></span>정률할인</label>
						<label class="radio-wrap"><input type="radio" name="type" value="G"><span></span>상품지급</label>
					</div>
				</div>
			</div>
		</div>	
		<div class="data-sel">
			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="/admin/service/coupon-history" class="btn green small icon-add">쿠폰 이용 현황</a>
                <a href="#" onclick="addItem()" class="btn green small icon-add">쿠폰 등록</a>
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
					<th><a href="#">번호</a></th>
					<th><a href="#">쿠폰 제휴사</a></th>
					<th><a href="#">쿠폰명</a></th>
					<th><a href="#">쿠폰 사용기간</a></th>
					<th><a href="#">발급 상태</a></th>
					<th><a href="#">쿠폰 할인 유형</a></th>
					<th><a href="#">지급 유형</a></th>
					<th><a href="#">지급 조건</a></th>
					<th><a href="#">할인 금액</a></th>
					<th><a href="#">최소 기준금액</a></th>
					<th>단종/판매</th>
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
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		startDay = $(this).val();
	});
	$('._end').datepicker({
		language: 'ko-KR',
		autoPick: true,
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
		$(".datepick._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._end").datepicker('setDate', toDateFormatt(date.getTime()));
	}
	
	function getPartners(){
		// TODO: 제휴사 로그인시에는 해당 값에 할당
		var partnerId = '';

		var data = { adminSeqno:{{ $seqno }} };

		if(partnerId && partnerId != '') {
			data.partner_seqno = partnerId;
		}

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
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
	function getAllowedIssuanceType(code){
		switch(code) {
			case 'A':
				return '발급중';
			case 'C':
				return '발급중지';
			case 'E':
				return '발급종료';
			default:
				return '-';
				break;
		}
	}
	function getType(code){
		switch(code) { 
			case 'F':
				return '정액할인';
			case 'P':
				return '정률할인';
			case 'G':
				return '상품지급';
			default:
				return '-';
				break;
		}
	}
	function getIssuanceType(code){
		switch(code) {
			case 'A':
				return '자동지급';
			default:
				return '-';
				break;
		}
	}
	function getConditionType(code){
		switch(code) {
			case 'A':
				return '전체발급';
			case 'J':
				return '회원가입시';
			case 'M':
				return '멤버쉽';
			default:
				return '-';
				break;
		}
	}
	
	function convertGrpPartners2PartnerName(coupon_partner_grp_seqno){
		
		if(coupon_partner_grp_seqno == 0) {
			return '전체';
		} else {
			var types = coupon_partner_grp_seqno.split('||');
			var partnersName = '';
			for(var inx=0; inx<types.length; inx++){
				types[inx] = (types[inx] + '').replaceAll('|', '');
				if(types[inx] == '0') {
					partnersName = partnersName + (partnersName == '' ? '' : ', ') + '전체';
				} else {
					partnersName = partnersName + (partnersName == '' ? '' : ', ') + $('#partnersPop > option[value='+types[inx]+']').text();
				}
			}
			return partnersName;
		}
	}
	
	function getList(){
		var searchField = $('input[name=searchField]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }}, include_discontinued: 'Y' };

		var partner_seqno = $('#partnersPop').val();
		var coupon_search_type = $('#coupon_search_type').val();
		var search_field1 = $('#search_field1').val();
		var type = $('input[name=type]:checked').val();

		if(partner_seqno && partner_seqno != '') {
			data.partner_seqno = partner_seqno;
		}
		if(coupon_search_type && coupon_search_type != '') {
			data.coupon_search_type = coupon_search_type;
		}
		if(search_field1 && search_field1 != '') {
			data.search_field1 = search_field1;
		}
		if(type && type != '') {
			data.type = type;
		}
		if(startDay && startDay != '') {
			data.start_dt = startDay;
		}
		if(endDay && endDay != '') {
			data.end_dt = endDay;
		}

		medibox.methods.point.coupon.list(data, function(request, response){
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
							+'<tr onclick="gotoDetail(\''+response.data[inx].seqno+'\')" style="cursor: pointer;">'
							+'	<td>'+no+'</td>'
							+'	<td>'+convertGrpPartners2PartnerName(response.data[inx].coupon_partner_grp_seqno)+'</td>'
							+'	<td>'+response.data[inx].name+'</td>'
							+'	<td>'+(response.data[inx].date_use ? '발급일로부터 '+response.data[inx].date_use+'일' : response.data[inx].start_dt + ' ~ ' + response.data[inx].end_dt)+'</td>'
							+'	<td>'+getAllowedIssuanceType(response.data[inx].allowed_issuance_type)+'</td>'
							+'	<td>'+getType(response.data[inx].type)+'</td>'
							+'	<td>'+getIssuanceType(response.data[inx].issuance_type)+'</td>'
							+'	<td>'+getConditionType(response.data[inx].issuance_condition_type)+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].discount_price)+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].limit_base_price)+'</td>'
//							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].seqno+'\')" class="btnEdit">수정/삭제</a></td>'
							+'	<td>'+(response.data[inx].deleted == 'N' ? '판매' : '단종')+'</td>'
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
	function gotoDetail(seq){
		location.href = '/admin/service/coupon/'+seq;
	}
	function addItem(){
		location.href = '/admin/service/coupon/0';
	}
	$(document).ready(function(){
		getList();
		getPartners();

		endDay = toDateFormatt(new Date().getTime());
	});
	</script>

</section>

@include('admin.footer')
