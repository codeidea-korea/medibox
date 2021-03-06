
<div id="mediboxpop-point1" class="layerPopup zoom-anim-dialog mfp-hide">
	<div class="popContainer">
		
		<header class="pop-header">
			포인트 사용
		</header>

		<form name="fboardlist" action="" method="post">
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">포인트 사용 유저 정보</div>
			</div>
			<table id="resident_list">
				<colgroup>
					<col width="180">
					<col width="180">
					<col width="180">
				</colgroup>
				<thead>
					<tr>
						<th>아이디</th>
						<th>이름</th>
						<th>회원가입일</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="_userId">010-0000-0000</td>
						<td class="_userName">홍길동</td>
						<td class="_createAt">2021-12-28 00:00:00</td>
					</tr>
				</tbody>			
			</table>
		</div>
		<div style="clear:both;height:20px;"></div>
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">보유 포인트</div>
			</div>
			<table id="resident_list">
				<colgroup>
					<col width="80">
					<col width="180">
				</colgroup>
				<thead>
					<tr>
						<th>포인트</th>
						<td class="tright _userPoint">100,000 P</td>
					</tr>
					
					<tr>
						<th rowspan="3">정액권</th>
						<td class="tright _nail">네일정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</td>
					</tr>
					<tr>
						<td class="tright _balmong">발몽정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2,400,000 P</td>
					</tr>
					<tr>
						<td class="tright _foresta">포레스타정액권&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1,150,000 P</td>
					</tr>
				</thead>		
			</table>
		</div>
		</form>

		<div style="clear:both;height:20px;"></div>
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">포인트 사용</div>
			</div>
		</div>

		<form name="fboardlist" action="" method="post">
		<div class="wrtieContents">
			<div class="wr-wrap line label130">
				<div class="wr-list">
					<div class="wr-list-label required">포인트 사용 종류 선택</div>
					<div class="wr-list-con flex">					
						<select id="use_point_type" class="default _pointTypes">
							<option>포인트</option>
							<option>네일정액권</option>
							<option>발몽정액권</option>
							<option>포레스타정액권</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">상품선택/직접기입</div>
					<div class="wr-list-con flex">					
						<label class="radio-wrap">
							<input type="radio" name="service_input_type" onclick="toggleServiceInputTypeChange()" value="choose" checked><span></span>상품선택
						</label>
						<label class="radio-wrap">
							<input type="radio" name="service_input_type" onclick="toggleServiceInputTypeChange()" value="self"><span></span>직접기입
						</label>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label required">사용샵</div>
					<div class="wr-list-con flex">					
						<select class="default _shops">
							<option>발몽스파</option>
							<option>바라는네일</option>
							<option>포레스타 블랙</option>
							<option>딥포커스</option>
							<option>미니쉬 스파</option>
							<option>미니쉬 도수</option>
						</select>
					</div>
				</div>
				<div class="wr-list _chooseService">
					<div class="wr-list-label required">서비스</div>
					<div class="wr-list-con flex">					
						<select class="default _services">
							<option>에너지-30분</option>
							<option>에너지-30분</option>
							<option>에너지-30분</option>
						</select>
					</div>
				</div>
				<div class="wr-list _chooseSelf">
					<div class="wr-list-label required">서비스</div>
					<div class="wr-list-con flex">				
						<input type="text" id="use_self_service" name="" value="" class="span" placeholder="서비스 내용을 입력해주세요.">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">현재 보유 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="use_pres_point" name="" value="1,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label required">사용포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="use_point" name="" value="1,000,000 P" class="span _price" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">담당자 아이디</div>
					<div class="wr-list-con flex">					
						<input type="text" id="use_director_name" name="" value="{{ $name }}" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">포인트 차감자</div>
					<div class="wr-list-con flex">					
						<input type="text" id="calculator_name" name="calculator_name" value="" class="span">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">MEMO</div>
					<div class="wr-list-con flex">					
						<textarea name="" id="use_memo" class="mini autoSize " style="min-height:150px;width:100%;" placeholder=""></textarea>
					</div>
				</div>
			</div>		

		</div>
		</form>

		<div class="btnSet">
			<a href="#" onclick="closePopUse()" class="btn large gray popClose">닫기</a>
			<a href="#" onclick="usePoint()" class="btn large blue span120">사용</a>
		</div>

	</div>	
