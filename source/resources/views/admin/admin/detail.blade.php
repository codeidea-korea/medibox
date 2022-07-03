
@php 
$page_title = $id == 0 ? '관리자 아이디 권한 등록' : '관리자 아이디 권한 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">관리자 아이디 권한 @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">아이디</div>
				<div class="wr-list-con">
					<input type="text" id="admin_id" name="" value="" class="span200" placeholder="아이디를 작성해주세요." @php if($id>0) echo 'disabled'; @endphp>
				</div>
				<div class="wr-list-label">이름</div>
				<div class="wr-list-con">
					<input type="text" id="admin_name" name="" value="" class="span200" placeholder="이름을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">관리자 탈퇴</div>
				<div class="wr-list-con">
				@php
				if($id == 0) {
					@endphp
					<a href="#" onclick="remove()" class="btn red ml5">회원 탈퇴</a>
					@php
				} else {
					@endphp
					* 관리자 수정으로 들어오시면 버튼이 생겨납니다.
					@php
				}
				@endphp
				</div>
				@php
				if($id == 0) {
					@endphp
					<div class="wr-list-label">비밀번호</div>
					<div class="wr-list-con">
						<input type="password" id="admin_pw" name="" value="" class="span200" >
					</div>
					@php
				} else {
					@endphp
					<div class="wr-list-label">현재 비밀번호 확인</div>
					<div class="wr-list-con">
						<input type="password" id="admin_old_pw" name="" value="" class="span200" >
					</div>
					@php
				}
				@endphp
			</div>
			<div class="wr-list">
				<div class="wr-list-label">제휴사</div>
				<div class="wr-list-con">
					<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
						<option value="">선택해주세요</option>
					</select>
				</div>
				@php
				if($id == 0) {
					@endphp
					<div class="wr-list-label">비밀번호 확인</div>
					<div class="wr-list-con">
						<input type="password" id="admin_pw2" name="" value="" class="span200" >
					</div>
					@php
				} else {
					@endphp
					<div class="wr-list-label">새로운 비밀번호</div>
					<div class="wr-list-con">
						<input type="password" id="admin_pw" name="" value="" class="span200" >
					</div>
					@php
				}
				@endphp
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장</div>
				<div class="wr-list-con">
					<select class="default" id="storePop">
						<option value="">선택해주세요</option>
					</select>
				</div>
				@php
				if($id == 0) {
				} else {
					@endphp
					<div class="wr-list-label">새로운 비밀번호 확인</div>
					<div class="wr-list-con">
						<input type="password" id="admin_pw2" name="" value="" class="span200" >
					</div>
					@php
				}
				@endphp
			</div>
			<br>
			<div class="wr-list">
				<div class="wr-list-label">권한</div>
				<div class="wr-list-con">
					<select class="default" id="admin_type" onchange="getPartnersPop(this.value)">
						<option value="">전체 권한</option>
						<option value="A">슈퍼 관리자</option>
						<option value="B">본사 관리자</option>
						<option value="P">브랜드 관리자</option>
						<option value="S">매장 관리자</option>
					</select>
					<br>
					<label class="checkbox-wrap">
						<input type="checkbox" id="is_all_partners" checked onclick="togglePartners()" />
						<span></span>전체
					</label>
					<input type="hidden" id="level_partner_grp_seqno" name="" value="0" class="" disabled>
					<select class="default" id="partnersPop2" onchange="addPartner()">
						<option>검색가능 셀렉트</option>
					</select>
					<div class="mt10 _partners">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($id != 0) {
		@endphp
		<a href="#" onclick="modify()" class="btn red">수정</a>
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
	var userId;
	var userInfo = {};
	function cancel(){
		window.location.href = '/admin/level';
	}

	function addPartner(){
		var types = document.querySelector('#level_partner_grp_seqno').value;
		var typeInput = document.querySelector('#partnersPop2').value;
		/*
		if(types && types != '') {
			if(types.split(',').length > 4) {
				// 직위 5개 이미 등록되어있음
				alert('이미 직위 5개가 등록되었습니다.');
				return false;
			}
		}
		*/
		if(!typeInput || typeInput == '') {
			alert('추가할 제휴사를 선택해주세요.');
			return false;
		}
		if(types.indexOf(typeInput) > -1) {
			alert('이미 등록된 제휴사입니다.');
			return false;
		}
		var textType = $('#partnersPop2 > option:selected').text();

		document.querySelector('#level_partner_grp_seqno').value = 
			document.querySelector('#level_partner_grp_seqno').value + '|' + typeInput + '|';
		$('._partners').html(
			$('._partners').html() + '<span class="srtag">'+textType+'<i onclick="deleteTypes(this, \''+typeInput+'\')" class="del"></i></span>'
		);
	}
	function deleteTypes(target, name){
		$(target).parent().remove();
		var types = document.querySelector('#level_partner_grp_seqno').value;
		types = types.replace('|'+name+'|', '');
		document.querySelector('#level_partner_grp_seqno').value = types;
	}
	function togglePartners(){
		if($('#is_all_partners').is(':checked')) {
			$('#level_partner_grp_seqno').val('0');
			$('._partners').html('');
			$('#partnersPop2').val('');
			$('#partnersPop2').attr('disabled');
		} else {
			$('#level_partner_grp_seqno').val('');
			$('._partners').html('');
			$('#partnersPop2').val('');
			$('#partnersPop2').removeAttr('disabled');
		}
	}
	
	function getPartnersPop(val) {
		$('#partnersPop').hide();
		$('#storePop').hide();

		if(val == 'P') {
			$('#partnersPop').show();
		} else if(val == 'S') {
			$('#partnersPop').show();
			$('#storePop').show();
		} else {
			$('#partnersPop').val('');
			$('#storePop').val('');
		}
	}
	function getPartners(){
		// TODO: 제휴사 로그인시에는 해당 값에 할당
		var partnerId = '';
		var data = { adminSeqno:{{ $seqno }} };

		if(partnerId && partnerId != '') {
			data.id = partnerId;
		}

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" '+(userInfo.partner_seqno && userInfo.partner_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			$('#partnersPop2').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function getStoresPop(partner_seqno){
		var data = { partner_seqno:partner_seqno, adminSeqno:{{ $seqno }} };

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" '+(userInfo.store_seqno && userInfo.store_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].name+'</option>';
			}
			$('#storePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function checkValidation(){
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_pw2 = $('#admin_pw2').val();
		var admin_old_pw = $('#admin_old_pw').val();
		var admin_name = $('#admin_name').val();
		var admin_type = $('#admin_type').val();
		var partner_seqno = $('#partner_seqno').val();
		var store_seqno = $('#store_seqno').val();
		var level_partner_grp_seqno = $('#level_partner_grp_seqno').val();
        
		if(!admin_id || admin_id == '') {
			alert('아이디를 입력해주세요.');
			return false;
		}
		@php
		if($id == 0) {
		@endphp
		if (!admin_pw || admin_pw == '') {
			alert('비밀번호를 입력해주세요.');
			return false;
		}
		if (!admin_pw2 || admin_pw2 == '') {
			alert('비밀번호 확인을 입력해주세요.');
			return false;
		}
		@php
		} else {
		@endphp
		if (!admin_old_pw || admin_old_pw == '') {
			alert('현재 비밀번호를 입력해주세요.');
			return false;
		}
		if (admin_pw != '') {
			if (!admin_pw2 || admin_pw2 == '') {
				alert('새로운 비밀번호 확인을 입력해주세요.');
				return false;
			}
			if (admin_pw != admin_pw2) {
				alert('새로운 비밀번호 확인이 일치하지 않습니다. 다시 확인해주세요.');
				return false;
			}
		}
		@php
		}
		@endphp
		if (!admin_name || admin_name == '') {
			alert('이름을 입력해주세요.');
			return false;
		}
		if (!admin_type || admin_type == '') {
			alert('권한을 선택해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($id == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_pw2 = $('#admin_pw2').val();
		var admin_old_pw = $('#admin_old_pw').val();
		var admin_name = $('#admin_name').val();
		var admin_type = $('#admin_type').val();
		var partner_seqno = $('#partnersPop').val();
		var store_seqno = $('#storePop').val();
		var level_partner_grp_seqno = $('#level_partner_grp_seqno').val();

		medibox.methods.admin.level.add({
			admin_id: admin_id
			, admin_pw: admin_pw
			, admin_pw2: admin_pw2
			, admin_old_pw: admin_old_pw
			, admin_name: admin_name
			, admin_type: admin_type
			, partner_seqno: partner_seqno
			, store_seqno: store_seqno
			, level_partner_grp_seqno: level_partner_grp_seqno
			, admin_seqno: {{ $seqno }}
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('추가 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	$(document).ready(function(){
		getPartners();
	});
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
			return;
		}
		var admin_id = $('#admin_id').val();
		var admin_pw = $('#admin_pw').val();
		var admin_pw2 = $('#admin_pw2').val();
		var admin_old_pw = $('#admin_old_pw').val();
		var admin_name = $('#admin_name').val();
		var admin_type = $('#admin_type').val();
		var partner_seqno = $('#partnersPop').val();
		var store_seqno = $('#storePop').val();
		var level_partner_grp_seqno = $('#level_partner_grp_seqno').val();
		if (admin_pw == '') {
			admin_pw = admin_old_pw;
		}

		medibox.methods.admin.level.modify({
			admin_id: admin_id
			, admin_pw: admin_pw
			, admin_pw2: admin_pw2
			, admin_old_pw: admin_old_pw
			, admin_name: admin_name
			, admin_type: admin_type
			, partner_seqno: partner_seqno
			, store_seqno: store_seqno
			, level_partner_grp_seqno: level_partner_grp_seqno
			, admin_seqno: {{ $seqno }}
		},{{$id}}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $id }}' };

		medibox.methods.admin.level.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			$('#admin_id').val( response.data.admin_id );
			$('#admin_name').val( response.data.admin_name );
			$('#admin_type').val( response.data.admin_type );
			$('#partner_seqno').val( response.data.partner_seqno ); 
			$('#store_seqno').val( response.data.store_seqno );
			$('#level_partner_grp_seqno').val( response.data.level_partner_grp_seqno );
			userInfo = response.data;
			$('#partnersPop').val(response.data.partner_seqno);
			getStoresPop(response.data.partner_seqno);
			$('#storePop').val(response.data.store_seqno);

			if(response.data.level_partner_grp_seqno && response.data.level_partner_grp_seqno != '') {
				if(response.data.level_partner_grp_seqno == 0) {
					// 전체 선택
					togglePartners();
				} else {
					var types = response.data.level_partner_grp_seqno.split('||');
					for(var inx=0; inx<types.length; inx++){
						types[inx] = (types[inx] + '').replace('|', '');
						$('._partners').html(
							$('._partners').html() + '<span class="srtag">'+$('#partnersPop > option[value='+types[inx]+']').text()+'<i onclick="deleteTypes(this, \''+types[inx]+'\')" class="del"></i></span>'
						);
					}
				}
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('관리자를 탈퇴 시키겠습니까?')) {
			return;
		}
		medibox.methods.admin.level.remove({}, '{{ $id }}', function(request, response){
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
		getPartners();
		getInfo();
	});
	@php
	}
	@endphp
	</script>
</section>

@include('admin.footer')
