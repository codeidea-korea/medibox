@php 
$page_title = '멤버쉽 관리';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">멤버쉽 관리</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<input type="text" name="searchField" id="searchField" value="" class="span250" onkeyup="enterkey()" placeholder="멤버쉽 명">
			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="/admin/service/membership-history" class="btn green small icon-add">멤버쉽 사용 내역</a>
                <a href="#" onclick="addItem()" class="btn green small icon-add">멤버쉽 등록</a>
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
				<col width="60">
			</colgroup>
			<thead>
				<tr>
					<th rowspan="2">번호</th>
					<th>멤버쉽</th>
					<th rowspan="2">가격</th>
					<th rowspan="2">사용기간</th>
					<th>부여</th>
					<th colspan="6">바우처</th>
					<th rowspan="2">단종/판매</th>
				</tr>
				<tr>
					<th>이름</th>
					<th>포인트</th>

					<!-- <th>제휴사</th> -->
					<th>바우처이름</th>
					<th>매장</th>
					<th>서비스</th>
					<th>쿠폰</th>
					<th>가격</th>
					<th>횟수</th>
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
		return false;
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

		medibox.methods.point.membership.list(data, function(request, response){
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
				var rowspan = response.data[inx].vouchers && response.data[inx].vouchers.length > 0 ? response.data[inx].vouchers.length : 1;
				rowspan = rowspan + (response.data[inx].coupons && response.data[inx].coupons.length > 0 ? response.data[inx].coupons.length : 0);

				bodyData = bodyData 
							+'<tr onclick="gotoDetail(\''+response.data[inx].seqno+'\')" style="cursor: pointer;">'
							+'	<td rowspan="'+rowspan+'">'+no+'</td>'
							+'	<td rowspan="'+rowspan+'">'+response.data[inx].name+'</td>'
							+'	<td rowspan="'+rowspan+'">'+medibox.methods.toNumber(response.data[inx].price)+'</td>'
							+'	<td rowspan="'+rowspan+'">'+getDateType(response.data[inx].date_use)+'</td>'
							+'	<td rowspan="'+rowspan+'">'+medibox.methods.toNumber(response.data[inx].point)+'</td>'
							
							+ (
								(response.data[inx].vouchers && response.data[inx].vouchers.length > 0
								? (
									'<td>'+response.data[inx].vouchers[0].name+'</td>'
										+ '<td>'+response.data[inx].vouchers[0].store_name+'</td>'
										+ '<td>'+response.data[inx].vouchers[0].service_name+'</td>'
										+ '<td>-</td>'
										+ '<td>'+medibox.methods.toNumber(response.data[inx].vouchers[0].price)+'</td>'
										+ '<td>'+medibox.methods.toNumber(response.data[inx].vouchers[0].unit_count)+'</td>'
								)
								: ('<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>'))
							)
//							+'	<td rowspan="'+rowspan+'"><a href="#" onclick="gotoDetail(\''+response.data[inx].seqno+'\')" class="btnEdit">수정/삭제</a></td>'
							+'	<td rowspan="'+rowspan+'">'+(response.data[inx].deleted == 'N' ? '판매' : '단종')+'</td>'
							+'</tr>'

							/*
							// 메인
							+ (response.data[inx].services && response.data[inx].services.length > 0
								? ('<td>'+response.data[inx].services[0].partnerInfo.cop_name+'</td>'
									+ '<td>'+response.data[inx].services[0].storeInfo.name+'</td>'
									+ '<td>'+response.data[inx].services[0].name+'</td>'
									+ '<td>'+response.data[inx].services[0].unit_count+'</td>')
								: ('<td>-</td><td>-</td><td>-</td><td>-</td>'))
							// 서브
							+ ('<td rowspan="'+rowspan+'">'
								// 서브 바우처
								+ (response.data[inx].vouchers
								? (
									response.data[inx].vouchers.map(voucher => (
										voucher.name+' (바우처 ' + medibox.methods.toNumber(voucher.unit_count) + '종)<br>'
									))
								)
								: (''))
								// 쿠폰
								+ (response.data[inx].coupons
								? (
									response.data[inx].coupons.map(coupon => (
										coupon.name+' (쿠폰)<br>'
									))
								)
								: ('')) + '</td>'
							)

//							+'	<td rowspan="'+rowspan+'"><a href="#" onclick="gotoDetail(\''+response.data[inx].seqno+'\')" class="btnEdit">수정/삭제</a></td>'
							+'	<td rowspan="'+rowspan+'">'+(response.data[inx].deleted == 'N' ? '판매' : '단종')+'</td>'
							+'</tr>'
							
							// 메인 바우처 2행부터
							+ (response.data[inx].services && response.data[inx].services.length > 1
								? (
									response.data[inx].services.map((service, index) => {
										if(index != 0) {
											return '<tr><td>'+service.partnerInfo.cop_name+'</td>'
												+ '<td>'+service.storeInfo.name+'</td>'
												+ '<td>'+service.name+'</td>'
												+ '<td>'+service.unit_count+'</td></tr>';
										}
									})
								)
								: '')
							;
							*/
							+ (
								(response.data[inx].vouchers && response.data[inx].vouchers.length > 0
								? (
									response.data[inx].vouchers.map((voucher, idx) => {
										if(idx == 0) return;
										
										return (
										'<tr><td>'+voucher.name+'</td>'
										+ '<td>'+voucher.store_name+'</td>'
										+ '<td>'+voucher.service_name+'</td>'
										+ '<td>-</td>'
										+ '<td>'+medibox.methods.toNumber(voucher.price)+'</td>'
										+ '<td>'+medibox.methods.toNumber(voucher.unit_count)+'</td></tr>'
									)})
								)
								: (''))
							)
							+ (
								(response.data[inx].coupons && response.data[inx].coupons.length > 0
								? (
									response.data[inx].coupons.map(coupon => (
										'<tr><td>-</td>'
										+ '<td>-</td>'
										+ '<td>-</td>'
										+ '<td>'+coupon.name+'</td>'
										+ '<td>-</td>'
										+ '<td>1</td></tr>'
									))
								)
								: (''))
							);
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
		location.href = '/admin/service/membership/'+seq;
	}
	function addItem(){
		location.href = '/admin/service/membership/0';
	}
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
