@php 
$page_title = '포인트 사용내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">포인트 사용내역</div>
	
	<form name="" action="" method="post">
	<div class="data-search-wrap">
		<div class="data-sel">
			
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">회원 아이디</div>
					<div class="wr-list-con">
						<input type="text" id="id" name="" value="" class="span200" placeholder="핸드폰번호">
					</div>
				</div>
				<div class="wr-list"> 
					<div class="wr-list-label">회원 이름</div>
					<div class="wr-list-con">
						<input type="text" id="name" name="" value="" class="span200" placeholder="이름">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">고객 번호</div>
					<div class="wr-list-con">
						<input type="text" id="no" name="" value="" class="span200" placeholder="고객번호">
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
					<div class="wr-list-label">사용 유형</div>
					<div class="wr-list-con">
						<label class="radio-wrap"><input type="radio" name="hst_type" value="" checked="checked"><span></span>전체</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="U"><span></span>사용</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="S"><span></span>충전</label>
						<label class="radio-wrap"><input type="radio" name="hst_type" value="R"><span></span>환불</label>
					</div>
				</div>
				<!--
				<div class="wr-list">
					<div class="wr-list-label">사용 제휴사</div>
					<div class="wr-list-con">
						<textarea id="contents" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
					</div>
				</div>
				-->
			</div>

			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>
	</form>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="#" onclick="addItem()" class="btn green small icon-add">포인트 자동 적립 관리</a>
                <!-- <a href="#" onclick="removeAll()" class="btn red small icon-del">삭제</a> -->
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
					<th><a href="#" class="sort">번호</a></th>
					<th><a href="#">아이디</a></th>
					<th><a href="#" >이름</a></th>
					<th><a href="#" >포인트 종류</a></th>
					<th><a href="#" >사용유무</a></th>
					<th><a href="#" >제휴사</a></th>
					<th><a href="#" >사용샵</a></th>
					<th><a href="#" >서비스</a></th>
					<th><a href="#" >포인트</a></th>
					<th><a href="#" >결제일</a></th>
					<th><a href="#" >선택</a></th>
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
	function setDay(date) {
		var date = new Date();
		var prevDate = new Date();
		prevDate.setDate(prevDate.getDate() + date);
		$(".datepick._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._end").datepicker('setDate', toDateFormatt(date.getTime()));
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
				return '-';
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
	function nullSafety(str){
		return !str ? '' : str;
	}
	function getList(){
		var searchField = $('input[name=searchField]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }},
				id:$('#id').val(), name:$('#name').val(), no:$('#no').val(), hst_type:$('input[name=hst_type]:checked').val(), startDay:startDay, endDay:endDay };

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
				var serviceName;
				if(response.data[inx].point_type == 'P') {
					serviceName = '포인트';
				} else if(response.data[inx].point_type == 'K') {
					serviceName = '패키지';
				} else {
					serviceName = '정액권-' + getPointType(response.data[inx].point_type);
				}				

				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>'+serviceName+'</td>'
							+'	<td>'+getHstType(response.data[inx].hst_type)+'</td>'

							+'	<td>'+getPointType(response.data[inx].point_type)+'</td>'

							+ (!response.data[inx].product_name || response.data[inx].product_name == '' 
								? ('	<td>'+nullSafety(response.data[inx].service_name)+'</td>'
								  +'	<td>'+nullSafety(response.data[inx].type_name)+'</td>')
								: ('	<td>'+nullSafety(response.data[inx].shop_name)+'</td>'
								  +'	<td>'+nullSafety(response.data[inx].product_name)+'</td>')
								)
							+'	<td>'+medibox.methods.toNumber(response.data[inx].point)+'</td>'
							+'	<td>'+response.data[inx].create_dt+'</td>'
							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].user_point_hst_seqno+'\')" class="btnEdit">선택</a></td>'
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
		location.href = '/admin/point/history/'+seq;
	}
	function addItem(){
		location.href = '/admin/point/conf';
	}
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
