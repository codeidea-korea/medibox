
@php 
$page_title = $couponNo == 0 ? '이벤트 쿠폰 등록' : '이벤트 쿠폰 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">이벤트 쿠폰 @php echo $couponNo == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents" style="flex-direction: column;">
		<div class="wr-wrap line label160">
			<h3>기본 정보</h3>
			<div class="wr-list">
				<div class="wr-list-label">이벤트명</div>
				<div class="wr-list-con">
					<input type="text" id="name" name="" value="" class="span200" placeholder="이벤트명을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">이벤트 내용</div>
				<div class="wr-list-con">
					<textarea id="context" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">이벤트 썸네일 이미지</div>
				<div class="wr-list-con">
					<div class="filebox">
						<input type="text" value="선택된 파일이 없습니다." id="thumbnail" class="upload-name" disabled="disabled">
						<label for="upload_0" class="upload-btn">파일찾기
							<input name="" type="file" multiple="" id="upload_0" class="upload-hidden" onchange="uploadFile(this, 'thumbnail')">
						</label>
					</div>
					<!--
					<p class="help-block">
						※ 이미지 확장자는 PNG, JPG, JPEG 만 가능합니다.<br>
					</p>
					-->
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">이벤트 상세 이미지</div>
				<div class="wr-list-con">
					<div class="filebox">
						<input type="text" value="선택된 파일이 없습니다." id="img" class="upload-name" disabled="disabled">
						<label for="upload_1" class="upload-btn">파일찾기
							<input name="" type="file" multiple="" id="upload_1" class="upload-hidden" onchange="uploadFile(this, 'img')">
						</label>
					</div>
					<!--
					<p class="help-block">
						※ 이미지 확장자는 PNG, JPG, JPEG 만 가능합니다.<br>
					</p>
					-->
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">이벤트 기간</div>
				<div class="wr-list-con">
					<input type="text" id="_start" class="datepick _start">			
					~
					<input type="text" id="_end" class="datepick _end">		
					*이벤트 기간에만 쿠폰 발급 가능. 이벤트 발급 중지, 종료시 쿠폰 발급 불가. 시간은 00:00:00기준.
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰 사용 유무</div>
				<div class="wr-list-con">
					<label class="toggle-light">
						<input type="checkbox" id="used_coupon" name="" value="1" class="" onclick="toggleView()"><span></span>
						<span class="labelOn">사용</span>
						<span class="labelOff">미사용</span>
					</label>
				</div>
			</div>
		</div>
		<br>
		<div class="wr-wrap line label160 _usedCoupon">
			<h3>쿠폰 기본 정보</h3>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰 제휴사</div>
				<div class="wr-list-con">
					<label class="checkbox-wrap">
						<input type="checkbox" id="is_all_partners" checked onclick="togglePartners()" />
						<span></span>전체
					</label>
					<input type="hidden" id="coupon_partner_grp_seqno" name="" value="0" class="" disabled>
					<select class="default" id="partnersPop" onchange="addPartner()">
						<option>검색가능 셀렉트</option>
					</select>
					<div class="mt10 _partners">
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰명</div>
				<div class="wr-list-con">
					<input type="text" id="coupon_name" name="" value="" class="span200" placeholder="쿠폰명을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰 내용</div>
				<div class="wr-list-con">
					<textarea id="coupon_context" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
		</div>
		<br>
		<div class="wr-wrap line label160 _usedCoupon">
			<h3>발급 정보</h3>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰 사용 기간</div>
				<div class="wr-list-con">
					<input type="text" id="_coupon_start" class="datepick _coupon_start">			
					~
					<input type="text" id="_coupon_end" class="datepick _coupon_end">		
					*쿠폰 사용기간은 00:00:00 기준. *회원가입은 발급일(회원 가입)후 쿠폰 사용기간 한달.
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰 할인 유형</div>
				<div class="wr-list-con">
					<label class="radio-wrap"><input type="radio" name="coupon_type" onclick="toggleDiscountInfo(this.value)" value="F"><span></span>정액할인</label>
					<label class="radio-wrap"><input type="radio" name="coupon_type" onclick="toggleDiscountInfo(this.value)" value="P"><span></span>정률할인</label>
					<label class="radio-wrap"><input type="radio" name="coupon_type" onclick="toggleDiscountInfo(this.value)" value="G"><span></span>상품지급</label>
				</div>
			</div>
			<div class="wr-list _type_discount">
				<div class="wr-list-label">할인금액</div>
				<div class="wr-list-con">
					<input type="number" id="discount_price" name="" value="" class="span200" placeholder="0">
					<span class="_type_amount">원</span>
					<span class="_type_percent">% 최대할인</span>
					<input type="number" id="max_discount_price" name="" value="" class="span200 _type_percent" placeholder="0">
				</div>
			</div>
			<div class="wr-list _type_discount">
				<div class="wr-list-label">최소 기준 금액</div>
				<div class="wr-list-con">
					<label class="radio-wrap"><input type="radio" name="limit_type" onclick="toggleLimitType(this.value)" value="" checked="checked"><span></span>제한없음</label>
					<label class="radio-wrap"><input type="radio" name="limit_type" onclick="toggleLimitType(this.value)" value="F"><span></span>서비스 최소 결제금액</label>
					<input type="number" id="limit_base_price" name="" value="" class="span200" placeholder="">원
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($couponNo != 0) {
		@endphp
		<a href="#" onclick="setStatus('C')" class="btn blue _btnStopIssuance">발급중지</a>
		<a href="#" onclick="setStatus('E')" class="btn blue _btnEndIssuance">발급종료</a>
		<a href="#" onclick="setStatus('A')" class="btn blue _btnReStartIssuance">발급재개</a>

		<a href="#" onclick="remove()" class="btn red">삭제</a>
		<a href="#" onclick="modify()" class="btn blue">수정</a>
		@php 
		}
		@endphp
		@php
		if($couponNo == 0) {
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
		window.location.href = '/admin/service/event-coupon';
	}
	var startDay = '';
	var endDay = '';
	var couponStartDay = '';
	var couponEndDay = '';

	
	$('._start').datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		startDay = $(this).val();
	});
	$('._end').datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		endDay = $(this).val();
	});
	$('._coupon_start').datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		couponStartDay = $(this).val();
	});
	$('._coupon_end').datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy-mm-dd'
	}).on('change', function(e) {
		couponEndDay = $(this).val();
	});
	function toDateFormatt(times){
		var thisDay = new Date(times);
		return thisDay.getFullYear() + '-' + (thisDay.getMonth() + 1 < 10 ? '0' : '') + (thisDay.getMonth()+1) + '-' + (thisDay.getDate() < 10 ? '0' : '') + thisDay.getDate();
	}
	function setDay(date) {
		var date = new Date();
		var prevDate = new Date();
		prevDate.setDate(prevDate.getDate() + date);
		$(".datepick._start").datepicker('setDate', toDateFormatt(prevDate.getTime()));
		$(".datepick._end").datepicker('setDate', toDateFormatt(date.getTime()));
	}
	function uploadFile(target, returnInput){
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
	
	function toggleDiscountInfo(val){
		if(val == 'F') {
			$('#discount_price').val(0);
			$('#max_discount_price').val(0);
			$('._type_discount').show();
			$('._type_percent').hide();
		} else if(val == 'P') {
			$('#discount_price').val(0);
			$('#max_discount_price').val(0);
			$('._type_discount').show();
			$('._type_percent').show();
		} else if(val == 'G') {
			$('#discount_price').val(0);
			$('#max_discount_price').val(0);
			$($('input[name=limit_type]')[0]).attr('checked');
			$('#limit_base_price').val(0);
			$('._type_discount').hide();
		} 
	}
	function toggleLimitType(val){
		if(val == '') {
			$('#limit_base_price').val(0);
			$('#limit_base_price').hide();
		} else if(val == 'F'){
			$('#limit_base_price').val('');
			$('#limit_base_price').show();
		}
	}
	
	function toggleView(){
		if($('#used_coupon').is(':checked')) {
			$('._usedCoupon').show();
		} else {
			$('._usedCoupon').hide();
		}
	}

	function addPartner(){
		var types = document.querySelector('#coupon_partner_grp_seqno').value;
		var typeInput = document.querySelector('#partnersPop').value;
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
		var textType = $('#partnersPop > option:selected').text();

		document.querySelector('#coupon_partner_grp_seqno').value = 
			document.querySelector('#coupon_partner_grp_seqno').value + '|' + typeInput + '|';
		$('._partners').html(
			$('._partners').html() + '<span class="srtag">'+textType+'<i onclick="deleteTypes(this, \''+typeInput+'\')" class="del"></i></span>'
		);
	}
	function deleteTypes(target, name){
		$(target).parent().remove();
		var types = document.querySelector('#coupon_partner_grp_seqno').value;
		types = types.replace('|'+name+'|', '');
		document.querySelector('#coupon_partner_grp_seqno').value = types;
	}
	function togglePartners(){
		if($('#is_all_partners').is(':checked')) {
			$('#coupon_partner_grp_seqno').val('0');
			$('._partners').html('');
			$('#partnersPop').val('');
			$('#partnersPop').prop('disabled', true);
		} else {
			$('#coupon_partner_grp_seqno').val('');
			$('._partners').html('');
			$('#partnersPop').val('');
			$('#partnersPop').prop('disabled', false);
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
					+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	function checkValidationByCoupon(){
		var coupon_partner_grp_seqno = document.querySelector('#coupon_partner_grp_seqno').value;
		var name = document.querySelector('#coupon_name').value;
		var context = document.querySelector('#coupon_context').value;
		var start_dt = couponStartDay;
		var end_dt = couponEndDay;
		var type = $('input[name=coupon_type]:checked').val();
		var discount_price = document.querySelector('#discount_price').value;
		var max_discount_price = document.querySelector('#max_discount_price').value;
		var limit_base_price = document.querySelector('#limit_base_price').value;

		if(!coupon_partner_grp_seqno || coupon_partner_grp_seqno == '') {
			alert('쿠폰을 적용할 대상을 추가해주세요.');
			return false;
		}
		if (!name || name == '') {
			alert('쿠폰명을 입력해주세요.');
			return false;
		}
		if (!context || context == '') {
			alert('쿠폰 내용을 입력해주세요.');
			return false;
		}
		if(type != 'G') {
			if (!discount_price || discount_price == '' || isNaN(discount_price) || Number(discount_price) < 0) {
				alert('쿠폰 할인 금액을 입력해주세요.');
				return false;
			}
			if (!max_discount_price || max_discount_price == '' || isNaN(max_discount_price) || Number(max_discount_price) < 0) {
				alert('쿠폰 최대 할인 금액을 입력해주세요.');
				return false;
			}
		}
		if (!start_dt || start_dt == '') {
			alert('쿠폰 기간을 선택해주세요.');
			return false;
		}
		if (!end_dt || end_dt == '') {
			alert('쿠폰 기간을 선택해주세요.');
			return false;
		}
		return true;
	}

	function checkValidation(){
		var name = $('#name').val();
		var context = $('#context').val();
		var thumbnail = $('#thumbnail').val();
		var img = $('#img').val();
		var start_dt = startDay;
		var end_dt = endDay;
		var used_coupon = $('#used_coupon').is(':checked') ? 'Y' : 'N';

		if (!name || name == '') {
			alert('이벤트명을 입력해주세요.');
			return false;
		}
		if (!context || context == '') {
			alert('이벤트 내용을 입력해주세요.');
			return false;
		}
		if (!thumbnail || thumbnail == '') {
			alert('이벤트 썸네일을 입력해주세요.');
			return false;
		}
		if (!img || img == '') {
			alert('이벤트 메인 이미지를 입력해주세요.');
			return false;
		}
		if (!start_dt || start_dt == '') {
			alert('이벤트 기간을 선택해주세요.');
			return false;
		}
		if (!end_dt || end_dt == '') {
			alert('이벤트 기간을 선택해주세요.');
			return false;
		}
		if (used_coupon == 'Y' && !checkValidationByCoupon()) {
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($couponNo == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var name = $('#name').val();
		var context = $('#context').val();
		var thumbnail = $('#thumbnail').val();
		var img = $('#img').val();
		var start_dt = startDay;
		var end_dt = endDay;
		var used_coupon = $('#used_coupon').is(':checked') ? 'Y' : 'N';

		var data = {
			name: name
			, context: context
			, thumbnail: thumbnail
			, img: img
			, start_dt: start_dt
			, end_dt: end_dt
			, used_coupon: used_coupon
			, admin_seqno: {{ $seqno }}
		};
		
		if(used_coupon == 'Y') {
			var coupon_partner_grp_seqno = document.querySelector('#coupon_partner_grp_seqno').value;
			var coupon_name = document.querySelector('#coupon_name').value;
			var coupon_context = document.querySelector('#coupon_context').value;
			var coupon_start_dt = couponStartDay;
			var coupon_end_dt = couponEndDay;
			var coupon_type = $('input[name=coupon_type]:checked').val();
			var coupon_discount_price = document.querySelector('#discount_price').value;
			var coupon_max_discount_price = document.querySelector('#max_discount_price').value;
			var coupon_limit_base_price = document.querySelector('#limit_base_price').value;

			data.coupon_partner_grp_seqno = coupon_partner_grp_seqno;
			data.coupon_name = coupon_name;
			data.coupon_context = coupon_context;
			data.coupon_start_dt = coupon_start_dt;
			data.coupon_end_dt = coupon_end_dt;
			data.coupon_type = coupon_type;
			data.coupon_discount_price = coupon_discount_price;
			data.coupon_max_discount_price = coupon_max_discount_price;
			data.coupon_limit_base_price = coupon_limit_base_price;
		}

		medibox.methods.event.coupon.add(data, function(request, response){
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
		startDay = toDateFormatt(new Date().getTime());
		endDay = toDateFormatt(new Date().getTime());
		couponStartDay = toDateFormatt(new Date().getTime());
		couponEndDay = toDateFormatt(new Date().getTime());

		togglePartners();
		toggleView();
		getPartners();
		toggleDiscountInfo('F');
		toggleView();
	});
	@php
	}
	@endphp
	// 수정일 경우
	@php
	if($couponNo != 0) {
	@endphp
	userId = {{$couponNo}};
	
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var name = $('#name').val();
		var context = $('#context').val();
		var thumbnail = $('#thumbnail').val();
		var img = $('#img').val();
		var start_dt = startDay;
		var end_dt = endDay;
		var used_coupon = $('#used_coupon').is(':checked') ? 'Y' : 'N';

		var data = {
			name: name
			, context: context
			, thumbnail: thumbnail
			, img: img
			, start_dt: start_dt
			, end_dt: end_dt
			, used_coupon: used_coupon
			, admin_seqno: {{ $seqno }}
		};
		
		if(used_coupon == 'Y') {
			var coupon_partner_grp_seqno = document.querySelector('#coupon_partner_grp_seqno').value;
			var coupon_name = document.querySelector('#coupon_name').value;
			var coupon_context = document.querySelector('#coupon_context').value;
			var coupon_start_dt = couponStartDay;
			var coupon_end_dt = couponEndDay;
			var coupon_type = $('input[name=coupon_type]:checked').val();
			var coupon_discount_price = document.querySelector('#discount_price').value;
			var coupon_max_discount_price = document.querySelector('#max_discount_price').value;
			var coupon_limit_base_price = document.querySelector('#limit_base_price').value;

			data.coupon_partner_grp_seqno = coupon_partner_grp_seqno;
			data.coupon_name = coupon_name;
			data.coupon_context = coupon_context;
			data.coupon_start_dt = coupon_start_dt;
			data.coupon_end_dt = coupon_end_dt;
			data.coupon_type = coupon_type;
			data.coupon_discount_price = coupon_discount_price;
			data.coupon_max_discount_price = coupon_max_discount_price;
			data.coupon_limit_base_price = coupon_limit_base_price;
		}

		medibox.methods.event.coupon.modify(data, {{$couponNo}}, function(request, response){
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
	function setStatus(status){
		medibox.methods.event.coupon.status({
			status: status
		}, {{$couponNo}}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('발급 상태가 수정 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $couponNo }}' };

		medibox.methods.event.coupon.one(data, '{{ $couponNo }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			$('#name').val( response.data.name );
			$('#context').val( response.data.context );
			$('#thumbnail').val( response.data.thumbnail );
			$('#img').val( response.data.img );
			$('#_start').val( response.data.start_dt.split(' ')[0] );
			$('#_end').val( response.data.end_dt.split(' ')[0] );
			startDay = response.data.start_dt.split(' ')[0];
			endDay = response.data.end_dt.split(' ')[0];
			if(response.data.used_coupon == 'Y') {
				$('#used_coupon').prop('checked', true);

				if(response.data.coupon) {
					// 쿠폰 정보
					$('#coupon_name').val( response.data.coupon.name );
					$('#coupon_context').val( response.data.coupon.context );
					$('input[name=type][value='+response.data.coupon.type+']').prop('checked', true);
					$('#_coupon_start').val( response.data.coupon.start_dt.split(' ')[0] );
					$('#_coupon_end').val( response.data.coupon.end_dt.split(' ')[0] );

					couponStartDay = response.data.coupon.start_dt.split(' ')[0];
					couponEndDay = response.data.coupon.end_dt.split(' ')[0];

					$('input[name=coupon_type][value='+response.data.coupon.type+']').prop('checked', true);

					if(response.data.coupon.use_partner == 'Y') {
						$('#use_partner').prop('checked', true);
						voucherInfo.partner_seqno = response.data.coupon.partner_seqno;
						voucherInfo.store_seqno = response.data.coupon.store_seqno;
						voucherInfo.service_seqno = response.data.coupon.service_seqno;
					}
					$('#discount_price').val( response.data.coupon.discount_price );
					$('#max_discount_price').val( response.data.coupon.max_discount_price );
					$('#limit_base_price').val( response.data.coupon.limit_base_price );
					if(response.data.coupon.limit_base_price > 0) {
						$($('input[name=limit_type]')[1]).attr('checked');
					}

					$('#coupon_partner_grp_seqno').val( response.data.coupon.coupon_partner_grp_seqno );

					if(response.data.coupon.coupon_partner_grp_seqno && response.data.coupon.coupon_partner_grp_seqno != '') {
						if(response.data.coupon_partner_grp_seqno == 0) {
							// 전체 선택
							togglePartners();
						} else {
							var types = response.data.coupon.coupon_partner_grp_seqno.split('||');
							for(var inx=0; inx<types.length; inx++){
								types[inx] = (types[inx] + '').replaceAll('|', '');
								$('._partners').html(
									$('._partners').html() + '<span class="srtag">'+$('#partnersPop > option[value='+types[inx]+']').text()+'<i onclick="deleteTypes(this, \''+types[inx]+'\')" class="del"></i></span>'
								);
							}
						}
					}
					toggleDiscountInfo(response.data.coupon.type);
				}
				toggleView();
			} else {
				$('._usedCoupon').hide();
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
		medibox.methods.event.coupon.remove({
			id: userId
		}, '{{ $couponNo }}', function(request, response){
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
		startDay = toDateFormatt(new Date().getTime());
		endDay = toDateFormatt(new Date().getTime());
		couponStartDay = toDateFormatt(new Date().getTime());
		couponEndDay = toDateFormatt(new Date().getTime());

		toggleView();
		getPartners();
		getInfo();
	});
	@php
	}
	@endphp
	</script>
</section>

@include('admin.footer')
