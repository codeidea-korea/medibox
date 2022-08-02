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
					<div class="view-list-label">멤버쉽번호</div>
					<div class="view-list-con">
						<input type="text" id="membership_card_no" name="membership_card_no" value="" class="span200" placeholder="멤버쉽 카드 정보가 들어갑니다.">
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" onclick="saveMembershipCardNo()" class="btn red small">저장</a>
					</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">비밀번호</div>
					<div class="view-list-con">
						<span class="_userPassword">****</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" onclick="resetPassword()" class="btn red small">비밀번호 초기화</a>
					</div>
<!--					
	                <div class="view-list-label">패키지</div>
					<div class="view-list-con _userPackage"></div>
					 -->
					<div class="view-list-label">멤버쉽</div>
					<div class="view-list-con _userMembership"></div>
				</div>
				<div class="view-list">
					<div class="view-list-label">이름</div>
					<div class="view-list-con">
						<span class="_userName">관리자</span>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#" onclick="gotoDetail()" class="btn green small">수정</a>
					</div>
					<div class="view-list-label">보유 포인트</div>
					<div class="view-list-con _userPoint">100,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">가입일시</div>
					<div class="view-list-con _createAt">2021.01128</div>
					<div class="view-list-label">보유 정액권</div>
					<div class="view-list-con _nail">네일정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">추천인 아이디/이름</div>
					<div class="view-list-con _recommandedUser"></div>
					<div class="view-list-label"></div>
					<div class="view-list-con _balmong">발몽정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">고객구분</div>
					<div class="view-list-con _userType">
					</div>
					<div class="view-list-label"></div>
					<div class="view-list-con _foresta">포레스타정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1,150,000 P</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">방문유형</div>
					<div class="view-list-con _userJoinPath"></div>
					<div class="view-list-label"></div>
					<div class="view-list-con"></div>
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

		@include('admin.members.section.point_table')
		<br>
		@include('admin.members.section.membership_table')
		<br>
		@include('admin.members.section.voucher_table')

	</section>
	
	<script>	

	var pointDetails = {};
	function getInfo(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchField]').val();
		
		var data = { adminSeqno:{{ $seqno }}, user_seqno:{{ $id }}, 
			rpageNo:rpageNo, rpageSize:rpageSize, upageNo:upageNo, upageSize:upageSize,
			vpageNo:vpageNo, vpageSize:vpageSize, mpageNo:mpageNo, mpageSize:mpageSize };

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
			$('#membership_card_no').val( response.data.membership_card_no );
			
			$('._userType').text( response.data.type ? response.data.type : '-' );
			$('._userJoinPath').text( response.data.join_path ? response.data.join_path : '-' );
			
			$('._createAt').text( response.data.create_dt );
			$('._userPackage').text( (response.data.packageHistory ? (response.data.packageHistory.point / 10000) + '만원' : '') );
			
			if(response.data.membership && response.data.membership.membershipInfo) {
				$('._userMembership').text( response.data.membership.membershipInfo.name + ' 멤버쉽 (' + medibox.methods.toNumber(response.data.membership.membershipInfo.price) + ')' );
			} else {
				$('._userMembership').text( '보유 멤버쉽이 없습니다.' );
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
			$('._userPackage').text( medibox.methods.toNumber(pointDetails.package.point) +' P');

			$('._nail').html('네일정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.nail.point) +' P');
			$('._balmong').html('발몽정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.balmong.point) +' P');
			$('._foresta').html('포레스타정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ medibox.methods.toNumber(pointDetails.foresta.point) +' P');

			generatePointUsed(response.data.pointUseHistory, response.data.pointUseHistoryCount);
			generatePointRefunded(response.data.pointPaidHistory, response.data.pointPaidHistoryCount);
			generateMembershipCollect(response.data.membershipHistory, response.data.membershipHistoryCount);
			generateVoucherCollect(response.data.voucherHistory, response.data.voucherHistoryCount);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function convertHistoryType(type) {
		switch(type){
			case 'U':
				return '사용';
			case 'S':
				return '충전';
			case 'R':
				return '환불';
			default:
				return '-';
		}
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
				@php
				if(session()->get('admin_type') == 'S') {
					echo 'if("'.$point_type.'" == response.data[inx].point_type || response.data[inx].point_type == "P" || response.data[inx].point_type == "K"){';
				}
				@endphp
				tmpPointTypes = tmpPointTypes + '<option value="'+response.data[inx].point_type+'">'+response.data[inx].point_name+'</option>';
				@php
				if(session()->get('admin_type') == 'S') {
					echo '}';
				}
				@endphp
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
	// 멤버쉽 카드 정보 저장
	function saveMembershipCardNo(){
		var membership_card_no = $('#membership_card_no').val();
		if(!membership_card_no || membership_card_no.length < 1) {
			alert('카드 번호를 입력해주세요.');
			return false;
		}

		medibox.methods.user.membershipCardNo({
			id: userInfo.user_phone
			, membership_card_no: membership_card_no
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('멤버쉽 카드정보가 수정 되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	function gotoDetail(){
		location.href = '/admin/members/'+{{ $id }};
	}
	</script>

</div>

@include('admin.pop.mediboxpop_point1')
@include('admin.pop.mediboxpop_point2')
@include('admin.pop.mediboxpop_point3')

@include('admin.pop.membership.collect')
@include('admin.pop.membership.refund')

@include('admin.pop.voucher.collect')
@include('admin.pop.voucher.refund')

@include('admin.footer')
