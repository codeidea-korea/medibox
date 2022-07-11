<div class="flexbox">
	<div class="tbl-basic bold td-h4">
		<div class="tbl-header">
			<div class="caption flexbox-header">바우처 충전/환불</div>
			<div class="rightSet">
				<a href="#mediboxpop-voucher-collect" onclick="openPopVoucherCollect()" class="btn green small popup-inline">바우처 충전</a>&nbsp;&nbsp;
				<a href="#mediboxpop-voucher-refund" onclick="openPopVoucherRefund()" class="btn red small popup-inline">바우처 환불</a>
			</div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="250">
				<col width="150">
				<col width="150">
			</colgroup>
			<thead class="bar">
				<tr>
					<th>번호</th>
					<th>바우처 명</th>
					<th>사용유형</th>
					<th>적립일</th>
				</tr>
			</thead>
			<tbody class="_tableBodyVoucherCollect">
			</tbody>					
		</table>				

		<nav class="pg_wrap _voucher_collect_page">
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
	var vpageNo = 1;
	var vpageSize = 10;
	
	function loadListVoucherUsed(page){
		vpageNo = page;
		getInfo();
	}

	function generateVoucherCollect(data, count){
		if(count == 0){
			$('._tableBodyVoucherCollect').html('<tr>'
								+'    <td colspan="4" class="empty">입력된 정보가 없습니다.</td>'
								+'</tr>');
			$('._voucher_collect_page').html('    <a href="#" class="pg_btn first"></a>'
								+'    <a href="#" class="pg_btn prev"></a>'
								+'    <a href="#" class="pg_btn active">1</a>'
								+'    <a href="#" class="pg_btn next"></a>'
								+'    <a href="#" class="pg_btn last"></a>');
			return;
		}
		var bodyData = '';
		for(var inx=0; inx<data.length; inx++){
			var no = (count - (vpageNo - 1)*vpageSize) - inx;
			bodyData = bodyData 
						+'<tr>'
						+'	<td>'+no+'</td>'
						+'	<td>'+data[inx].voucher_name+'</td>'
						+'	<td>'+convertHistoryType(data[inx].hst_type)+'</td>'
						+'	<td>'+data[inx].create_dt+'</td>'
						+'</tr>';
		}
		if(count > 0)
		{
			var totSize = count;
			var totPagePt = Math.ceil(totSize / vpageSize);
			var pageStt = (Math.ceil(vpageNo/vpageSize)-1)*vpageSize +1;
			var pageEnd = Math.ceil(vpageNo/vpageSize)*vpageSize;
			pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
			var eventName = 'onclick'; var pageTmp = '';
			
			pageTmp+= '    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadListVoucherUsed(1)"' : '')+'></a>'
					+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadListVoucherUsed('+(pageStt-1)+')"' : '')+'></a>';
			for(var inx=pageStt; inx <= pageEnd; inx++)
			{
				pageTmp+='<a href="#" class="pg_btn '+(inx == vpageNo ? 'active' : '')+'" '+eventName+'="loadListVoucherUsed('+(inx)+')">'+(inx)+'</a>';
			}
			pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadListVoucherUsed('+(pageEnd+1)+')"' : '')+'></a>'
					+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadListVoucherUsed('+(totPagePt)+')"' : '')+'></a>';

			$('._voucher_collect_page').html(pageTmp);
		}
		$('._tableBodyVoucherCollect').html(bodyData);
	}
	
	// 적립 팝업 열기
	function openPopVoucherCollect(){
		getVoucherCollect();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-voucher-collect'
			},
			type: 'inline'
		});
	}
	// 환불 팝업 열기
	function openPopVoucherRefund(){
		getVoucherRefund();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-voucher-refund'
			},
			type: 'inline'
		});
	}
</script>
