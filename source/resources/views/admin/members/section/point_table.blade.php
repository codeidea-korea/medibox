
<div class="flexbox">
	<div class="tbl-basic bold td-h4">
		<div class="tbl-header">
			<div class="caption flexbox-header">포인트 충전/환불</div>
			<div class="rightSet"><a href="#mediboxpop-point2" onclick="openPopCollect()" class="btn green small popup-inline">포인트 충전</a>&nbsp;&nbsp;<a href="#mediboxpop-point3" onclick="openPopRefund()" class="btn red small popup-inline">포인트 환불</a></div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="250">
				<col width="150">
				<col width="250">
				<col width="150">
				<col width="350">
			</colgroup>
			<thead class="bar">
				<tr>
					<th>번호</th>
					<th>포인트종류</th>
					<th>사용유형</th>
					<th>적립금액</th>
					<th>적립일</th>
					<th>메모</th>
				</tr>
			</thead>
			<tbody class="_tableBodyRefund">
			</tbody>					
		</table>				

		<nav class="pg_wrap _refunded_page">
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
</div>

<div class="flexbox">
	<div class="tbl-basic bold td-h4">
		<div class="tbl-header">
			<div class="caption flexbox-header">결제/취소 내역</div>
			<div class="rightSet"><a href="#mediboxpop-point1" onclick="openPopUse()" class="btn blue small popup-inline">포인트 사용</a></div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="250">
				<col width="150">
				<col width="250">
				<col width="250">
				<col width="150">
				<col width="150">
				<col width="150">
				<col width="350">
				<col width="350">
			</colgroup>
			<thead class="bar">
				<tr>
					<th>번호</th>
					<th>포인트종류</th>
					<th>사용유형</th>
					<th>사용샵</th>
					<th>서비스</th>
					<th>사용금액</th>
					<th>사용일</th>
					<th>포인트 차감자</th>
					<th>메모</th>
					<th>예약시간</th>
				</tr>
			</thead>
			<tbody class="_tableBodyUsed">
			</tbody>					
		</table>						

		<nav class="pg_wrap _used_page">
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
</div>