</div>

	<script>
	function getServiceInputType(){
		return $('input[name=service_input_type]:checked').val();
	}
	function toggleServiceInputTypeChange(){
		if(isNotInProduct) {
			return false;
		}
		var service_input_type = getServiceInputType();
		if(service_input_type == 'self') {
			$('#use_self_service').val('');
			$('._chooseSelf').show();
			$('._chooseService').hide();
			$('#use_point').removeAttr('readonly');
			$('#use_point').attr('style', ' ');
		} else {
			// 기존
			$('._chooseService').show();
			$('._chooseSelf').hide();
			$('._price').val(backupPrice);
			$('#use_point').attr('readonly', 'readonly');
			$('#use_point').attr('style', 'background:#d3d3d3;');
		}
	}
	var isNotInProduct = false;
	function checkMustChooseSelf(){
		// NOTICE: 해당하는 옵션은 상품에 없는 내용이므로 반드시 직접 기입만 입력이 가능한 상태
		if(!isNotInProduct) {
			return false;
		}
		// 강제로 직접기입으로 변경
		var serviceInputType = getServiceInputType();
		if(serviceInputType != 'self') {
			alert('해당 서비스는 직접 기입만 제공합니다.');
			$('input[name=service_input_type][value=self]').click();
			$('#use_self_service').val('');
			$('._chooseSelf').show();
			$('._chooseService').hide();
			$('#use_point').removeAttr('readonly');
			$('#use_point').attr('style', ' ');
			$('#use_point').val('0');
			$('input[name=service_input_type][value=choose]').off().on('click', function (){ return false; });
		} else {
			$('input[name=service_input_type][value=choose]').off().on('click', toggleServiceInputTypeChange);
		}
		return false;
	}
	function all_checked(sw) {
		var f = document.fboardlist;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk[]")
				f.elements[i].checked = sw;
		}
	}
	function closePopUse(){
		$.magnificPopup.close({
			items: {
				src: '#mediboxpop-point1'
			},
			type: 'inline'
		});
	}
	
	function getUseTypes(){
		getTypes(function (){
			$('#use_point_type > option[value=K]').remove();
			$('#use_point_type > option[value=S1]').remove();

			$('#use_point_type').off().on('change', function(){
				getShops($(this).val());
				var type = $(this).val();
				$('#use_pres_point').val(medibox.methods.toNumber(getPoint(type)) +' P'); 
			});
			$('#use_pres_point').val(medibox.methods.toNumber(pointDetails.point.point) +' P'); 
			getShops('P');
		});
	}
	var point_type;
	function getShops(pointType){
		point_type = pointType;
		medibox.methods.point.shops({ point_type: pointType }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpShops = '';
			var targetInx = 0;
			for(var inx = 0; inx < response.data.length; inx++){
				@php
				if(session()->get('admin_type') == 'S') {
					echo 'if("'.$store->name.'".indexOf(response.data[inx].service_name) > -1){';
					echo 'targetInx = inx;';
				}
				@endphp
				tmpShops = tmpShops + '<option data-value="false" value="'+response.data[inx].service_name+'">'+response.data[inx].service_name+'</option>';
				@php
				if(session()->get('admin_type') == 'S') {
					echo '}';
				}
				@endphp
			}
			$('._shops').html(tmpShops);
			
			// NOTICE: 닥터 미니쉬는 직접기입으로만 가능한 형태 (상품 DB X - 서비스명, 가격이 항상 다를수 있으므로..)
			@php
			if(session()->get('admin_type') != 'S') {
				@endphp
				$("._shops").append('<option data-value="true" value="닥터 미니쉬">닥터 미니쉬</option>');
				@php
			}
			@endphp

			$('._shops').off().on('change', function(){
				isNotInProduct = $(this).find('option[value=\"'+$(this).val()+'\"]').attr('data-value') == 'true';

				if(!isNotInProduct) {
					getServices(point_type, $(this).val());
				} else {
					checkMustChooseSelf();
				}
			});
			getServices(point_type, response.data[targetInx].service_name);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var service_name;
	var product_seqno;
	var backupPrice;
	function getServices(pointType, shopName){
		service_name = shopName;
		@php
		if(session()->get('admin_type') == 'P') {
//			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
//			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'if(pointType != "K" && pointType != "P") pointType = ' . $point_type . ';';
		}
		@endphp

		medibox.methods.point.services({ point_type: pointType, service_name: shopName }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpServices = '';
			for(var inx = 0; inx < response.data.length; inx++){		
				tmpServices = tmpServices + '<option value="'+response.data[inx].product_seqno+'" price="'+response.data[inx].price+'">'+response.data[inx].type_name+(response.data[inx].service_sub_name ? '-'+response.data[inx].service_sub_name : '') + ' ('+ medibox.methods.toNumber(response.data[inx].price)+' 원)</option>';
			}
			$('._services').html(tmpServices);
			
			$('._services').off().on('change', function(){
				product_seqno = $(this).val();
				$('._price').val(medibox.methods.toNumber($(this).find('option:selected').attr('price')) +' P');
			});
			product_seqno = response.data[0].product_seqno;
			var service_input_type = getServiceInputType();
			if(service_input_type != 'self') {
				$('._price').val(medibox.methods.toNumber(response.data[0].price) +' P');
			}
			backupPrice = medibox.methods.toNumber(response.data[0].price) +' P';
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function usePoint(){
		var service_input_type = getServiceInputType();

		if(service_input_type == 'self') {
			var point_type = $('#use_point_type').val();
			var use_self_service = $('#use_self_service').val();
			var amount = $('#use_point').val();
			var memo = '[관리자구매신청] '+$('#use_memo').val().replaceAll('[관리자구매신청]', '');
			var admin_name = $('#calculator_name').val();
			
			var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, shop_name: service_name, service_name: use_self_service,
				point_type:point_type, amount:replacePoint(amount), memo:memo, admin_name: admin_name };

			medibox.methods.point.useSelf(data, function(request, response){
				console.log('output : ' + response);
				if(!response.result){
					alert(response.ment.replace('\\r', '\n'));
					return false;
				}
				alert(response.ment.replace('\\r', '\n'));
				location.reload();
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});
		} else {
			var point_type = $('#use_point_type').val();
			var memo = '[관리자구매신청] '+$('#use_memo').val().replaceAll('[관리자구매신청]', '');
			var admin_name = $('#calculator_name').val();
			
			var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, product_seqno: product_seqno,
				point_type:point_type, memo:memo, admin_name: admin_name, approved: 'Y' };

			medibox.methods.point.use(data, function(request, response){
				console.log('output : ' + response);
				if(!response.result){
					alert(response.ment.replace('\\r', '\n'));
					return false;
				}
				alert(response.ment.replace('\\r', '\n'));
				location.reload();
			}, function(e){
				console.log(e);
				alert('서버 통신 에러');
			});
		}
	}
	$(document).ready(function(){
		toggleServiceInputTypeChange();
	});
	</script>