
@php 
$page_title = $id == 0 ? '매장 등록' : '매장 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">매장 정보 @php echo $id == 0 ? '등록' : '수정'; @endphp</div>
	<div class="wrtieContents" style="flex-direction:column;">
		<div class="wr-wrap line label160">
			<div class="wr-head"> 기본 정보 </div>
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
					<input type="hidden" id="zipcode" name="" value="1" placeholder="">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">상세 주소</div>
				<div class="wr-list-con">
					<input type="text" id="address_detail" name="" value="" class="span200" placeholder="">
				</div>
			</div>
		</div>
		<br>
		<div class="wr-wrap line label160">
			<div class="wr-head"> 매장 소개 </div>
			<div class="wr-list">
				<div class="wr-list-label">소속 제휴사</div>
				<div class="wr-list-con">
					<select id="partner_seqno">
						<option value="1">바라는 네일</option>
					</select>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">제휴 업체 소개</div>
				<div class="wr-list-con">
					<textarea id="info" name="" value="" placeholder="소개말을 작성하여 주세요."></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">매장 사진</div>
				<div class="wr-list-con">
					<input type="hidden" id="img1">
					<input type="hidden" id="img2">
					<input type="hidden" id="img3">
					<input type="hidden" id="img4">
					<input type="hidden" id="img5">

					<div class="gallery">
						<ul>
							<li>
								<div class="imgCon"><img id="imgView1" src="#" onerror="this.src='/adm/img/no-image-found-360x250-1-300x208.png'"></div>
								<div class="txtCon">
									<i onclick="removePicture(1)" class="del del1">삭제</i>
								</div>
							</li>
							<li>
								<div class="imgCon"><img id="imgView2" src="#" onerror="this.src='/adm/img/no-image-found-360x250-1-300x208.png'"></div>
								<div class="txtCon">
									<i onclick="removePicture(2)" class="del del2">삭제</i>
								</div>
							</li>
							<li>
								<div class="imgCon"><img id="imgView3" src="#" onerror="this.src='/adm/img/no-image-found-360x250-1-300x208.png'"></div>
								<div class="txtCon">
									<i onclick="removePicture(3)" class="del del3">삭제</i>
								</div>
							</li>
							<li>
								<div class="imgCon"><img id="imgView4" src="#" onerror="this.src='/adm/img/no-image-found-360x250-1-300x208.png'"></div>
								<div class="txtCon">
									<i onclick="removePicture(4)" class="del del4">삭제</i>
								</div>
							</li>
							<li>
								<div class="imgCon"><img id="imgView5" src="#" onerror="this.src='/adm/img/no-image-found-360x250-1-300x208.png'"></div>
								<div class="txtCon">
									<i onclick="removePicture(5)" class="del del5">삭제</i>
								</div>
							</li>
						</ul>
					</div>

					<div class="filebox">
						<label for="upload_0" class="upload-btn">파일찾기
						<input name="" type="file" multiple="" id="upload_0" class="upload-hidden" onchange="uploadFile()">
					</label></div>
					<p class="help-block">
						※ 매장 사진은 최대 5장 등록이 가능합니다.<br>
						※ 해상도 0000 x 000 px에 최적화 되어 있습니다.<br>
						※ 메디박스의 운영정책을 위반하거나 관련없는 사진은 노출 제외 처리 됩니다.
					</p>
				</div>
			</div>
		</div>
		<br>
		<div class="wr-wrap line label160">
			<div class="wr-head"> 매장 권한 </div>
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
	<style>
	.gallery li{width:calc(20% - 16px) !important;background:#fff;padding:20px;border:1px solid rgba(0,0,0,0.1);border-radius:4px;}
	</style>
	
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
	var imgPoint = 1;
	var pictures = [];
	var maxLength = 5;

	function addPicture(path){
		if(imgPoint > maxLength) {
			alert('매장 사진은 최대 5장 등록이 가능합니다.');
			return false;
		}
		$('#img' + imgPoint).val(path);
		$('.del' + imgPoint).show();
		$('#imgView' + imgPoint).attr('src', path + '?v=' + (new Date().getTime()));
		pictures[imgPoint] = path;
		imgPoint = imgPoint + 1;
	}
	function removePicture(idx){
		// index 삭제후 당기기
		if(imgPoint > (maxLength + 1) || imgPoint < 1) {
			alert('존재할 수 없는 이미지 포인터입니다.');
			return false;
		}
		if(idx >= imgPoint || imgPoint == 1) {
			return false;
		}
		pictures[idx - 1] = null;
		for(var inx=1; inx < 6; inx++) $('.del' + inx).hide();
		for(var inx = (idx - 1); inx < maxLength; idx++){
			$('#img' + (inx + 1)).val(pictures[inx]);
			$('.del' + imgPoint).show();
			$('#imgView' + (inx + 1)).attr('src', pictures[inx] + '?v=' + (new Date().getTime()));
		}
		imgPoint = imgPoint - 1;
	}
	function uploadFile(){
		if(imgPoint > maxLength) {
			alert('매장 사진은 최대 5장 등록이 가능합니다.');
			return false;
		}
		if(!$("#upload_0") || !$("#upload_0")[0] || !$("#upload_0")[0].files[0]) {
			return false;
		}

		var form = new FormData();
		form.append( "upload", $("#upload_0")[0].files[0] );
		
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
				addPicture('/storage/'+response.path);
				$("#upload_0")[0].files[0] = null;
			}
			,error: function (jqXHR) 
			{ 
				alert(jqXHR.responseText); 
			}
		});
	}
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
        var info = $('#info').val();
        var img1 = $('#img1').val();
        var img2 = $('#img2').val();
        var img3 = $('#img3').val();
        var img4 = $('#img4').val();
        var img5 = $('#img5').val();

		medibox.methods.store.add({
			name: name
			, phone: phone
			, address: address
			, address_detail: address_detail
			, zipcode: zipcode
			, partner_seqno: partner_seqno
			, in_manager: in_manager ? 'Y' : 'N'
			, manager_type: manager_type
			, info: info
			, img1: img1
			, img2: img2
			, img3: img3
			, img4: img4
			, img5: img5
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
		for(var inx=1; inx < 6; inx++) $('.del' + inx).hide();
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
		var name = document.querySelector('#name').value;
        var phone = document.querySelector('#phone').value;
        var address = document.querySelector('#address').value;
        var address_detail = document.querySelector('#address_detail').value;
        var zipcode = document.querySelector('#zipcode').value;
        var partner_seqno = document.querySelector('#partner_seqno').value;
        var in_manager = $('#in_manager').is(":checked");
        var manager_type = document.querySelector('#manager_type').value;
        var info = $('#info').val();
        var img1 = $('#img1').val();
        var img2 = $('#img2').val();
        var img3 = $('#img3').val();
        var img4 = $('#img4').val();
        var img5 = $('#img5').val();

		medibox.methods.store.modify({
			name: name
			, phone: phone
			, address: address
			, address_detail: address_detail
			, zipcode: zipcode
			, partner_seqno: partner_seqno
			, in_manager: in_manager ? 'Y' : 'N'
			, manager_type: manager_type
			, info: info
			, img1: img1
			, img2: img2
			, img3: img3
			, img4: img4
			, img5: img5
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

			$('#info').val(response.data.info);

			for(var inx = 1; inx <= 5; inx++) {
				if(!response.data['img' + inx]) continue;
				addPicture(response.data['img' + inx]);
			}
			for(var inx = 1; inx <=5; inx++) $('#imgView'+inx).show();

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
		for(var inx=1; inx < 6; inx++) $('.del' + inx).hide();
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
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seqno+'">'
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

		setTimeout(() => {
			for(var inx = 1; inx <=5; inx++) $('#imgView'+inx).show();
		}, 200);
	});
	</script>
</section>

@include('admin.footer')
