
@php 
$page_title = $id == 0 ? '제휴사 등록' : '제휴사 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">제휴사 정보 @php echo $id == 0 ? '등록' : '수정'; @endphp</div>
	<div class="wrtieContents" style="flex-direction:column;">
		<div class="wr-wrap line label160">
			<div class="wr-head"> 기본 정보 </div>
			<div class="wr-list">
				<div class="wr-list-label">회사명</div>
				<div class="wr-list-con">
					<input type="text" id="cop_name" maxlength="30" name="" value="" class="span200" placeholder="제휴사명을 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">사업자 등록번호</div>
				<div class="wr-list-con">
					<input type="text" id="cop_no" maxlength="30" name="" value="" class="span200" placeholder="000-00-00000">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">사업자 등록증 첨부</div>
				<div class="wr-list-con">
					<div class="filebox">
						<input type="text" placeholder="선택된 파일이 없습니다." id="cop_file" class="upload-name" disabled="disabled">
						<label for="upload_0" class="upload-btn">파일찾기
							<input name="" type="file" multiple="" id="upload_0" class="upload-hidden" onchange="uploadFile(this, 'cop_file')">
						</label>
					</div>
					<p class="help-block">
						※ 이미지 확장자는 PNG, JPG, JPEG 만 가능합니다.<br>
					</p>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">사업자 전화번호</div>
				<div class="wr-list-con">
					<input type="text" id="cop_phone" maxlength="13" name="" value="" class="span200" placeholder="1566-1566">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">통신판매신고번호</div>
				<div class="wr-list-con">
					<input type="text" id="online_order_business_no" maxlength="30" name="" value="" class="span200" placeholder="000-00-00000">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">통신판매신고증 첨부</div>
				<div class="wr-list-con">
					<div class="filebox">
						<input type="text" placeholder="선택된 파일이 없습니다." id="online_order_business_file" class="upload-name" disabled="disabled">
						<label for="upload_1" class="upload-btn">파일찾기
							<input name="" type="file" multiple="" id="upload_1" class="upload-hidden" onchange="uploadFile(this, 'online_order_business_file')">
						</label>
					</div>
					<p class="help-block">
						※ 이미지 확장자는 PNG, JPG, JPEG 만 가능합니다.<br>
					</p>
				</div>
			</div>
		</div>
		<br>
		<div class="wr-wrap line label160">
			<div class="wr-head"> 담당자 정보 </div>
			<div class="wr-list">
				<div class="wr-list-label">담당자 이름</div>
				<div class="wr-list-con">
					<input type="text" id="director_name" maxlength="30" name="" value="" class="span200" placeholder="담당자 이름을 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">담당자 휴대폰</div>
				<div class="wr-list-con">
					<input type="text" id="director_phone" maxlength="13" name="" value="" class="span200" placeholder="담당자 전화번호를 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">담당자 이메일</div>
				<div class="wr-list-con">
					<input type="text" id="director_email" maxlength="50" name="" value="" class="span200" placeholder="담당자 이메일을 기입해주세요.">
				</div>
			</div>
		</div>
		<!--
		<br>
		<div class="wr-wrap line label160">
			<div class="wr-head"> 제휴사 마이페이지 </div>
			<div class="wr-list">
				<div class="wr-list-label">아이디</div>
				<div class="wr-list-con">
					<input type="text" id="admin_id" maxlength="30" name="" value="" class="span200" placeholder="아이디를 기입해주세요.">
				</div>
				<div class="wr-list-label">현재 비밀번호 확인</div>
				<div class="wr-list-con">
					<input type="text" id="admin_pw" name="" value="" maxlength="20" class="span200" placeholder="기존 비밀번호를 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">회원 탈퇴</div>
				<div class="wr-list-con">
					<a href="#" onclick="remove()" class="btn red ml5">회원 탈퇴</a>
				</div>
				<div class="wr-list-label">새로운 비밀번호</div>
				<div class="wr-list-con">
					<input type="text" id="admin_new_pw" name="" value="" maxlength="20" class="span200" placeholder="새로운 비밀번호를 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">&nbsp;</div>
				<div class="wr-list-con">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
				<div class="wr-list-label">새로운 비밀번호 확인</div>
				<div class="wr-list-con">
					<input type="text" id="admin_new_pw_confirm" name="" maxlength="20" value="" class="span200" placeholder="새로운 비밀번호 확인을 기입해주세요.">
				</div>
			</div>
		</div>
		-->
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($id != 0) {
		@endphp
		
		<a href="#" onclick="modify()" class="btn blue">수정</a>
		@php 
		}
		@endphp
		@php
		if($id == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
	var imgPoint = 1;
	var pictures = [];
	var maxLength = 5;

	function uploadFile(target, returnInput){
		if(imgPoint > maxLength) {
			alert('매장 사진은 최대 5장 등록이 가능합니다.');
			return false;
		}
		if(!$(target) || !$(target)[0] || !$(target)[0].files[0]) {
			return false;
		}

		var form = new FormData();
		form.append( "upload", $(target)[0].files[0] );
		
		jQuery.ajax({
			url : "/api/file/store"
			, type : "POST"
			, processData : false
			, contentType : false
			, data : form
			, async: false
			, success:function(response) {
				console.log('output : ' + response);
				if(!response.result){
					alert(response.ment);
					return false;
				}
				$('#'+returnInput).val('/storage/'+response.path);
			}
			,error: function (jqXHR) 
			{ 
				alert(jqXHR.responseText); 
			}
		});
	}
	var userId;
	function cancel(){
		window.location.href = '/admin/partners';
	}
	function checkValidation(){
		var regPhone = /^01([0|1|6|7|8|9])-?([0-9]{3,4})-?([0-9]{4})$/;
		var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/;
		var regxPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/; // regx.test(pw_1) !== true
		
		var cop_name = $('#cop_name').val();
		var cop_no = $('#cop_no').val();
		var cop_file = $('#cop_file').val();
		var cop_phone = $('#cop_phone').val();
		var online_order_business_no = $('#online_order_business_no').val();
		var online_order_business_file = $('#online_order_business_file').val();
		var director_name = $('#director_name').val();
		var director_phone = $('#director_phone').val();
		var director_email = $('#director_email').val();
		/*
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_new_pw = $('#admin_new_pw').val();
		var admin_new_pw_confirm = $('#admin_new_pw_confirm').val();
		*/
        
		if(!cop_name || cop_name == '') {
//			alert('제휴사명을 입력해주세요.');
			return false;
		}
		if (!cop_no || cop_no == '') {
//			alert('사업자등록번호를 입력해주세요.');
			return false;
		}
		if (!cop_file || cop_file == '') {
//			alert('사업자등록번증을 업로드해주세요.');
			return false;
		}
		if (!cop_phone || cop_phone == '') {
//			alert('사업자 전화번호를 입력해주세요.');
			return false;
		}
		if (!online_order_business_no || online_order_business_no == '') {
//			alert('통신판매신고번호를 입력해주세요.');
			return false;
		}
		if (!online_order_business_file || online_order_business_file == '') {
//			alert('통신판매신고증을 업로드해주세요.');
			return false;
		}
		if (!director_name || director_name == '') {
//			alert('담당자 이름을 입력해주세요.');
			return false;
		}
		if (!director_phone || director_phone == '' || regPhone.test(director_phone) !== true) {
//			alert('담당자 전화번호를 입력해주세요.');
			return false;
		}
		if (!director_email || director_email == '' || regEmail.test(director_email) !== true) {
//			alert('담당자 이메일을 입력해주세요.');
			return false;
		}
		/*
		if (!admin_id || admin_id == '') {
//			alert('제휴사 아이디를 입력해주세요.');
			return false;
		}
		if (!admin_pw || admin_pw == '') {
//			alert('제휴사 비밀번호를 입력해주세요.');
			return false;
		}
		if (!admin_new_pw || admin_new_pw == '') {
			if (!admin_new_pw_confirm || admin_new_pw_confirm == '') {
				alert('새로운 비밀번호 확인을 입력해주세요.');
				return false;
			}
			if (admin_new_pw != admin_new_pw_confirm) {
				alert('새로운 비밀번호와 비밀번호 확인이 다릅니다. 비밀번호를 확인해주세요.');
				return false;
			}
			if (regxPassword.test(admin_new_pw) !== true) {
				alert('비밀번호는 영문과 숫자 조합으로만 가능하며 8자이상 20자 이하로 작성해주세요.');
				return false;
			}
		}
		*/

		return true;
	}
	// 등록일 경우
	@php
	if($id == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
//			alert('제휴사 정보가 정확하지 않습니다.\n정보를 다시 한번 확인해주세요.');
			alert('전체 항목을 입력해주세요 ');
			return;
		}
		var cop_name = $('#cop_name').val();
		var cop_no = $('#cop_no').val();
		var cop_file = $('#cop_file').val();
		var cop_phone = $('#cop_phone').val();
		var online_order_business_no = $('#online_order_business_no').val();
		var online_order_business_file = $('#online_order_business_file').val();
		var director_name = $('#director_name').val();
		var director_phone = $('#director_phone').val();
		var director_email = $('#director_email').val();
		/*
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_new_pw = $('#admin_new_pw').val();
		var admin_new_pw_confirm = $('#admin_new_pw_confirm').val();
		*/

		medibox.methods.partner.add({
			cop_name: cop_name
			, cop_no: cop_no
			, cop_file: cop_file
			, cop_phone: cop_phone
			, online_order_business_no: online_order_business_no
			, online_order_business_file: online_order_business_file
			, director_name: director_name
			, director_phone: director_phone
			, director_email: director_email
			/*
			, admin_id: admin_id
			, admin_pw: admin_pw
			, admin_new_pw: admin_new_pw
			*/
			, admin_seqno: {{ $seqno }}
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('제휴사 정보가 등록되었습니다.');
			cancel();
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
	userId = {{$id}};
	
	function modify(){
		if(!checkValidation()) {
			alert('제휴사 정보가 정확하지 않습니다.\n정보를 다시 한번 확인해주세요.');
			return;
		}
		var cop_name = $('#cop_name').val();
		var cop_no = $('#cop_no').val();
		var cop_file = $('#cop_file').val();
		var cop_phone = $('#cop_phone').val();
		var online_order_business_no = $('#online_order_business_no').val();
		var online_order_business_file = $('#online_order_business_file').val();
		var director_name = $('#director_name').val();
		var director_phone = $('#director_phone').val();
		var director_email = $('#director_email').val();
		/*
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_new_pw = $('#admin_new_pw').val();
		var admin_new_pw_confirm = $('#admin_new_pw_confirm').val();
		*/

		medibox.methods.partner.modify({
			cop_name: cop_name
			, cop_no: cop_no
			, cop_file: cop_file
			, cop_phone: cop_phone
			, online_order_business_no: online_order_business_no
			, online_order_business_file: online_order_business_file
			, director_name: director_name
			, director_phone: director_phone
			, director_email: director_email
			/*
			, admin_id: admin_id
			, admin_pw: admin_pw
			, admin_new_pw: admin_new_pw
			*/
			, admin_seqno: {{ $seqno }}
		}, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('제휴사 정보가 수정되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $id }}' };

		medibox.methods.partner.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert('제휴사 정보가 정확하지 않습니다.\n다시 한번 확인해 주세요.');
				cancel();
				return false;
			}

			$('#cop_name').val( response.data.cop_name );
			$('#cop_no').val( response.data.cop_no );
			$('#cop_file').val( response.data.cop_file );
			$('#cop_phone').val( response.data.cop_phone );
			$('#online_order_business_no').val( response.data.online_order_business_no );
			$('#online_order_business_file').val( response.data.online_order_business_file );
			$('#director_name').val( response.data.director_name );
			$('#director_phone').val( response.data.director_phone );
			$('#director_email').val( response.data.director_email );
			/*
			$('#admin_id').val( response.data.adminInfo.admin_id );
			$('#admin_id').prop('disabled', true);
			*/
//			$('#admin_pw').val( response.data.admin_pw );
		
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('제휴사에서 탈퇴하시겠습니까?\n*탈퇴시 기존 데이터는 모두 삭제됩니다.')) {
			return;
		}
		medibox.methods.partner.remove({}, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('탈퇴 되었습니다.');
			cancel();
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

	/*
	function autoHypenPhone(str){
		str = str.replace(/[^0-9]/g, '');
		var tmp = '';
		if( str.length < 4){
			return str;
		}else if(str.length < 7){
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3);
			return tmp;
		}else if(str.length < 11){
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3, 3);
			tmp += '-';
			tmp += str.substr(6);
			return tmp;
		}else{              
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3, 4);
			tmp += '-';
			tmp += str.substr(7);
			return tmp;
		}
		return str;
	}

	var cellPhone = document.getElementById('phone');
	cellPhone.onkeyup = function(event){
		event = event || window.event;
		var _val = this.value.trim();
		this.value = autoHypenPhone(_val) ;
	}
	*/

	$(document).ready(function(){
	});
	</script>
</section>

@include('admin.footer')
