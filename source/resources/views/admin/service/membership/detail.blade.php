
@php 
$page_title = $membershipNo == 0 ? '멤버쉽 등록' : '멤버쉽 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">멤버쉽 @php echo $membershipNo == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 이름</div>
				<div class="wr-list-con">
					<input type="text" id="name" name="" value="" class="span200" placeholder="멤버쉽명을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 가격</div>
				<div class="wr-list-con">
					<input type="number" id="price" name="" value="" class="span200" placeholder="멤버쉽 가격을 입력해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 사용 기간</div>
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
			<!--
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 메인 바우처 (매장 서비스)</div>
				<div class="wr-list-con">
					<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
						<option value="">검색가능 셀렉트</option>
					</select>
					<select class="default" id="storePop" onchange="getServicePop(this.value)">
						<option value="">검색가능 셀렉트</option>
					</select>
					<select class="default" id="servicePop">
						<option value="">검색가능 셀렉트</option>
					</select>
					<input type="number" id="countService" name="" value="" class="span200" placeholder="제공 횟수를 입력해주세요.">
					<a href="#" onclick="addServiceVoucher()" class="btn black ml5">추가</a>

					<br>
					<input type="hidden" id="services" name="" value="">
					<div class="tbl-basic cell td-h1">
						<table>
							<thead>
								<tr>
									<th>제휴사</th>
									<th>매장</th>
									<th>서비스</th>
									<th>수량</th>
									<th> </th>
								</tr>
							</thead>
							<tbody id="serviceDetail">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			-->
			<div class="wr-list">
				<div class="wr-list-label">부여 포인트</div>
				<div class="wr-list-con">
					<input type="number" id="point" name="" value="" class="" placeholder="부여할 포인트를 입력해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 바우처</div>
				<div class="wr-list-con">
					바우처 검색 
					<input type="text" id="voucherName" name="" value="" class="span200" placeholder="바우처명을 입력해주세요.">
					<a href="#" onclick="popOpenVoucher()" class="btn black ml5">검색</a>

					<br>
					<input type="hidden" id="vouchers" name="" value="">
					<div class="tbl-basic cell td-h1">
						<table>
							<thead>
								<tr>
									<th>바우처명</th>
									<th>제공 수량</th>
									<th> </th>
								</tr>
							</thead>
							<tbody id="voucherDetail">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">멤버쉽 쿠폰</div>
				<div class="wr-list-con">
					쿠폰 검색 
					<input type="text" id="couponName" name="" value="" class="span200" placeholder="쿠폰명을 입력해주세요.">
					<a href="#" onclick="popOpenCoupon()" class="btn black ml5">검색</a>

					<br>
					<input type="hidden" id="coupons" name="" value="">
					<div class="tbl-basic cell td-h1">
						<table>
							<thead>
								<tr>
									<th>쿠폰명</th>
									<th> </th>
								</tr>
							</thead>
							<tbody id="couponDetail">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($membershipNo != 0) {
		@endphp
		<a href="#" id="_remove" onclick="remove()" class="btn red">단종</a>
		<a href="#" id="_rollback" onclick="sellsStatusModify()" class="btn blue">판매</a>
		<!-- <a href="#" onclick="modify()" class="btn blue">수정</a> -->
		@php 
		}
		@endphp
		@php
		if($membershipNo == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
	</div>

	<script>
	var userId;
	var voucherInfo = {};
	function popHide(){
		$('body, html').css('overflow', 'none');
		$('.layer-popup').hide();
	}
	function cancel(){
		window.location.href = '/admin/service/membership';
	}

	function addService(partnerName, storeName, serviceName, serviceId, countService){
		$('#services').val($('#services').val() + '|' + serviceId + '-' + countService + '|');
		$('#serviceDetail').html(
			$('#serviceDetail').html() 
				+ '<tr><td>' + partnerName + '</td>'
				+ '<td>' + storeName + '</td>'
				+ '<td>' + serviceName + '</td>'
				+ '<td>' + countService + '</td>'
				+ '<td><a href="#" onclick="deleteServiceVoucher(this, \''+('|' + serviceId + '-' + countService + '|')+'\')" class="btnEdit">삭제</a></td></tr>'
		);
	}
	function addServiceVoucher(){
		var partnerId = $('#partnersPop').val();
		var storeId = $('#storePop').val();
		var serviceId = $('#servicePop').val();
		var countService = $('#countService').val();

		if(!partnerId || partnerId == '') {
			alert('추가할 바우처의 제휴사를 선택해주세요.');
			return false;
		}
		if(!partnerId || partnerId == '') {
			alert('추가할 바우처의 매장을 선택해주세요.');
			return false;
		}
		if(!partnerId || partnerId == '') {
			alert('추가할 바우처의 서비스를 선택해주세요.');
			return false;
		}
		if(!countService || countService == '' || countService < 1) {
			alert('추가할 바우처의 서비스 수량을 입력해주세요. (1이상 숫자만 입력해주세요.)');
			return false;
		}
		var partnerName = $('#partnersPop > option:selected').text();
		var storeName = $('#storePop > option:selected').text();
		var serviceName = $('#servicePop > option:selected').text();

		addService(partnerName, storeName, serviceName, serviceId, countService);
	}

	function deleteServiceVoucher(target, item){
		$(target).parent().parent().remove();
		var servicesReplace = $('#services').val();
		servicesReplace.replace(item, '');
		$('#services').val(servicesReplace);
	}

	function deleteSubVoucher(target, item){
		$(target).parent().parent().remove();
		var servicesReplace = $('#vouchers').val();
		servicesReplace.replace(item, '');
		$('#vouchers').val(servicesReplace);
	}

	function deleteCoupon(target, item){
		$(target).parent().parent().remove();
		var servicesReplace = $('#coupons').val();
		servicesReplace.replace(item, '');
		$('#coupons').val(servicesReplace);
	}

	function addSubVoucher(voucherName, countVoucher, id){
		/*
		$('#vouchers').val($('#vouchers').val() + '|' + id + '|');
		$('#voucherDetail').html(
			$('#voucherDetail').html() 
				+ '<tr><td>' + voucherName + '</td>'
				+ '<td>' + countVoucher + '</td>'
				+ '<td><a href="#" onclick="deleteSubVoucher(this, \''+('|' + id + '|')+'\')" class="btnEdit">삭제</a></td></tr>'
		);
		*/
		$('#vouchers').val($('#vouchers').val() + '|' + id + '-' + countVoucher + '|');
		$('#voucherDetail').html(
			$('#voucherDetail').html() 
				+ '<tr><td>' + voucherName + '</td>'
				+ '<td><input type="text" id="voucher_'+id+'" class="_vouchers" data-key="'+id+'" value="1"></td>'
				+ '<td><a href="#" onclick="deleteSubVoucher(this, \''+('|' + id + '-' + countVoucher + '|')+'\')" class="btnEdit">삭제</a></td></tr>'
		);
	}

	function addCoupon(couponName, id){
		$('#coupons').val($('#coupons').val() + '|' + id + '|');
		$('#couponDetail').html(
			$('#couponDetail').html() 
				+ '<tr><td>' + couponName + '</td>'
				+ '<td><a href="#" onclick="deleteCoupon(this, \''+('|' + id + '|')+'\')" class="btnEdit">삭제</a></td></tr>'
		);
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
					+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
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
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'">'+response.data[inx].name+'</option>';
			}
			store = response.data;
			$('#storePop').html(bodyData);
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
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'">['+response.data[inx].dept + '] ' +response.data[inx].name+'</option>';
			}
			$('#servicePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function checkValidation(){
		var name = document.querySelector('#name').value;
		var price = document.querySelector('#price').value;

		var date_use = $('input[name=date_use]:checked').val();
		var point = document.querySelector('#point').value;

		var services = $('#services').val();
		var vouchers = $('#vouchers').val();
		var coupons = $('#coupons').val();

		if(!name || name == '') {
			alert('멤버쉽 이름을 입력해주세요.');
			return false;
		}
		if (!price || price == '') {
			alert('멤버쉽 가격을 입력해주세요.');
			return false;
		}
		if (!date_use || date_use == '') {
			alert('멤버쉽 기간을 선택해주세요.');
			return false;
		}
		if (!point || point == '' || point < 0) {
			alert('멤버쉽 지급 포인트를 입력해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($membershipNo == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var name = document.querySelector('#name').value;
		var price = document.querySelector('#price').value;

		var date_use = $('input[name=date_use]:checked').val();
		var point = document.querySelector('#point').value;

		$('#vouchers').val('');
		for(var inx= 0; inx<$('._vouchers').length; inx++){
			var seqno = $($('._vouchers')[inx]).attr('data-key');
			var count = $($('._vouchers')[inx]).val();
			$('#vouchers').val($('#vouchers').val() + '' + ('|' + seqno + '-' + count + '|'));
		}

		var services = $('#services').val();
		var vouchers = $('#vouchers').val();
		var coupons = $('#coupons').val();

		medibox.methods.point.membership.add({
			name: name
			, price: price
			, date_use: date_use
			, point: point
			, services: services
			, vouchers: vouchers
			, coupons: coupons
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
		popHide();
		getPartners();
	});
	@php
	}
	@endphp
	// 수정일 경우
	@php
	if($membershipNo != 0) {
	@endphp
	userId = {{$membershipNo}};
	
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var name = document.querySelector('#name').value;
		var price = document.querySelector('#price').value;

		var date_use = $('input[name=date_use]:checked').val();
		var point = document.querySelector('#point').value;

		$('#vouchers').val('');
		for(var inx= 0; inx<$('._vouchers').length; inx++){
			var seqno = $($('._vouchers')[inx]).attr('data-key');
			var count = $($('._vouchers')[inx]).val();
			$('#vouchers').val($('#vouchers').val() + '' + ('|' + seqno + '-' + count + '|'));
		}

		var services = $('#services').val();
		var vouchers = $('#vouchers').val();
		var coupons = $('#coupons').val();

		medibox.methods.point.membership.modify({
			name: name
			, price: price
			, date_use: date_use
			, point: point
			, services: services
			, vouchers: vouchers
			, coupons: coupons
			, admin_seqno: {{ $seqno }}
		}, {{$membershipNo}}, function(request, response){
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
		medibox.methods.point.membership.modify({
			name: info.name
			, price: info.price
			, date_use: info.date_use
			, point: info.point
			, services: info.services
			, vouchers: info.vouchers
			, coupons: info.coupons
			, admin_seqno: {{ $seqno }}
			, deleted: 'N'
		}, {{$membershipNo}}, function(request, response){
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
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $membershipNo }}' };

		medibox.methods.point.membership.one(data, '{{ $membershipNo }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			info = response.data;
			if(response.data.deleted == 'Y') {
				$('#_remove').hide();
				$('#_rollback').show();
			} else {
				$('#_remove').show();
				$('#_rollback').hide();
			}

			$('#name').val( response.data.name );
			$('#price').val( response.data.price );

			$('input[name=date_use][value='+response.data.date_use+']').prop('checked', true);
			$('#point').val( response.data.point );

			if(response.data.services && response.data.services.length > 0) {
				for(var idx = 0; idx < response.data.services.length; idx++){
					addService(
						response.data.services[idx].partnerInfo.cop_name, 
						response.data.services[idx].storeInfo.name, 
						response.data.services[idx].name, 
						response.data.services[idx].service_seqno, 
						response.data.services[idx].unit_count);
				}
			}
			if(response.data.vouchers && response.data.vouchers.length > 0) {
				for(var idx = 0; idx < response.data.vouchers.length; idx++){
					addSubVoucher(response.data.vouchers[idx].name, response.data.vouchers[idx].unit_count, response.data.vouchers[idx].seqno);
				}
			}
			if(response.data.coupons && response.data.coupons.length > 0) {
				for(var idx = 0; idx < response.data.coupons.length; idx++){
					addCoupon(response.data.coupons[idx].name, response.data.coupons[idx].seqno);
				}
			}
			info.services = $('#services').val();
			info.vouchers = $('#vouchers').val();
			info.coupons = $('#coupons').val();

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
		medibox.methods.point.membership.remove({
			id: userId
		}, '{{ $membershipNo }}', function(request, response){
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
		popHide();
		getInfo();
	});
	@php
	}
	@endphp
	</script>
</section>

@include('admin.service.membership.pop.vouchers')
@include('admin.service.membership.pop.coupons')
@include('admin.footer')
