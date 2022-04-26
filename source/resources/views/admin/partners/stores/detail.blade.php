
@php 
$page_title = $id == 0 ? '매장 등록' : '매장 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">매장 정보 @php echo $id == 0 ? '등록' : '수정'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">매장 이름</div>
				<div class="wr-list-con">
					<input type="text" id="name" maxlength="30" name="" value="" class="span200" placeholder="매장명을 30자 이내로 기입해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장 전화번호</div>
				<div class="wr-list-con">
					<input type="text" id="phone" maxlength="13" name="" value="" class="span200" placeholder="EX> 000-0000-0000 의 형태로 기입해주세요">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">주소</div>
				<div class="wr-list-con">
				<!-- 카카오 주소 찾기 호출 -->
					<input type="text" id="address" name="" value="" class="span200" placeholder="">
					<input type="hidden" id="zipcode" name="" value="" placeholder="">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">상세 주소</div>
				<div class="wr-list-con">
					<input type="text" id="address_detail" name="" value="" class="span200" placeholder="">
				</div>
			</div>

			<!-- 매장 소개 부분 우선 제외 -->

			<div class="wr-list">
				<div class="wr-list-label">소속 제휴사</div>
				<div class="wr-list-con">
					<select id="partner_seqno">
						<option value="1">바라는 네일</option>
					</select>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">디자이너 유무</div>
				<div class="wr-list-con">
					<label class="toggle-light">
						<input type="checkbox" id="in_manager" name="" value="1" class="" checked=""><span></span>
						<span class="labelOn">사용</span>
						<span class="labelOff">미사용</span>
					</label>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장 직위</div>
				<div class="wr-list-con">
					<input type="hidden" id="manager_type" name="" value="" class="">
					<input type="text" id="managerTypeInput" name="" value="" class="" placeholder="매장내 직위(또는 호칭)을 분류할 수 있습니다.">
					<a href="#" onclick="addManagerType()" class="btn black ml5">추가</a>
					<div class="mt10 _managerTypes">
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
		
		<a href="#" onclick="modify()" class="btn blue">수정</a>
		<a href="#" onclick="remove()" class="btn red">삭제</a>
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
	function addManagerType(){
		var managerTypes = document.querySelector('#manager_type').value;
		var managerTypeInput = document.querySelector('#managerTypeInput').value;
		if(managerTypes && managerTypes != '') {
			if(managerTypes.split(',').length > 4) {
				// 직위 5개 이미 등록되어있음
				alert('이미 직위 5개가 등록되었습니다.');
				return false;
			}
		}
		if(!managerTypeInput || managerTypeInput == '') {
			alert('등록하실 직위를 입력해주세요.');
			return false;
		}
		if(managerTypes.indexOf(managerTypeInput) > -1) {
			alert('이미 등록된 직위입니다.');
			return false;
		}

		document.querySelector('#manager_type').value = document.querySelector('#manager_type').value + (managerTypes && managerTypes != '' ? ',' : '') + managerTypeInput;
		$('._managerTypes').html(
			$('._managerTypes').html() + '<span class="srtag">'+managerTypeInput+'<i onclick="deleteTypes(this, \''+managerTypeInput+'\')" class="del"></i></span>'
		);
	}
	function deleteTypes(target, name){
		$(target).parent().remove();
		var managerTypes = document.querySelector('#manager_type').value;
		managerTypes = managerTypes.replace(name, '').replace(',,', '');
		managerTypes = (managerTypes[0] == ',' ? managerTypes.substring(1, managerTypes.length) : managerTypes);
		managerTypes = (managerTypes[managerTypes.length-1] == ',' ? managerTypes.substring(0, managerTypes.length-1) : managerTypes);
		document.querySelector('#manager_type').value = managerTypes;
	}
		var userId;
	function cancel(){
		window.location.href = '/admin/stores';
	}
	function checkValidation(){
		var name = document.querySelector('#name').value;
        var phone = document.querySelector('#phone').value;
        var address = document.querySelector('#address').value;
        var partner_seqno = document.querySelector('#partner_seqno').value;
        var manager_type = document.querySelector('#manager_type').value;
        
		if(!name || name == '') {
			alert('매장명을 입력해주세요.');
			return false;
		}
		if (!phone || phone == '') {
			alert('전화번호를 입력해주세요.');
			return false;
		}
		if (!address || address == '') {
			alert('주소를 입력해주세요.');
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
		var name = document.querySelector('#name').value;
        var phone = document.querySelector('#phone').value;
        var address = document.querySelector('#address').value;
        var address_detail = document.querySelector('#address_detail').value;
        var zipcode = document.querySelector('#zipcode').value;
        var partner_seqno = document.querySelector('#partner_seqno').value;
        var in_manager = $('#in_manager').is(":checked");
        var manager_type = document.querySelector('#manager_type').value;

		medibox.methods.store.add({
			name: name
			, phone: phone
			, address: address
			, address_detail: address_detail
			, zipcode: zipcode
			, partner_seqno: partner_seqno
			, in_manager: in_manager ? 'Y' : 'N'
			, manager_type: manager_type
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
		var name = document.querySelector('#name').value;
        var phone = document.querySelector('#phone').value;
        var address = document.querySelector('#address').value;
        var address_detail = document.querySelector('#address_detail').value;
        var zipcode = document.querySelector('#zipcode').value;
        var partner_seqno = document.querySelector('#partner_seqno').value;
        var in_manager = $('#in_manager').is(":checked");
        var manager_type = document.querySelector('#manager_type').value;

		medibox.methods.store.modify({
			name: name
			, phone: phone
			, address: address
			, address_detail: address_detail
			, zipcode: zipcode
			, partner_seqno: partner_seqno
			, in_manager: in_manager ? 'Y' : 'N'
			, manager_type: manager_type
			, admin_seqno: {{ $seqno }}
		}, '{{ $id }}', function(request, response){
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

		medibox.methods.store.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#name').val( response.data.name );
			$('#phone').val( response.data.phone );
			$('#address').val( response.data.address );
			$('#address_detail').val( response.data.address_detail );
			$('#zipcode').val( response.data.zipcode );
			$('#in_manager').prop('checked', response.data.in_manager == 'Y');
			
			$('#partner_seqno').val( response.data.partner_seqno );

			$('#manager_type').val( response.data.manager_type );
			if(response.data.manager_type && response.data.manager_type != '') {
				var types = response.data.manager_type.split(',');
				for(var inx=0; inx<types.length; inx++){
					$('._managerTypes').html(
						$('._managerTypes').html() + '<span class="srtag">'+types[inx]+'<i onclick="deleteTypes(this, \''+types[inx]+'\')" class="del"></i></span>'
					);
				}
			}
		
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('정말 삭제 하시겠습니까?')) {
			return;
		}
		medibox.methods.store.remove({}, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('삭제 되었습니다.');
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

	function getPartners(){
		var data = { pageNo: 1, pageSize: 300, adminSeqno:{{ $seqno }} };
		
		medibox.methods.partner.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seq+'">'
							+ response.data[inx].cop_name
							+'</option>';
			}
			$('#partner_seqno').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	$(document).ready(function(){
		getPartners();
	});
	</script>
</section>

@include('admin.footer')
