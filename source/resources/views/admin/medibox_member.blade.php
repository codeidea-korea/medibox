@php 
$page_title = '회원관리';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">회원관리</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<input type="text" name="startDay" id="startDay" value="2022-02-09" class="span130 datepicker" data-label="날짜" placeholder="전화번호/이름">&nbsp;&nbsp;~
			<input type="text" name="endDay" id="endDay" value="{{ date('Y-m-d', strtotime('+1 day')) }}" class="span130 datepicker" data-label="날짜" placeholder="전화번호/이름">
			<input type="text" name="searchField" id="searchField" value="" class="span250" onkeyup="enterkey()" placeholder="전화번호/이름">
			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet"><a href="#" onclick="wait()" class="btn green small icon-excel">엑셀 다운로드</a></div>
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
			</colgroup>
			<thead>
				<tr>
					<th><a href="#" class="sort">회원번호</a></th>
					<th><a href="#" class="sort asc">아이디</a></th>
					<th><a href="#" class="sort desc">이름</a></th>
					<th><a href="#" class="sort desc">회원가입일</a></th>
					<th><a href="#" class="sort desc">포인트</a></th>

					<th><a href="#" class="sort desc">정액권</a></th>
					<th><a href="#" class="sort desc">패키지</a></th>
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
									+'    <td colspan="8" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
				bodyData = bodyData 
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
	
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
