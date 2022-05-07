
@php 
$page_title = $id == 0 ? '서비스 등록' : '서비스 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">서비스 정보 @php echo $id == 0 ? '등록' : '수정'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">매장</div>
				<div class="wr-list-con">
					<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
						<option>옵션B</option>
						<option>옵션C</option>
						<option>옵션D</option>
						<option>옵션E</option>
						<option>옵션F</option>
						<option>옵션G</option>
						<option>옵션H</option>
						<option>옵션I</option>
					</select>
					<select class="default" id="storePop" onchange="getManagersPop(this.value)">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
						<option>옵션B</option> 
						<option>옵션C</option>
						<option>옵션D</option>
						<option>옵션E</option>
						<option>옵션F</option>
						<option>옵션G</option>
						<option>옵션H</option>
						<option>옵션I</option>
					</select>
				</div>
			</div>
			
			<div class="wr-list">
				<div class="wr-list-label">서비스 구분</div> <!-- 펌, 염색 등 분류 -->
				<div class="wr-list-con">
					<input type="text" id="dept" name="" value="" class="span200" placeholder="서비스구분을 기입해주세요">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">서비스명</div>
				<div class="wr-list-con">
					<input type="text" id="name" name="" value="" class="span200" placeholder="서비스명을 기입해주세요">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">소요시간</div>
				<div class="wr-list-con">
					<select class="default" id="estimated_time">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
					</select>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">가격</div>
				<div class="wr-list-con">
					<input type="text" id="price" name="" value="" class="span200" placeholder="0">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">직위</div>
				<div class="wr-list-con">
					<select class="default" id="manager_type">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
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
	var userId;
	var data = {};
	data.partner_seqno = 0;
	data.store_seqno = 0;
	
	function cancel(){
		window.location.href = '/admin/services';
	}
	function checkValidation(){
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var name = $('#name').val(); 
		var estimated_time = $('#estimated_time').val(); 
		var price = $('#price').val();
		var manager_type = $('#manager_type').val();		
        
		if(!partner || partner == '') {
			alert('제휴사를 선택해 주세요.');
			return false;
		}
		if(!store || store == '') {
			alert('매장을 선택해 주세요.');
			return false;
		}
		if(!name || name == '') {
			alert('서비스명을 입력해 주세요.');
			return false;
		}
		if (!estimated_time || estimated_time == '') {
			alert('예상시간을 선택해 주세요.');
			return false;
		}
		if (!price || price == '') {
			alert('가격을 입력해 주세요.');
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
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var name = $('#name').val(); 
		var estimated_time = $('#estimated_time').val(); 
		var price = $('#price').val();
		var manager_type = $('#manager_type').val();
		var dept = $('#dept').val();
		

		medibox.methods.store.manager.services.add({
			name: name
			, estimated_time: estimated_time
			, price: price
			, manager_type: manager_type
			, partner_seqno: partner
			, dept: dept
			, store_seqno: store
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
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var name = $('#name').val(); 
		var estimated_time = $('#estimated_time').val(); 
		var price = $('#price').val();
		var manager_type = $('#manager_type').val();
		var dept = $('#dept').val();

		medibox.methods.store.manager.services.modify({
			name: name
			, estimated_time: estimated_time
			, price: price
			, manager_type: manager_type
			, partner_seqno: partner
			, dept: dept
			, store_seqno: store
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

		medibox.methods.store.manager.services.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#name').val( response.data.name );
			$('#estimated_time').val( response.data.estimated_time );
			$('#price').val( response.data.price );
			
			$('#partnersPop').val( response.data.partner_seqno );
			$('#storePop').val( response.data.store_seqno );
			$('#dept').val(response.data.dept);
			data = response.data;

			if(response.data.manager_type && response.data.manager_type != '') {
				var types = response.data.manager_type.split(',');
				for(var inx=0; inx<types.length; inx++){
					$('#manager_type').html(
						$('#manager_type').html() + '<option value="'+types[inx]+'">'+types[inx]+'</option>'
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
		medibox.methods.store.manager.services.remove({}, '{{ $id }}', function(request, response){
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
			var bodyData = '<option>선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')" '
						+(data.partner_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			getStoresPop(partnerId);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var store;
	function getStoresPop(partner_seqno){
		var data = { partner_seqno:partner_seqno, adminSeqno:{{ $seqno }} };

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option>선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" onclick="getManagersPop('+response.data[inx].seqno+')" '
					+(data.store_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].name+'</option>';
			}
			store = response.data;
			$('#storePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getManagersPop(code){
		var temp = store.filter(s => s.seqno == code);
		if(!temp || temp.length < 1) {
			return;
		} 
		temp = temp[0];
		
		$('#manager_type').html('');
		if(temp.manager_type && temp.manager_type != '') {
			var types = temp.manager_type.split(',');
			for(var inx=0; inx<types.length; inx++){
				$('#manager_type').html(
					$('#manager_type').html() + '<option value="'+types[inx]+'">'+types[inx]+'</option>'
				);
			}
		}
	}
	
	$(document).ready(function(){
		getPartners();

		
		var _bodyContents = '<option>선택해주세요.</option>';
		for(var idx = 0; idx < 2; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="0'+idx+':'+(jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#estimated_time').html(_bodyContents);
	});
	</script>
</section>

@include('admin.footer')
