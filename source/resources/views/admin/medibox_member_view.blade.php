@php 
$page_title = '회원관리';
@endphp
@include('admin.header')

<div id="background" class="container">

	<div class="page-title">회원 정보</div>

	<section>

		<div class="flexbox">
			<div class="view-wrap label160">
				<div class="view-list">
					<div class="view-list-label flexbox-header">회원정보</div>
					<div class="view-list-con"></div>
					<div class="view-list-label flexbox-header">보유포인트</div>
					<div class="view-list-con"></div>
				</div>
				<div class="view-list">
					<div class="view-list-label">아이디</div>
					<div class="view-list-con _userId">010-0000-0000</div>
					<div class="view-list-label">멤버쉽</div>
					<div class="view-list-con _userMembership"></div>
				</div>
				<div class="view-list">
					<div class="view-list-label">비밀번호</div>
					<div class="view-list-con">
						<span class="_userPassword">****</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" onclick="resetPassword()" class="btn red small">비밀번호 초기화</a>
					</div>
					<div class="view-list-label">패키지</div>
					<div class="view-list-con _userPackage"></div>
				</div>
				<div class="view-list">
					<div class="view-list-label">이름</div>
					<div class="view-list-con _userName">관리자</div>
					<div class="view-list-label">포인트</div>
					<div class="view-list-con _userPoint">100,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">가입일시</div>
					<div class="view-list-con _createAt">2021.01128</div>
					<div class="view-list-label">정액권</div>
					<div class="view-list-con _nail">네일정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">추천인 아이디/이름</div>
					<div class="view-list-con _recommandedUser"></div>
					<div class="view-list-label"></div>
					<div class="view-list-con _balmong">발몽정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">&nbsp;</div>
					<div class="view-list-con">
					&nbsp;
					</div>
					<div class="view-list-label"></div>
					<div class="view-list-con _foresta">포레스타정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1,150,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">메모</div>
					<div class="view-list-con" style="display: flex;padding-right: 60px;">
						<textarea type="text" id="usermemo" name="usermemo" value="" style="height: 60px; resize: none;min-height: 60px;"></textarea>
						<button onclick="modifyMemo()" class="btn black ml5" style="height: 60px;width: 60px;">수정</button> 
					</div>
					<div class="view-list-label">메모2</div>
					<div class="view-list-con" style="display: flex;padding-right: 60px;">
						<textarea type="text" id="usermemo2" name="usermemo2" value="" style="height: 60px; resize: none;min-height: 60px;"></textarea>
						<button onclick="modifyMemo2()" class="btn black ml5" style="height: 60px;width: 60px;">수정</button> 
					</div>
				</div>

			</div>
		</div>


		<!--
			멤버쉽, (적립/환불)
			멤버쉽 - 메인 바우처 (사용/환불 승인/취소)
			멤버쉽 - 서브 바우처 (--)
			쿠폰 적립

			( -- 기존 --
			포인트 충전/환불 - 기존
			포인트 사용 - 기존
			정액권 적립/환불
			정액권 사용
			패키지 적립/환불
			)
		 -->

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
						<tr>
							<td>4</td>
							<td>포인트</td>
							<td><span class="color-red">환불</span></td>
							<td><span class="color-red">-100,000</span></td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<tr>
							<td>3</td>
							<td>포인트-패키지-50</td>
							<td>적립</td>
							<td>500,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<tr>
							<td>2</td>
							<td>정액권-발몽-300</td>
							<td>적립</td>
							<td>3,750,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<tr>
							<td>1</td>
							<td>포인트-통합정액권-300</td>
							<td>적립</td>
							<td>3,300,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<!--<tr>
							<td class="empty" colspan="6">입력된 정보가 없습니다.</td>
						</tr>--><!-- 목록 없을때-->
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
						</tr>
					</thead>
					<tbody class="_tableBodyUsed">
						<tr>
							<td>3</td>
							<td>포인트</td>
							<td>사용</td>
							<td>발몽스파</td>
							<td>미니쉬스페셜 90분</td>
							<td>-10,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<tr>
							<td>2</td>
							<td>정액권-발몽</td>
							<td>사용</td>
							<td>발몽스파</td>
							<td>에너지 30분</td>
							<td>-136,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<tr>
							<td>1</td>
							<td>포인트</td>
							<td>사용</td>
							<td>발몽스파</td>
							<td>미니쉬스페셜 90분</td>
							<td>-10,000</td>
							<td class="date">22.01.20</td>
							<td>담당자 메모...</td>
						</tr>
						<!--<tr>
							<td class="empty" colspan="7">입력된 정보가 없습니다.</td>
						</tr>--><!-- 목록 없을때-->
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

	</section>
	
	<script>	
	// 사용자 정보 로드 adminSeqno:{{ $seqno }}, 파람 id
	// 포인트 충전 / 환불
	// 포인트 사용
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
								+'    <td colspan="9" class="empty">입력된 정보가 없습니다.</td>'
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
								)
						)

						+'	<td>'+(data[inx].product_seqno == 0 ? data[inx].shop_name : data[inx].service_name)+'</td>'
						+'	<td>'+(data[inx].product_seqno == 0 
							? data[inx].product_name 
							: (data[inx].type_name + (data[inx].service_sub_name ? data[inx].service_sub_name : ''))) +'</td>'

						+'	<td>-'+medibox.methods.toNumber(data[inx].point)+'</td>'
						+'	<td>'+data[inx].create_dt+'</td>'
						+'	<td>'+(data[inx].admin_name && data[inx].admin_name != 'null' ? data[inx].admin_name : '')+'</td>'
						+'	<td>'+(data[inx].memo ? data[inx].memo : '')+'</td>'
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
	var pointDetails = {};
	function getInfo(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchField]').val();
		
		var data = { adminSeqno:{{ $seqno }}, user_seqno:{{ $id }}, 
			rpageNo:rpageNo, rpageSize:rpageSize, upageNo:upageNo, upageSize:upageSize };

		medibox.methods.user.member(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			userInfo = response.data;
			
			$('._userId').text( response.data.user_phone );
			var password_mask = '';
			for(var inx = 0; inx < response.data.user_pw.length; inx++){
				password_mask = password_mask + '*';
			}
			$('._userPassword').text( password_mask );
			$('._userName').text( response.data.user_name );
			$('#usermemo').val( response.data.memo );
			$('#usermemo2').val( response.data.memo2 );
			$('._createAt').text( response.data.create_dt );
			$('._userPackage').text( (response.data.packageHistory ? (response.data.packageHistory.point / 10000) + '만원' : '') );
			
			if(response.data.membershipHistory && response.data.membershipHistory.membership) {
				$('._userMembership').text( response.data.membershipHistory.membership.name );
			}
			if(response.data.recommendedUser) {
				$('._recommandedUser').text( response.data.recommendedUser.user_phone + ' / ' + response.data.recommendedUser.user_name );
			}

			// TODO: 매핑 테이블 추가 필요
			pointDetails.point = response.data.points.filter(a => a.point_type == 'P')[0];
			pointDetails.package = response.data.points.filter(a => a.point_type == 'K')[0];
			pointDetails.all = response.data.points.filter(a => a.point_type == 'S1')[0];
			pointDetails.nail = response.data.points.filter(a => a.point_type == 'S2')[0];
			pointDetails.balmong = response.data.points.filter(a => a.point_type == 'S3')[0];
			pointDetails.foresta = response.data.points.filter(a => a.point_type == 'S4')[0];

			$('._userPoint').text( medibox.methods.toNumber(pointDetails.point.point) +' P');
			$('._nail').html('네일정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.nail.point) +' P');
			$('._balmong').html('발몽정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.balmong.point) +' P');
			$('._foresta').html('포레스타정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.foresta.point) +' P');

			generatePointUsed(response.data.pointUseHistory, response.data.pointUseHistoryCount);
			generatePointRefunded(response.data.pointPaidHistory, response.data.pointPaidHistoryCount);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getPoint(type){
		var point;
		switch(type) {
			case 'P':
				point = pointDetails.point.point;
				break;
			case 'K':
				point = pointDetails.package.point;
				break;
			case 'S1':
				point = pointDetails.all.point;
				break;
			case 'S2':
				point = pointDetails.nail.point;
				break;
			case 'S3':
				point = pointDetails.balmong.point;
				break;
			case 'S4':
				point = pointDetails.foresta.point;
				break;
			default:
				point = pointDetails.point.point;
				break;
		}
		return point;
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
	$(document).ready(function(){
		getInfo();
	});
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
	function replacePoint(amount){
		return amount.replace(/P/gi, "").replace(/p/gi, "").replace(/ /gi, "").replace(/,/gi, "");
	}
	function modifyMemo(){
		var memo = $('#usermemo').val();
		if(!memo || memo.length < 1) {
			alert('메모 내용을 입력해주세요.');
			return false;
		}
		
		medibox.methods.user.memoModify({
			user_seqno:{{ $id }}
			, memo: memo
			, type: 1
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('메모가 저장되었습니다.');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function modifyMemo2(){
		var memo = $('#usermemo2').val();
		if(!memo || memo.length < 1) {
			alert('메모 내용을 입력해주세요.');
			return false;
		}
		
		medibox.methods.user.memoModify({
			user_seqno:{{ $id }}
			, memo: memo
			, type: 2
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('메모가 저장되었습니다.');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var userInfo;
	function resetPassword(){
		if(!confirm('비밀번호 초기화를 하시겠습니까? \n이 작업은 되돌릴 수 없습니다.\n비밀번호는 [1234]로 초기화 됩니다.')){
			return false;
		}
		userInfo.pw2 = '1234';

		medibox.methods.user.modify({
			id: userInfo.user_phone
			, pw: userInfo.user_pw
			, pw2: '1234'
			, name: userInfo.user_name
			, gender: userInfo.gender
			, email: userInfo.email
			, address: userInfo.address
			, address_detail: userInfo.address_detail
			, type: userInfo.type
			, memo: userInfo.memo
			, recommended_code: userInfo.recommended_code
			, recommended_shop: userInfo.recommended_shop
			, join_path: userInfo.join_path
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('비밀번호가 초기화 되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	
	function getTypes(fnCallback){
		medibox.methods.point.types({}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpPointTypes = '';
			for(var inx = 0; inx < response.data.length; inx++){
				tmpPointTypes = tmpPointTypes + '<option value="'+response.data[inx].point_type+'">'+response.data[inx].point_name+'</option>';
			}
			$('._pointTypes').html(tmpPointTypes);

			fnCallback();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	// 승인
	function approveUsePoint(seqno){
		if(! confirm('포인트 사용을 승인합니다.')) {
			return false;
		}
		medibox.methods.point.approve({
			admin_seqno: {{ $seqno }},
			admin_name: '',
			user_seqno: {{ $id }},
			hst_seqno: seqno
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('사용되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	// 취소
	function cancelUsePoint(seqno){
		if(! confirm('포인트 사용을 취소합니다.')) {
			return false;
		}
		medibox.methods.point.cancel({
			admin_seqno: {{ $seqno }},
			admin_name: '',
			user_seqno: {{ $id }},
			hst_type: 'U',
			hst_seqno: seqno
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('취소되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	// 사용 취소
	</script>

</div>

@include('admin.pop.mediboxpop_point1')
@include('admin.pop.mediboxpop_point2')
@include('admin.pop.mediboxpop_point3')

@include('admin.footer')
