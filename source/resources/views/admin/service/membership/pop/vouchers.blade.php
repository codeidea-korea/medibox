
<div class="layer-popup" id="popVouchers">
	<button class="pop-closer" onclick="popHide()"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header"> 바우처 검색 </header>
			<div class="wr-wrap line label130 padding10">
				<div class="wr-list" style="">
					<div style="width:100%;clear:both;height:5px;"></div>
					<div class="tbl-basic cell td-h1" style="">
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col>
								<col>
								<col>
							</colgroup>
							<thead>
								<tr>
									<th style="width: 80px;">번호</th>
									<th style="width: 300px;">매장명</th>
									<th style="width: 300px;">바우처이름</th>
									<th style="width: 200px;">금액</th>
									<th style="width: 100px;">상태</th>
									<th style="width: 200px;"> </th>
								</tr>
							</thead>
							<tbody id="_voucherBody">
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div id="_voucherPage">
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

			<div class="btnSet">
				<a href="#" class="btn large gray popClose" onclick="popHide()">닫기</a>
			</div>
		</div>
	</div>

	<div class="pop-bg"></div>
</div>

<script>	
	var vPageNo = 1;
	var vPageSize = 10;
	var voucherInfo;

	function loadVouchers(pageNo){
		vPageNo = pageNo;
		getVouchers();
	}
	
	function popOpenVoucher(){
		$('body, html').css('overflow', 'hidden');
		loadVouchers(1);
		$('#popVouchers').show();
	}

	function chooseVoucher(idx){
		// 선택 함수 호출 및 데이터 추가하고 팝업 닫기
		addSubVoucher(voucherInfo[idx].name, voucherInfo[idx].unit_count, voucherInfo[idx].seqno);
		popHide();
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
	
	function getVouchers(){
		var voucherName = $('#voucherName').val();

		var data = { pageNo: vPageNo, pageSize: vPageSize, adminSeqno:{{ $seqno }}, include_discontinued: 'Y' };

		if(voucherName && voucherName != '') {
			data.name = voucherName;
		}

		medibox.methods.point.vouchers.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
//			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('#_voucherBody').html('<tr>'
									+'    <td colspan="6" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				$('#_voucherPage').html('<nav class="pg_wrap">'
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
                var no = (response.count - (request.pageNo - 1)*vPageSize) - inx;				
				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td>'+(response.data[inx].storeInfo ? response.data[inx].storeInfo.name : '-')+'</td>'
							+'	<td>'+response.data[inx].name+'</td>'
							+'	<td>'+response.data[inx].price+'</td>'
//							+'	<td>'+getDateType(response.data[inx].date_use)+'</td>'
//							+'	<td>'+medibox.methods.toNumber(response.data[inx].unit_count)+'</td>'
							+'	<td>'+(response.data[inx].deleted == 'Y' ? '단종' : '판매')+'</td>'
							+'	<td>'+(response.data[inx].deleted == 'Y' ? '-' : '<a href="#" onclick="chooseVoucher(\''+inx+'\')" class="btnEdit">선택</a>')+'</td>'
							+'</tr>';
			}
			voucherInfo = response.data;
			$('#_voucherBody').html(bodyData);

			if(response.count > 0)
			{
				var totSize = response.count;
				var totPagePt = Math.ceil(totSize / vPageSize);
				var pageStt = (Math.ceil(request.pageNo/vPageSize)-1)*vPageSize +1;
				var pageEnd = Math.ceil(request.pageNo/vPageSize)*vPageSize;
				pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
				var eventName = 'onclick'; var pageTmp = '';
				
				pageTmp+= '<nav class="pg_wrap">'
						+'    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadVouchers(1)"' : '')+'></a>'
						+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadVouchers('+(pageStt-1)+')"' : '')+'></a>';
				for(var inx=pageStt; inx <= pageEnd; inx++)
				{
					pageTmp+='<a href="#" class="pg_btn '+(inx == request.pageNo ? 'active' : '')+'" '+eventName+'="loadVouchers('+(inx)+')">'+(inx)+'</a>';
				}
				pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadVouchers('+(pageEnd+1)+')"' : '')+'></a>'
						+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadVouchers('+(totPagePt)+')"' : '')+'></a>'
						+'</nav>';

				$('#_voucherPage').html(pageTmp);
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
</script>