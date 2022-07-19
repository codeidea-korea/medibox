<div class="flexbox">
	<div class="tbl-basic bold td-h4">
		<div class="tbl-header">
			<div class="caption flexbox-header">멤버쉽 충전/환불</div>
			<div class="rightSet">
				<a href="#mediboxpop-membership-collect" onclick="openPopMembershipCollect()" class="btn green small popup-inline">멤버쉽 충전</a>&nbsp;&nbsp;
				<a href="#mediboxpop-membership-refund" onclick="openPopMembershipRefund()" class="btn red small popup-inline">멤버쉽 환불</a>
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
					<th>멤버쉽 명</th>
					<th>사용유형</th>
					<th>적립일</th>
				</tr>
			</thead>
			<tbody class="_tableBodyMembershipCollect">
			</tbody>					
		</table>				

		<nav class="pg_wrap _membership_collect_page">
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
	var mpageNo = 1;
	var mpageSize = 10;
	
	function loadListMembershipUsed(page){
		mpageNo = page;
		getInfo();
	}

	function generateMembershipCollect(data, count){
		if(count == 0){
			$('._tableBodyMembershipCollect').html('<tr>'
								+'    <td colspan="4" class="empty">입력된 정보가 없습니다.</td>'
								+'</tr>');
			$('._membership_collect_page').html('    <a href="#" class="pg_btn first"></a>'
								+'    <a href="#" class="pg_btn prev"></a>'
								+'    <a href="#" class="pg_btn active">1</a>'
								+'    <a href="#" class="pg_btn next"></a>'
								+'    <a href="#" class="pg_btn last"></a>');
			return;
		}
		var bodyData = '';
		for(var inx=0; inx<data.length; inx++){
			var no = (count - (mpageNo - 1)*mpageSize) - inx;
			bodyData = bodyData 
						+'<tr>'
						+'	<td>'+no+'</td>'
						+'	<td>'+data[inx].membership_name+'</td>'
						+'	<td>'+convertHistoryType(data[inx].hst_type)+'</td>'
						+'	<td>'+data[inx].create_dt+'</td>'
						+'</tr>';
		}
		if(count > 0)
		{
			var totSize = count;
			var totPagePt = Math.ceil(totSize / mpageSize);
			var pageStt = (Math.ceil(mpageNo/mpageSize)-1)*mpageSize +1;
			var pageEnd = Math.ceil(mpageNo/mpageSize)*mpageSize;
			pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
			var eventName = 'onclick'; var pageTmp = '';
			
			pageTmp+= '    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadListMembershipUsed(1)"' : '')+'></a>'
					+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadListMembershipUsed('+(pageStt-1)+')"' : '')+'></a>';
			for(var inx=pageStt; inx <= pageEnd; inx++)
			{
				pageTmp+='<a href="#" class="pg_btn '+(inx == mpageNo ? 'active' : '')+'" '+eventName+'="loadListMembershipUsed('+(inx)+')">'+(inx)+'</a>';
			}
			pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadListMembershipUsed('+(pageEnd+1)+')"' : '')+'></a>'
					+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadListMembershipUsed('+(totPagePt)+')"' : '')+'></a>';

			$('._membership_collect_page').html(pageTmp);
		}
		$('._tableBodyMembershipCollect').html(bodyData);
	}
	
	// 적립 팝업 열기
	function openPopMembershipCollect(){
		getMemberships();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-membership-collect'
			},
			type: 'inline'
		});
	}
	// 환불 팝업 열기
	function openPopMembershipRefund(){
		getMembershipRefund();
		$.magnificPopup.open({
			items: {
				src: '#mediboxpop-membership-refund'
			},
			type: 'inline'
		});
	}
</script>
