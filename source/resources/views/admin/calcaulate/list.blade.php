@php 
$page_title = '정산 내역';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">정산 내역</div>
	
	<div class="data-search-wrap">
		<div class="data-sel" style="width:100%;">
			매장&nbsp;&nbsp;&nbsp;&nbsp;<select class="default">
				<option>발몽스파</option>
				<option>바라는네일</option>
				<option>포레스타 블랙</option>
				<option>딥포커스</option>
				<option>미니쉬 스파</option>
				<option>미니쉬 도수</option>
			</select>		
		</div>	
		<div class="data-sel" style="width:100%;">
			기간&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="" value="" class="span130 datepicker" data-label="날짜">&nbsp;&nbsp;~
			<input type="text" name="" value="" class="span130 datepicker" data-label="날짜">
			<a href="#" class="btn gray" onclick="loadList(1)">검색</a>				
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption"><span style="font-weight:bold;font-size:16px;">매장정산내역</span>&nbsp;&nbsp;총 <b>11</b>개 글이 있습니다</div>
			<div class="rightSet"><a href="#" class="btn green small icon-excel">엑셀 다운로드</a></div>
		</div>
		<table>
			<colgroup>
				<col width="80">
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
					<th><a href="#">회원번호</a></th>
					<th><a href="#">종류</a></th>
					<th><a href="#">사용유형</a></th>
					<th><a href="#">결제매장</a></th>
					<th><a href="#">결제자</a></th>
					<th><a href="#">사용대장</a></th>
					<th><a href="#">서비스명</a></th>
					<th><a href="#">예약/취소일</a></th>
					<th><a href="#">결제/환불일</a></th>
					<th><a href="#">금액</a></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>1</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
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
	var store_seqno;

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
		var searchField = $('input[name=searchField]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }}, include_discontinued: 'Y' };

		if(searchField && searchField != '') {
			data.name = searchField;
		}
		@php
		if(session()->get('admin_type') == 'P') {
//			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
//			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.point.vouchers.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="6" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
							+'	<td>'+(response.data[inx].storeInfo ? response.data[inx].storeInfo.name : '-')+'</td>'
							+'	<td>'+response.data[inx].name+'</td>'
							+'	<td>'+response.data[inx].context+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].price)+'</td>'
//							+'	<td>'+getDateType(response.data[inx].date_use)+'</td>'
//							+'	<td>'+medibox.methods.toNumber(response.data[inx].unit_count)+'</td>'
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
		location.href = '/admin/service/vouchers/'+seq;
	}
	function addItem(){
		location.href = '/admin/service/vouchers/0';
	}
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
