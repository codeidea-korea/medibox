
@php 
$page_title = $voucherNo == 0 ? '바우처 등록' : '바우처 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">바우처 @php echo $voucherNo == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">바우처 이름</div>
				<div class="wr-list-con">
					<input type="text" id="name" name="" value="" class="span200" placeholder="제목을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">바우처 내용</div>
				<div class="wr-list-con">
					<textarea id="context" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">바우처 발급 수량</div>
				<div class="wr-list-con">
					<input type="number" id="unit_count" name="" value="" class="span200" placeholder="0">
				</div> 
			</div>
			<div class="wr-list">
				<div class="wr-list-label">바우처 사용 기간</div>
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
			<div class="wr-list">
				<div class="wr-list-label">제휴사 연결 (선택사항)</div>
				<div class="wr-list-con">
				
					<label class="toggle-light">
						<input type="checkbox" id="use_partner" name="use_partner" value="Y" onclick="toggleSelect()">
						<span></span>
						<span class="labelOn">ON</span>
						<span class="labelOff">OFF</span>
					</label>

					<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
						<option>검색가능 셀렉트</option>
					</select>
					<select class="default" id="storePop" onchange="getServicePop(this.value)">
						<option>검색가능 셀렉트</option>
					</select>
					<select class="default" id="servicePop">
						<option>검색가능 셀렉트</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($voucherNo != 0) {
		@endphp
		<a href="#" onclick="remove()" class="btn red">삭제</a>
		<a href="#" onclick="modify()" class="btn blue">수정</a>
		@php 
		}
		@endphp
		@php
		if($voucherNo == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
	var userId;
	var isFirst = true;
	var voucherInfo = {};
	function cancel(){
		window.location.href = '/admin/service/vouchers';
	}

	function toggleSelect(){
		if($('#use_partner').is(':checked')) {
			$('#partnersPop').removeAttr('disabled');
			$('#storePop').removeAttr('disabled');
			$('#servicePop').removeAttr('disabled');
		} else {
			$('#partnersPop').attr('disabled', 'true');
			$('#storePop').attr('disabled', 'true');
			$('#servicePop').attr('disabled', 'true');
			$('#partnersPop').val('');
			$('#storePop').val('');
			$('#servicePop').val('');
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
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')" '
						+(isFirst && voucherInfo.partner_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			if(isFirst && voucherInfo.partner_seqno > 0) {
				getStoresPop(voucherInfo.partner_seqno);
			} else {
				getStoresPop(partnerId);
			}			
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
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" onclick="getServicePop('+response.data[inx].seqno+')" '
					+(isFirst && voucherInfo.store_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].name+'</option>';
			}
			store = response.data;
			$('#storePop').html(bodyData);

			if(isFirst && voucherInfo.store_seqno > 0) {
				getServicePop(voucherInfo.store_seqno);
			} else {
				getServicePop();
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getServicePop(store_seqno){
		var data = { store_seqno:store_seqno, adminSeqno:{{ $seqno }} };

		medibox.methods.store.manager.services.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" '
					+(isFirst && voucherInfo.service_seqno == response.data[inx].seqno ? 'selected' : '')+'>'+response.data[inx].name+'</option>';
			}
			isFirst = false;
			$('#servicePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function checkValidation(){
		var name = document.querySelector('#name').value;
		var context = document.querySelector('#context').value;
		var unit_count = document.querySelector('#unit_count').value;

		var date_use = $('input[name=date_use]:checked').val();

		var use_partner = $('#use_partner').is(":checked") ? 'Y' : 'N';
		var partner_seqno = $('#partnersPop').val();
		var store_seqno = $('#storePop').val();
		var service_seqno = $('#servicePop').val();

		if(!name || name == '') {
			alert('바우처 이름을 입력해주세요.');
			return false;
		}
		if (!context || context == '') {
			alert('바우처 내용을 입력해주세요.');
			return false;
		}
		if (!unit_count || unit_count == '') {
			alert('바우처 발급 수량을 선택해주세요.');
			return false;
		}
		if (!date_use || date_use == '') {
			alert('바우처 기간을 선택해주세요.');
			return false;
		}
		if (use_partner == 'Y') {
			if (!partner_seqno || partner_seqno == '' || !store_seqno || store_seqno == '' || !service_seqno || service_seqno == '') {
				alert('바우처 제휴사/매장/서비스를 선택해주세요.');
				return false;
			}
		}

		return true;
	}
	// 등록일 경우
	@php
	if($voucherNo == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var name = document.querySelector('#name').value;
		var context = document.querySelector('#context').value;
		var unit_count = document.querySelector('#unit_count').value;

		var date_use = $('input[name=date_use]:checked').val();

		var use_partner = $('#use_partner').is(":checked") ? 'Y' : 'N';
		var partner_seqno = $('#partnersPop').val();
		var store_seqno = $('#storePop').val();
		var service_seqno = $('#servicePop').val();

		medibox.methods.point.vouchers.add({
			name: name
			, context: context
			, unit_count: unit_count
			, date_use: date_use
			, use_partner: use_partner
			, partner_seqno: partner_seqno
			, store_seqno: store_seqno
			, service_seqno: service_seqno
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
		toggleSelect();
	});
	@php
	}
	@endphp
	// 수정일 경우
	@php
	if($voucherNo != 0) {
	@endphp
	userId = {{$voucherNo}};
	
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var name = document.querySelector('#name').value;
		var context = document.querySelector('#context').value;
		var unit_count = document.querySelector('#unit_count').value;

		var date_use = $('input[name=date_use]:checked').val();

		var use_partner = $('#use_partner').is(":checked") ? 'Y' : 'N';
		var partner_seqno = $('#partnersPop').val();
		var store_seqno = $('#storePop').val();
		var service_seqno = $('#servicePop').val();

		medibox.methods.point.vouchers.modify({
			name: name
			, context: context
			, unit_count: unit_count
			, date_use: date_use
			, use_partner: use_partner
			, partner_seqno: partner_seqno
			, store_seqno: store_seqno
			, service_seqno: service_seqno
			, admin_seqno: {{ $seqno }}
		}, {{$voucherNo}}, function(request, response){
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
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $voucherNo }}' };

		medibox.methods.point.vouchers.one(data, '{{ $voucherNo }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#name').val( response.data.name );
			$('#context').val( response.data.context );
			$('#unit_count').val( response.data.unit_count );

			$('input[name=date_use][value='+response.data.date_use+']').prop('checked', true);

			if(response.data.use_partner == 'Y') {
				$('#use_partner').prop('checked', true);
				voucherInfo.partner_seqno = response.data.partner_seqno;
				voucherInfo.store_seqno = response.data.store_seqno;
				voucherInfo.service_seqno = response.data.service_seqno;
			}
			$('#return_point').val( response.data.return_point );
			$('#date_use').val( response.data.date_use );
			toggleSelect();

			getPartners();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	
	function remove(){
		if(!confirm('정말 삭제 하시겠습니까?')) {
			return;
		}
		medibox.methods.point.vouchers.remove({
			id: userId
		}, '{{ $voucherNo }}', function(request, response){
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
