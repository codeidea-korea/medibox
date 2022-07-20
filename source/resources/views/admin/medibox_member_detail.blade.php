
@php 
$page_title = $id == 0 ? '회원등록' : '회원수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">회원정보 @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			@php 
			if($id != 0) {
			@endphp
			<div class="wr-list">
				<div class="wr-list-label">고객 번호</div>
				<div class="wr-list-con" id="userSeqno"></div>
			</div>
			@php 
			}
			@endphp
			<div class="wr-list">
				<div class="wr-list-label required">아이디<br/>(핸드폰번호)</div>
				<div class="wr-list-con">
					<input type="text" id="userId" name="" value="" class="span200" placeholder="010-0000-0000" @php echo $id == 0 ? '' : 'disabled'; @endphp maxlength="20">@php echo $id == 0 ? '<a href="#" onclick="checkValidationIdDupplicated()" class="btn black ml5">중복조회</a>' : ''; @endphp
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label required">@php echo $id == 0 ? '등록할' : '현재'; @endphp 비밀번호</div>
				<div class="wr-list-con">
					<input type="password" id="userPassword" name="" value="" class="span200" placeholder="" maxlength="20">
				</div>
			</div>
			@php
			if($id != 0) {
			@endphp
				<div class="wr-list">
					<div class="wr-list-label">새로운 비밀번호</div>
					<div class="wr-list-con">
						<input type="password" id="userPassword2" name="" value="" class="span200" placeholder="" maxlength="20"><a href="#" onclick="passwordChange()" class="btn black ml5">비밀번호 변경</a>
						<p>*새로운 비밀번호 미기입 후 변경버튼 클릭시, 비밀번호가 1234로 변경됩니다.</p>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">새로운 비밀번호 확인</div>
					<div class="wr-list-con">
						<input type="password" id="userPassword3" name="" value="" class="span200" placeholder="" maxlength="20">
					</div>
				</div>
			@php
			}
			@endphp
			<div class="wr-list">
				<div class="wr-list-label required">이름</div>
				<div class="wr-list-con">
					<input type="text" id="userName" name="" value="" class="span200" placeholder="" maxlength="20">
				</div>
			</div>
			
			<div class="wr-list">
				<div class="wr-list-label">성별</div>
				<div class="wr-list-con">
					<label class="radio-btn"><input type="radio" name="gender" value="M" class="" data-label="남자" checked=""><span>남</span></label>
					<label class="radio-btn"><input type="radio" name="gender" value="W" class="" data-label="여자"><span>여</span></label>
				</div>
			</div>

			<div class="wr-list">
				<div class="wr-list-label">이메일</div>
				<div class="wr-list-con">
					<input type="text" id="userEmail" name="" value="" class="span200" placeholder="">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">주소</div>
				<div class="wr-list-con">
					<input type="text" id="address" name="" value="" class="span200" placeholder="">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">상세 주소</div>
				<div class="wr-list-con">
					<input type="text" id="address_detail" name="" value="" class="span200" placeholder="">
				</div>
			</div>
			{{--
			<div class="wr-list">
				<div class="wr-list-label">고객등급</div>
				<div class="wr-list-con">
					<select class="default" id="grade">
					<!-- 기획서에 추후 제공예정/내용 없음 -->
						<option value="">선택해주세요.</option>
					</select>
				</div>
			</div>
			--}}
			<div class="wr-list">
				<div class="wr-list-label">고객메모</div>
				<div class="wr-list-con">
					<textarea type="text" id="memo" name="memo" value="" style="height: 60px; resize: none;min-height: 60px;"></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">추천인 아이디</div>
				<div class="wr-list-con">
					<input type="text" id="recommended_code" name="recommended_code" value="" class="span200" placeholder="">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">고객구분</div>
				<div class="wr-list-con">
					<select class="default" id="type">
					<!-- 기획서에 추후 제공예정/내용 없음 -->
						<option value="">선택해주세요.</option>
						<option value="VIP">VIP</option>
						<option value="일반">일반</option>
					</select>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">방문유형</div>
				<div class="wr-list-con">
					<select class="default" id="join_path">
						<option value="">선택해주세요.</option>
						<option value="미니쉬직원">미니쉬직원</option>
						<option value="강원장님소개">강원장님소개</option>
						<option value="미니쉬중요고객">미니쉬중요고객</option>
						<option value="주주">주주</option>
					</select>
				</div>
			</div>
			@php 
			if($id != 0) {
			@endphp
			<div class="wr-list">
				<div class="wr-list-label">고객가입일</div>
				<div class="wr-list-con" id="joinTime"></div>
			</div>
			@php 
			}
			@endphp
			<div class="wr-list">
				<div class="wr-list-label required">최초추천샵</div>
				<div class="wr-list-con">
					<select class="default" id="recommended_shop">
					<!-- 사용자쪽 가입/프로필 수정과 일치화 해야함 -->
						<option value="포레스타 블랙">포레스타 블랙</option>
						<option value="바라는 네일">바라는 네일</option>
						<option value="딥포커스 검안센터">딥포커스 검안센터</option>
						<option value="발몽스파">발몽스파</option>
						<option value="미니쉬 도수">미니쉬 도수</option>
						<option value="미니쉬 스파">미니쉬 스파</option>
						<option value="미니쉬 치과병원">미니쉬 치과병원</option>
						<option value="기타">기타</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($id != 0) {
		@endphp
		<a href="#" onclick="modify()" class="btn green">수정</a>
		<a href="#" onclick="remove()" class="btn red">삭제</a>
		@php 
		}
		@endphp
		@php
		if($id == 0) {
		@endphp
		<a href="#" onclick="join()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/members';
	}
	function checkValidation(){
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;
		var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
		var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

		if(!id || id == '') {
			alert('올바른 휴대폰 번호를 입력해주세요.');
			return false;
		}
		if (regPhone.test(id) !== true) {
			alert('올바른 휴대폰 번호를 입력해주세요.');
			return false;
		}
		if (!pw || pw == '') {
			alert('비밀번호를 입력해주세요.');
			return false;
		}
		@php
		if($id == 0) {
		@endphp
		if (regPw.test(pw) !== true) {
			alert('비밀번호는 8자 이상  숫자, 알파벳, 특수기호를 혼합하여 입력해주세요. ');
			return false;
		}
		@php 
		}
		@endphp
		if(!name || name == '') {
			alert('이름을 입력해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($id == 0) {
	@endphp
	var isDupplicated = true;
	function checkValidationIdDupplicated(){
		var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
		var id = document.querySelector('#userId').value;

		if (!id || id == '' || regPhone.test(id) !== true) {
			alert('올바른 휴대폰 번호를 입력해주세요.');
			return false;
		}

		medibox.methods.user.isDupplicated({
			id: id
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert('중복된아이디가 있습니다. \r다른아이디를 등록해주세요.');
				isDupplicated = true;
				return false;
			}
			alert('사용 가능한 아이디입니다.');
			isDupplicated = false;
			return true;
		}, function(e){
			console.log(e);
		});
	}
	function join(){
		if(!checkValidation()) {
			return;
		}
		if(isDupplicated) {
			alert('아이디 중복 체크를 해주세요.');
			return false;
		}
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;
		
		var gender = $('input[name=gender]:checked').val();
		var userEmail = $('#userEmail').val();
		var address = $('#address').val();
		var address_detail = $('#address_detail').val();
		/*
		var grade = $('#grade').val();
		*/
		var type = $('#type').val();
		var memo = $('#memo').val();
		var recommended_code = $('#recommended_code').val();
		var recommended_shop = $('#recommended_shop').val();
		var join_path = $('#join_path').val();

		medibox.methods.user.add({
			id: id
			, pw: pw
			, name: name
			
			, gender: gender
			, email: userEmail
			, address: address
			, address_detail: address_detail
			, grade: ''
			, type: type
			, memo: memo
			, recommended_code: recommended_code
			, recommended_shop: recommended_shop
			, join_path: join_path

			, event_yn: 'Y'
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('추가 되었습니다.');
			window.location.href = '/admin/members';
		}, function(e){
			console.log(e);
		});
	}
	@php
	}
	@endphp
	// 수정일 경우
	@php
	if($id != 0) {
	@endphp
	userId = {{$id}}
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;
		
		var gender = $('input[name=gender]:checked').val();
		var userEmail = $('#userEmail').val();
		var address = $('#address').val();
		var address_detail = $('#address_detail').val();
//		var grade = $('#grade').val();
		var type = $('#type').val();
		var memo = $('#memo').val();
		var recommended_code = $('#recommended_code').val();
		var recommended_shop = $('#recommended_shop').val();
		var join_path = $('#join_path').val();

		medibox.methods.user.modify({
			id: userId
			, pw: pw
			, pw2: pw
			, name: name
			
			, gender: gender
			, email: userEmail
			, address: address
			, address_detail: address_detail
			, grade: ''
			, type: type
			, memo: memo
			, recommended_code: recommended_code
			, recommended_shop: recommended_shop
			, join_path: join_path
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			window.location.href = '/admin/members';
		}, function(e){
			console.log(e);
		});
	}
	function checkValidation2(){
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;
		var pw2 = document.querySelector('#userPassword2').value;
		var pw3 = document.querySelector('#userPassword3').value;
		var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
		var regPw = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;

		if(!id || id == '') {
			alert('올바른 휴대폰 번호를 입력해주세요.');
			return false;
		}
		if (regPhone.test(id) !== true) {
			alert('올바른 휴대폰 번호를 입력해주세요.');
			return false;
		}
		if (!pw || pw == '') {
			alert('비밀번호를 입력해주세요.');
			return false;
		}
		if (!pw2 || pw2 == '') {
			pw2 = '1234';
			pw3 = '1234';
		} else {
			if (!pw3 || pw3 == '') {
				alert('변경할 새 비밀번호 확인을 입력해주세요.');
				return false;
			}
			if (pw2 != pw3) {
				alert('변경할 새 비밀번호 확인이 일치하지 않습니다.');
				return false;
			}
		}

		return true;
	}
	function passwordChange(){
		if(!checkValidation2()) {
			return;
		}
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var pw2 = document.querySelector('#userPassword2').value;
		var name = document.querySelector('#userName').value;
		if (!pw2 || pw2 == '') {
			pw2 = '1234';
		}

		medibox.methods.user.modify({
			id: userId
			, pw: pw
			, pw2: pw2
			, name: name
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			window.location.href = '/admin/members';
		}, function(e){
			console.log(e);
		});
	}
	function getInfo(){
		var data = { pageNo: 1, pageSize: 10, adminSeqno:{{ $seqno }}, user_seqno:'{{ $id }}' };

		medibox.methods.user.member(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#userId').text( response.data.user_phone );
			$('#userPassword').text( response.data.user_pw );
			$('#userName').text( response.data.user_name );
			$('#userId').val( response.data.user_phone );
			$('#userPassword').val( response.data.user_pw );
			$('#userName').val( response.data.user_name );
			
			$('#userSeqno').text( response.data.user_seqno );
			$('#gender').val( response.data.gender );
			$('#userEmail').val( response.data.email );
			$('#address').val( response.data.address );
			$('#address_detail').val( response.data.address_detail );
			$('#grade').val( response.data.grade );
			$('#type').val( response.data.type );
			$('#memo').val( response.data.memo );
			$('#recommended_code').val( response.data.recommended_code );
			$('#joinTime').text( response.data.create_dt );
			$('#recommended_shop').val( response.data.recommended_shop );
			$('#join_path').val( response.data.join_path );

			userId = response.data.user_phone; 
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('정말 탈퇴처리 하시겠습니까?')) {
			return;
		}
		medibox.methods.user.delete({
			id: userId
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('탈퇴 되었습니다.');
			window.location.href = '/admin/members';
		}, function(e){
			console.log(e);
		});
	}
	$(document).ready(function(){
		getInfo();
	});
	@php
	}
	@endphp
	</script>
</section>

@include('admin.footer')
