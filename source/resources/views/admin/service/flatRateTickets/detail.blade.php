
@php 
$page_title = $tiketNo == 0 ? '정액권 등록' : '정액권 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">정액권 @php echo $tiketNo == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">정액권 이름</div>
				<div class="wr-list-con">
					<input type="text" id="type_name" name="" value="" class="span200" placeholder="제목을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">정액권 내용</div>
				<div class="wr-list-con">
					<textarea id="info" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">정액권 제휴사</div>
				<div class="wr-list-con">
					<select id="service_name" class="default">
						<option value="">적용 제휴사</option>
						<option value="S1">전체 사용 [통합 정액권]</option>
						<option value="S2">바라는 네일</option>
						<option value="S3">발몽스파</option>
						<option value="S4">포레스타 블랙</option>
						<option value="S5">딥포커스 검안센터</option>
						<option value="S6">미니쉬 스파</option>
						<option value="S7">미니쉬 도수</option>
					</select>

				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">정액권 가격</div>
				<div class="wr-list-con">
					<input type="text" id="price" name="" value="" class="span200" placeholder="1000000"> 원
				</div> 
			</div>
			<div class="wr-list">
				<div class="wr-list-label">추가 포인트율</div>
				<div class="wr-list-con">
					<input type="text" id="add_rate" name="" value="" class="span200" placeholder="1"> %
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">적립 포인트</div>
				<div class="wr-list-con">
					<input type="text" id="return_point" name="" value="" class="span200" placeholder="100000"> POINT
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">정액권 사용 기간</div>
				<div class="wr-list-con">
					<label class="radio-btn"><input type="radio" name="date_use" value="14" class="" data-label="2주" checked=""><span>2주</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="30" class="" data-label="1개월"><span>1개월</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="90" class="" data-label="3개월"><span>3개월</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="180" class="" data-label="6개월"><span>6개월</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="365" class="" data-label="1년"><span>1년</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="730" class="" data-label="2년"><span>2년</span></label>
					<label class="radio-btn"><input type="radio" name="date_use" value="0" class="" data-label="제한없음"><span>제한없음</span></label>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($tiketNo != 0) {
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
		if($tiketNo == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/service/tickets';
	}
	function checkValidation(){
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var service_name = document.querySelector('#service_name').value;
		var price = document.querySelector('#price').value;
		var add_rate = document.querySelector('#add_rate').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('input[name=date_use]:checked').val();

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
		if (!add_rate || add_rate == '') {
			alert('포인트율을 입력해주세요.');
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
	if($tiketNo == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var point_type = document.querySelector('#service_name').value;
		var price = document.querySelector('#price').value;
		var add_rate = document.querySelector('#add_rate').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('input[name=date_use]:checked').val();
		var service_name = $('#service_name').find('option:selected').text();

		medibox.methods.point.products.add({
			type_name: type_name
			, info: info
			, service_name: service_name
			, price: price
			, add_rate: add_rate
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
	if($tiketNo != 0) {
	@endphp
	userId = {{$tiketNo}};
	
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var type_name = document.querySelector('#type_name').value;
		var info = document.querySelector('#info').value;
		var point_type = document.querySelector('#service_name').value;
		var price = document.querySelector('#price').value;
		var add_rate = document.querySelector('#add_rate').value;
		var return_point = document.querySelector('#return_point').value;
		var date_use = $('input[name=date_use]:checked').val();
		var service_name = $('#service_name').find('option:selected').text();

		medibox.methods.point.products.modify({
			type_name: type_name
			, info: info
			, service_name: service_name
			, price: price
			, add_rate: add_rate
			, return_point: return_point
			, date_use: date_use
			, point_type: point_type
			, service_sub_name: ''
			, step_type: 0
			, offline_type: 'N'
			, admin_seqno: {{ $seqno }}
		}, '{{ $tiketNo }}', function(request, response){
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
			, add_rate: info.add_rate
			, return_point: info.return_point
			, date_use: info.date_use
			, point_type: info.point_type
			, service_sub_name: ''
			, step_type: 0
			, offline_type: 'N'
			, deleted: 'N'
			, admin_seqno: {{ $seqno }}
		}, '{{ $tiketNo }}', function(request, response){
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
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $tiketNo }}' };

		medibox.methods.point.products.one(data, '{{ $tiketNo }}', function(request, response){
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
			$('input[name=date_use][value='+response.data.date_use+']').prop('checked', true);
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
		}, '{{ $tiketNo }}', function(request, response){
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