<script>
	var rpageNo = 1;
	var rpageSize = 10;
	var upageNo = 1;
	var upageSize = 10;
	
	function loadListPointRefund(page) {
		rpageNo = page;
		getInfo();
	}
	function generatePointRefunded(data, count){
		if(count == 0){
			$('._tableBodyRefund').html('<tr>'
								+'    <td colspan="6" class="empty">입력된 정보가 없습니다.</td>'
								+'</tr>');
			$('._refunded_page').html('    <a href="#" class="pg_btn first"></a>'
								+'    <a href="#" class="pg_btn prev"></a>'
								+'    <a href="#" class="pg_btn active">1</a>'
								+'    <a href="#" class="pg_btn next"></a>'
								+'    <a href="#" class="pg_btn last"></a>');
			return;
		}
		var bodyData = '';
		for(var inx=0; inx<data.length; inx++){
			var no = (count - (rpageNo - 1)*rpageSize) - inx;
			var serviceName = '';
			if(data[inx].point_type == 'P') {
				serviceName = '포인트';
			} else if(data[inx].point_type == 'K') {
				serviceName = data[inx].service_name +' '+ data[inx].type_name;
			} else {
				serviceName = data[inx].service_name +' '+ data[inx].type_name + '-' +data[inx].service_sub_name;
			}
			bodyData = bodyData 
						+'<tr>'
						+'	<td>'+no+'</td>'
						+'	<td>'+(data[inx].hst_type == 'R' ? getPointTypeFullName(data[inx].point_type) : serviceName)+'</td>'
						+'	<td>'+(data[inx].hst_type == 'R' ? '<span class="color-red">환불</span>' : '적립')+'</td>'
						+'	<td>'+(data[inx].hst_type == 'R' 
							? '<span class="color-red">'+medibox.methods.toNumber(data[inx].point)+'</span>' 
							: medibox.methods.toNumber(data[inx].point))+'</td>'
						+'	<td>'+data[inx].create_dt+'</td>'
						+'	<td>'+(data[inx].memo ? data[inx].memo : '')+'</td>'
						+'</tr>';
		}
		if(count > 0)
		{
			var totSize = count;
			var totPagePt = Math.ceil(totSize / rpageSize);
			var pageStt = (Math.ceil(rpageNo/rpageSize)-1)*rpageSize +1;
			var pageEnd = Math.ceil(rpageNo/rpageSize)*rpageSize;
			pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
			var eventName = 'onclick'; var pageTmp = '';
			
			pageTmp+= '    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadListPointRefund(1)"' : '')+'></a>'
					+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadListPointRefund('+(pageStt-1)+')"' : '')+'></a>';
			for(var inx=pageStt; inx <= pageEnd; inx++)
			{
				pageTmp+='<a href="#" class="pg_btn '+(inx == rpageNo ? 'active' : '')+'" '+eventName+'="loadListPointRefund('+(inx)+')">'+(inx)+'</a>';
			}
			pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadListPointRefund('+(pageEnd+1)+')"' : '')+'></a>'
					+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadListPointRefund('+(totPagePt)+')"' : '')+'></a>';

			$('._refunded_page').html(pageTmp);
		}
		$('._tableBodyRefund').html(bodyData);
	}

	function loadListPointUsed(page) {
		upageNo = page;
		getInfo();
	}
	function generatePointUsed(data, count){
		if(count == 0){
			$('._tableBodyUsed').html('<tr>'
								+'    <td colspan="10" class="empty">입력된 정보가 없습니다.</td>'
								+'</tr>');
			$('._used_page').html('    <a href="#" class="pg_btn first"></a>'
								+'    <a href="#" class="pg_btn prev"></a>'
								+'    <a href="#" class="pg_btn active">1</a>'
								+'    <a href="#" class="pg_btn next"></a>'
								+'    <a href="#" class="pg_btn last"></a>');
			return;
		}
		var bodyData = '';
		for(var inx=0; inx<data.length; inx++){
			var no = (count - (upageNo - 1)*upageSize) - inx;
			var serviceName = '';
			if(data[inx].point_type == 'P') {
				serviceName = '포인트';
			} else if(data[inx].point_type == 'K') {
				serviceName = '패키지';
			} else {
				serviceName = '정액권-' + getPointType(data[inx].point_type);
			}
			bodyData = bodyData 
						+'<tr>'
						+'	<td>'+no+'</td>'
						+'	<td>'+serviceName+'</td>'

						// 일반 결제만 허용, 예약의 경우 제외
						+ (
							data[inx].hst_type == 'R' ? '<td>환불됨</td>' :(
							data[inx].service_seqno > 0
								? ('<td>예약됨</td>')
								: (data[inx].admin_seqno > 0 ? '<td>사용됨</td>' : 
								('	<td>'+(data[inx].canceled == 'N' ? (data[inx].approved == 'Y' ? '사용' : '승인중') : '사용취소')
									+ (data[inx].hst_type == 'U' && data[inx].canceled == 'Y' ? ''
									: '<div style="display: flex;">'+ (data[inx].approved == 'Y' 
										? '<button onclick="cancelUsePoint('+data[inx].user_point_hst_seqno+')" class="btn red">사용취소</button>'
										:	('<button onclick="approveUsePoint('+data[inx].user_point_hst_seqno+')" class="btn black ml5">승인</button>'
											+ '<button onclick="cancelUsePoint('+data[inx].user_point_hst_seqno+')" class="btn red ml5">취소</button>')) + '</div>')
								+'</td>')
								))
						)

						+'	<td>'+(data[inx].product_seqno == 0 ? data[inx].shop_name : data[inx].service_name)+'</td>'
						+'	<td>'+(data[inx].product_seqno == 0 
							? data[inx].product_name 
							: (data[inx].type_name + (data[inx].service_sub_name ? data[inx].service_sub_name : ''))) +'</td>'

						+'	<td>-'+medibox.methods.toNumber(data[inx].point)+'</td>'
						+'	<td>'+data[inx].create_dt+'</td>'
						+'	<td>'+(data[inx].admin_name && data[inx].admin_name != 'null' ? data[inx].admin_name : '')+'</td>'
						+'	<td>'+(data[inx].memo ? data[inx].memo : '')+'</td>'
						+'	<td>'+(data[inx].reservation ? data[inx].reservation.start_dt : '-')+'</td>'
						+'</tr>';
		}
		if(count > 0)
		{
			var totSize = count;
			var totPagePt = Math.ceil(totSize / upageSize);
			var pageStt = (Math.ceil(upageNo/upageSize)-1)*upageSize +1;
			var pageEnd = Math.ceil(upageNo/upageSize)*upageSize;
			pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
			var eventName = 'onclick'; var pageTmp = '';
			
			pageTmp+= '    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadListPointUsed(1)"' : '')+'></a>'
					+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadListPointUsed('+(pageStt-1)+')"' : '')+'></a>';
			for(var inx=pageStt; inx <= pageEnd; inx++)
			{
				pageTmp+='<a href="#" class="pg_btn '+(inx == upageNo ? 'active' : '')+'" '+eventName+'="loadListPointUsed('+(inx)+')">'+(inx)+'</a>';
			}
			pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadListPointUsed('+(pageEnd+1)+')"' : '')+'></a>'
					+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadListPointUsed('+(totPagePt)+')"' : '')+'></a>';

			$('._used_page').html(pageTmp);
		}
		$('._tableBodyUsed').html(bodyData);
	}
	
	// 사용 팝업 열기
	function openPopUse(){
		getUseTypes();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-point1'
			},
			type: 'inline'
		});
	}
	// 적립 팝업 열기
	function openPopCollect(){
		getCollectTypes();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-point2'
			},
			type: 'inline'
		});
	}
	// 환불 팝업 열기
	function openPopRefund(){
		getRefundTypes();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-point3'
			},
			type: 'inline'
		});
	}
</script>
