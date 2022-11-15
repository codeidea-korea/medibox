
@php 
$page_title = $id == 0 ? '회원등록' : '회원수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">회원정보 @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">아이디<br/>(핸드폰번호)</div>
				<div class="wr-list-con">
					<input type="text" id="userId" name="" value="" class="span200" placeholder="010-0000-0000" @php echo $id == 0 ? '' : 'disabled'; @endphp maxlength="20">@php echo $id == 0 ? '<a href="#" onclick="checkValidationIdDupplicated()" class="btn black ml5">중복조회</a>' : ''; @endphp
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">@php echo $id == 0 ? '등록할' : '현재'; @endphp 비밀번호</div>
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
				<div class="wr-list-label">이름</div>
				<div class="wr-list-con">
					<input type="text" id="userName" name="" value="" class="span200" placeholder="" maxlength="20">
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
		if (regPw.test(pw) !== true) {
			alert('비밀번호는 8자 이상 숫자와 알파벳을 혼합하여 입력해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($id == 0) {
	@endphp
	var isDupplicated = false;
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
			return false;
		}
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;

		medibox.methods.user.add({
			id: id
			, pw: pw
			, name: name
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

		medibox.methods.user.modify({
			id: userId
			, pw: pw
			, pw2: pw
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
