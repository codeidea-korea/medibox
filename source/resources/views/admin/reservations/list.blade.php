@php 
$page_title = '예약 내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">예약 내역</div>
	
	<div class="data-search-wrap"><!-- 
		<div class="data-sel">
			<input type="text" name="searchField" id="searchField" value="" class="span250" onkeyup="enterkey()" placeholder="회사명">
			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		 -->
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="/admin/reservations/condition" onclick="" class="btn green small icon-add">등록</a>
                <!-- <a href="#" onclick="removeAll()" class="btn red small icon-del">삭제</a> -->
            </div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<col width="50">
				<!--  <col width="50"> -->
				<col width="50">
				<col width="50">
			</colgroup>
			<thead>
				<tr>
					<th><a href="#" class="sort">번호</a></th>
					<th><a href="#" class="sort asc">예약구분</a></th>
					<th><a href="#" class="sort desc">예약일시</a></th>
					<th><a href="#" class="sort desc">고객명</a></th>
					<th><a href="#" class="sort desc">휴대폰</a></th>
					<th><a href="#" class="sort desc">제휴사</a></th>
					<th><a href="#" class="sort desc">매장</a></th>
					<th><a href="#" class="sort desc">직위</a></th>
					<th><a href="#" class="sort desc">디자이너</a></th>
					<th><a href="#" class="sort desc">예약항목</a></th>
					<th><a href="#" class="sort desc">예약상태</a></th>
					<th><a href="#" class="sort desc">등록일시</a></th>
					<!-- <th><a href="#" class="sort desc">결제</a></th> -->
					<th><a href="#" class="sort desc">메모</a></th>
					<th><a href="#" class="sort desc">예약화면</a></th>
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
	function getList(){
		var searchField = $('input[name=searchField]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		if(searchField && searchField != '') {
			data.name = searchField;
		}

		medibox.methods.store.reservation.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

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
				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td><h3>'+ (response.data[inx].apply_on_mobile == 'Y' ? '모바일' : '현장등록') +'</td>'
							+'	<td>'+response.data[inx].start_dt+'</td>'

							+'	<td>'+response.data[inx].userInfo.user_name+'</td>'
							+'	<td>'+response.data[inx].userInfo.user_phone+'</td>'

							+'	<td>'+response.data[inx].partnerInfo.cop_name+'</td>'

							+'	<td>'+response.data[inx].storeInfo.name+'</td>'

							+'	<td>'+(response.data[inx].managerInfo ? response.data[inx].managerInfo.manager_type : '기본')+'</td>' // 직
							+'	<td>'+(response.data[inx].managerInfo ? response.data[inx].managerInfo.name : '-')+'</td>'

							+'	<td>'+(response.data[inx].serviceInfo ? response.data[inx].serviceInfo.name : '-')+'</td>' // 예약 항목 (복수개 가능, 우선 단일)
							+'	<td>'+convertStatus2String(response.data[inx].status)+'</td>'
							+'	<td>'+response.data[inx].create_dt+'</td>'
//							+'	<td>'+response.data[inx].cop_phone+'</td>' // 결제 ? 매핑 불가
							+'	<td>'+response.data[inx].memo+'</td>'
							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].seqno+'\')" class="btnEdit">이동</a></td>'
							+'</tr>';
			}
			$('._tableBody').html(bodyData);
//			$('._tableBody > tr > td').not('._tableBody > tr > td[data-action-type=none]').off().on('click', viewInfo);

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
	function convertStatus2String(code){
		switch(code){
			case 'R': return '예약 완료';
			case 'N': return '예약 불이행';
			case 'C': return '예약 취소';
			case 'E': return '고객 입장';
			case 'D': return '서비스 완료';
			default: break;
		}
		return '';
	}
	function gotoDetail(seq){
		location.href = '/reservation-history/'+seq;
	}
	function addItem(){
		alert('준비중입니다.');
//		location.href = '/admin/partners/0';
	}		
	
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
