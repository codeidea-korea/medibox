
<div class="layer-popup" id="popCoupons">
	<button class="pop-closer" onclick="popHide()"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header"> 쿠폰 검색 </header>
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
								<col>
								<col>
								<col>
								<col>
								<col>
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
									<th><a href="#"> </a></th>
								</tr>
							</thead>
							<tbody id="_couponBody">
							</tbody>
						</table>
					</div>
				</div>
			</div>	
			<div id="_couponPage">
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
	var cPageNo = 1;
	var cPageSize = 10;
	var couponInfo;

	function loadCoupons(pageNo){
		cPageNo = pageNo;
		getCoupons();
	}
	
	function popOpenCoupon(){
		$('body, html').css('overflow', 'hidden');
		loadCoupons(1);
		$('#popCoupons').show();
	}

	function chooseCoupon(idx){
		// 선택 함수 호출 및 데이터 추가하고 팝업 닫기
		addCoupon(couponInfo[idx].name, couponInfo[idx].seqno);
		popHide();
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
	
	function getCoupons(){
		var couponName = $('#couponName').val();

		var data = { pageNo: cPageNo, pageSize: cPageSize, adminSeqno:{{ $seqno }} };

		if(couponName && couponName != '') {
			data.name = couponName;
		}

		medibox.methods.point.coupon.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
//			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('#_couponBody').html('<tr>'
									+'    <td colspan="5" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				$('#_couponPage').html('<nav class="pg_wrap">'
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
                var no = (response.count - (request.pageNo - 1)*cPageSize) - inx;
				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td>'
								+ (response.data[inx].coupon_partner_grp_seqno == 0 
									? '전체'
									: response.data[inx].partners.map(p => p.name)) +'</td>'
							+'	<td>'+response.data[inx].name+'</td>'
							+'	<td>'+response.data[inx].start_dt + ' ~ ' + response.data[inx].end_dt+'</td>'
							+'	<td>'+getAllowedIssuanceType(response.data[inx].allowed_issuance_type)+'</td>'
							+'	<td>'+getType(response.data[inx].type)+'</td>'
							+'	<td>'+getIssuanceType(response.data[inx].issuance_type)+'</td>'
							+'	<td>'+getConditionType(response.data[inx].issuance_condition_type)+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].discount_price)+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].limit_base_price)+'</td>'
							+'	<td><a href="#" onclick="chooseCoupon(\''+inx+'\')" class="btnEdit">선택</a></td>'
							+'</tr>';
			}
			couponInfo = response.data;
			$('#_couponBody').html(bodyData);

			if(response.count > 0)
			{
				var totSize = response.count;
				var totPagePt = Math.ceil(totSize / cPageSize);
				var pageStt = (Math.ceil(request.pageNo/cPageSize)-1)*cPageSize +1;
				var pageEnd = Math.ceil(request.pageNo/cPageSize)*cPageSize;
				pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
				var eventName = 'onclick'; var pageTmp = '';
				
				pageTmp+= '<nav class="pg_wrap">'
						+'    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadCoupons(1)"' : '')+'></a>'
						+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadCoupons('+(pageStt-1)+')"' : '')+'></a>';
				for(var inx=pageStt; inx <= pageEnd; inx++)
				{
					pageTmp+='<a href="#" class="pg_btn '+(inx == request.pageNo ? 'active' : '')+'" '+eventName+'="loadCoupons('+(inx)+')">'+(inx)+'</a>';
				}
				pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadCoupons('+(pageEnd+1)+')"' : '')+'></a>'
						+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadCoupons('+(totPagePt)+')"' : '')+'></a>'
						+'</nav>';

				$('#_couponPage').html(pageTmp);
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
</script>