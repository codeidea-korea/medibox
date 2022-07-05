
@php 
$page_title = $packageNo == 0 ? '패키지 등록' : '패키지 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">패키지 @php echo $packageNo == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">패키지 이름</div>
				<div class="wr-list-con">
					<input type="text" id="type_name" name="" value="" class="span200" placeholder="제목을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">패키지 내용</div>
				<div class="wr-list-con">
					<textarea id="info" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
			<input type="hidden" id="service_name" name="" value="미니쉬 패키지">
			<input type="hidden" id="date_use" name="" value="0">
			<div class="wr-list">
				<div class="wr-list-label">패키지 가격</div>
				<div class="wr-list-con">
					<input type="text" id="price" name="" value="" class="span200" placeholder="1000000"> 원
				</div> 
			</div>
			<div class="wr-list">
				<div class="wr-list-label">적립 포인트</div>
				<div class="wr-list-con">
					<input type="text" id="return_point" name="" value="" class="span200" placeholder="100000"> POINT
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($packageNo != 0) {
		@endphp
		<a href="#" id="_remove" onclick="remove()" class="btn red">단종</a>
		<a href="#" id="_rollback" onclick="sellsStatusModify()" class="btn blue">판매</a>
		<!--
		<a href="#" onclick="remove()" class="btn red">삭제</a>
		<a href="#" onclick="modify()" class="btn blue">수정</a>
		-->
		@php 
		}
		@endphp
		@php
		if($packageNo == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/service/packages';
	}
	function checkValidation(){
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var service_name = document.querySelector('#service_name').value;
		var price = document.querySelector('#price').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('#date_use').val();

		if(!type_name || type_name == '') {
			alert('정액권 이름을 입력해주세요.');
			return false;
		}
		if (!info || info == '') {
			alert('정액권 내용을 입력해주세요.');
			return false;
		}
		if (!service_name || service_name == '') {
			alert('제휴사를 선택해주세요.');
			return false;
		}
		if (!price || price == '') {
			alert('정액권 가격을 입력해주세요.');
			return false;
		}
		if (!return_point || return_point == '') {
			alert('적립 포인트를 입력해주세요.');
			return false;
		}
		if (!date_use || date_use == '') {
			alert('정액권 기간을 선택해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($packageNo == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var point_type = 'K';
		var price = document.querySelector('#price').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('#date_use').val();
		var service_name = $('#service_name').val();

		medibox.methods.point.products.add({
			type_name: type_name
			, info: info
			, service_name: service_name
			, price: price
			, return_point: return_point
			, date_use: date_use
			, point_type: point_type
			, service_sub_name: ''
			, step_type: 0
			, offline_type: 'N'
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
	if($packageNo != 0) {
	@endphp
	userId = {{$packageNo}};
	
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var point_type = 'K';
		var price = document.querySelector('#price').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('#date_use').val();
		var service_name = $('#service_name').val();

		medibox.methods.point.products.modify({
			type_name: type_name
			, info: info
			, service_name: service_name
			, price: price
			, return_point: return_point
			, date_use: date_use
			, point_type: point_type
			, service_sub_name: ''
			, step_type: 0
			, offline_type: 'N'
			, admin_seqno: {{ $seqno }}
		},'{{ $packageNo }}', function(request, response){
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
	function sellsStatusModify(){
		medibox.methods.point.products.modify({
			type_name: info.type_name
			, info: info.info
			, service_name: info.service_name
			, price: info.price
			, return_point: info.return_point
			, date_use: info.date_use
			, point_type: info.point_type
			, service_sub_name: ''
			, step_type: 0
			, offline_type: 'N'
			, deleted: 'N'
			, admin_seqno: {{ $seqno }}
		}, '{{ $packageNo }}', function(request, response){
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
	var info;
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $packageNo }}' };

		medibox.methods.point.products.one(data, '{{ $packageNo }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			info = response.data;
			if(response.data.delete_yn == 'Y') {
				$('#_remove').hide();
				$('#_rollback').show();
			} else {
				$('#_remove').show();
				$('#_rollback').hide();
			}

			$('#type_name').val( response.data.type_name );
			$('#info').val( response.data.info );
			$('#service_name').val( response.data.point_type );
			$('#price').val( response.data.price );
			$('#add_rate').val( response.data.add_rate );
			$('#return_point').val( response.data.return_point );
			$('#date_use').val( response.data.date_use );
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('정말 삭제 하시겠습니까?')) {
			return;
		}
		medibox.methods.point.products.remove({
			id: userId
		}, '{{ $packageNo }}', function(request, response){
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
	</script>
</section>

@include('admin.footer')
