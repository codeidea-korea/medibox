
<div class="layer-popup" id="popReservation">
	<button class="pop-closer" onclick="popHide()"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header">
				예약 등록
			</header>
			<div class="wr-wrap line label130 padding10">
				<div class="wr-list" style="width:50%;float:left;">
					<div class="wr-list-label ">
						<select class="default">
							<option data-subtext="">전화번호/이름</option>
						</select>
					</div>
					<div class="wr-list-con">			
						<input type="text" name="searchUserId" value="" required class="span" style="width:160px;">		
						<a href="#" onclick="getUserList()" class="btn large blue span100">조회</a>
						<a href="/admin/members/0" class="btn large blue span100">고객등록</a>
					</div>
					
					<div style="width:100%;clear:both;height:5px;"></div>
	
					<form name="fboardlist" action="" method="post">
					<div class="tbl-basic cell td-h1">
						<!-- <div class="tbl-header">
							<div class="caption">총 000건</div>
						</div> -->
						<table id="resident_list">
							<colgroup>
								<col width="60">
								<col>
								<col width="180">
								<col width="180">
							</colgroup>
							<thead>
								<tr>
									<th>이름</th>
									<th>고객번호</th>
									<th>휴대폰</th>
									<th>정보</th>
								</tr>
							</thead>
							<tbody id="_reservationTargetUsers">
								<!--
								<tr>
									<td>김메디</td>
									<td>1234565213</td>
									<td>010-1123-4123</td>
									<td><a href="#" class="btn large blue span100">고객정보</a></td>
								</tr>
								<tr>
-->
							</tbody>
							</table>
					</div>
					</form>	
				</div>		
				<div class="wr-list" style="width:50%;float:left;">	
						<form name="fboardlist" action="" method="post">
						<div class="tbl-basic cell td-h1">
							<table id="resident_list">
								<colgroup>
									<col width="120">
									<col width="120">
									<col width="120">
									<col width="120">
								</colgroup>
								<tbody>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">아이콘표시</td>
										<td  style="border:1px solid #000;" colspan="3">
											<label class="checkbox-wrap"><input type="checkbox" id="use_icon_important" name="use_icon_important" value="" checked  /><span></span>중요고객★</label>
											<label class="checkbox-wrap"><input type="checkbox" id="use_icon_phone" name="use_icon_phone" value=""  /><span></span>전화☏</label>
											<label class="checkbox-wrap"><input type="checkbox" id="use_custom_color" name="use_custom_color" value=""  /><span></span>색상선택</label>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">제휴사</td>
										<td  style="border:1px solid #000;">
											<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
												<option data-subtext="">제휴사</option>
												<option value="퇴사">제휴사A</option>
											</select>
										</td>
										<td  style="border:1px solid #000;">매장</td>
										<td  style="border:1px solid #000;">
											<select  class="default" id="storePop" onchange="getManagersPop()">
												<option data-subtext="" value="">제휴사를 먼저 선택해주세요.</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">디자이너</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="managerPop" onchange="getServicesPop(this.text)">
												<option data-subtext="" value="">매장을 먼저 선택해주세요.</option>
											</select>
										</td>
									</tr>
									
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약일시</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<label class="inp-wrap left-label"><span class="label">날짜</span><input type="text" id="startDate" name="" value="" class="span130 datepicker"></label>
											<select class="default" id="startTime1">
												<option data-subtext="">12시</option>
												<option data-subtext="">12시</option>
											</select>
											<select class="default" id="startTime2">
												<option data-subtext="">30분</option>
												<option data-subtext="">30분</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약항목</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="servicePop">
												<option data-subtext="">컷</option>
												<option>컷</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">소요시간</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select class="default" id="estimated_time">
												<option data-subtext="">1시간 50분</option>
												<option>1시간 50분</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약메모</td>
										<td  style="border:1px solid #000;" colspan="3">
											<textarea id="memo" name="" class="mini autoSize" placeholder="메모"></textarea>
										</td>
									</tr>
								</tbody>
								</table>
						</div>
						</form>
				</div>
			</div>	
			<div class="btnSet">
				<a href="#" class="btn large blue span120" onclick="add()">저장</a>
				<a href="#" class="btn large gray popClose" onclick="popHide()">취소</a>
			</div>
		</div>
	</div>

	<div class="pop-bg"></div>
</div>

<script>	
	function getUserList(){
		var startDay = $('input[name=startDay]').val();
		var endDay = $('input[name=endDay]').val();
		var searchField = $('input[name=searchUserId]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		if(startDay && startDay != '') {
			data.start_day = startDay.replace('.', '-').replace('.', '-');
		}
		if(endDay && endDay != '') {
			data.end_day = endDay.replace('.', '-').replace('.', '-');
		}
		if(searchField && searchField != '') {
			data.search = searchField;
		}

		medibox.methods.user.members(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			if(response.count == 0){
				$('#_reservationTargetUsers').html('<tr>'
									+'    <td colspan="4" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				return;
			}

			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
							+'<tr data-key="'+response.data[inx].user_seqno+'" onclick="chooseUser('+response.data[inx].user_seqno+')" style="cursor:pointer;">'
							+'	<td>'+response.data[inx].user_name+'</td>'
							+'	<td>MEDIBOX-'+response.data[inx].user_seqno+'</td>'
							+'	<td>'+response.data[inx].user_phone+'</td>'
							+'	<td><a href="#" class="btn large blue span100" onclick="gotoInfoDetail(\''+response.data[inx].user_seqno+'\')">고객정보</a></td>'
							+'</tr>';
			}
			$('#_reservationTargetUsers').html(bodyData);
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
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" onclick="getManagersPop('+response.data[inx].seqno+')">'+response.data[inx].name+'</option>';
			}
			$('#storePop').html(bodyData);
			stores = response.data;
			makeManagers();
			getServicesPop();
			getManagersPop();
			dueDay();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getManagersPop(){
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();

		if(partner && partner != '') {
			data.partner_seqno = partner;
		}
		if(store && store != '') {
			data.store_seqno = store;
		}

		medibox.methods.store.manager.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			var bodyData = '<option value="0">기본 (특정 담당 직원/직위 지정 없음)</option>';
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].manager_type + ' ' +response.data[inx].name +'</option>';
			}
			$('#managerPop').html(bodyData);
			getServicesPop();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function chooseUser(seq){
		user_seqno = seq;
		$('#_reservationTargetUsers > tr > td').attr('style', '');
		$('#_reservationTargetUsers > tr[data-key='+seq+'] > td').attr('style', 'background:green;color:#fff;');
	}
	function getServicesPop(manager_type){
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();

		if(partner && partner != '') {
			data.partner_seqno = partner;
		}
		if(store && store != '') {
			data.store_seqno = store;
		}
		if(manager_type && manager_type != '') {
			data.manager_type = manager_type.split(' ')[0];
		}
		
		medibox.methods.store.manager.services.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			if(!response.data || response.data.length == 0) {
				return;
			}
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<option value="'+response.data[inx].seqno+'">'+response.data[inx].name +'</option>';
			}
			$('#servicePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var user_seqno;
	var prevDataId;
	function add(){
		if(!checkValidation()) {
			return;
		}
		if(!user_seqno || user_seqno == '') {
			alert('예약할 고객을 선택해주세요.');
			return false;
		}
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').is(":checked") ? 'Y' : 'N';
		var use_icon_phone = $('#use_icon_phone').is(":checked") ? 'Y' : 'N';
		var use_custom_color = $('#use_custom_color').is(":checked") ? 'Y' : 'N';
		var estimated_time = $('#estimated_time').val(); 
		var start_dt = $('#startDate').val() + ' ' + $('#startTime1').val() + ':' + $('#startTime2').val();
		var memo = $('#memo').val(); 
		var apply_on_mobile = 'N';

		medibox.methods.store.reservation.add({
			status: 'R'
			, use_icon_important: use_icon_important
			, use_icon_phone: use_icon_phone
			, use_custom_color: use_custom_color
			
			, custom_color: '#000000'
			, estimated_time: estimated_time
			, start_dt: start_dt
			, memo: memo
			, apply_on_mobile: apply_on_mobile

			, partner_seqno: partner
			, store_seqno: store
			, manager_seqno: manager
			, user_seqno: user_seqno
			, admin_seqno: {{ $seqno }}
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('추가 되었습니다.');
//			cancel();
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').is(":checked") ? 'Y' : 'N';
		var use_icon_phone = $('#use_icon_phone').is(":checked") ? 'Y' : 'N';
		var use_custom_color = $('#use_custom_color').is(":checked") ? 'Y' : 'N';
		var estimated_time = $('#estimated_time').val(); 
		var start_dt = $('#startDate').val() + ' ' + $('#startTime1').val() + ':' + $('#startTime2').val();
		var memo = $('#memo').val(); 
		var apply_on_mobile = 'N';

		medibox.methods.store.reservation.modify({
			status: 'R'
			, use_icon_important: use_icon_important
			, use_icon_phone: use_icon_phone
			, use_custom_color: use_custom_color
			
			, custom_color: '#000000'
			, estimated_time: estimated_time
			, start_dt: start_dt
			, memo: memo
			, apply_on_mobile: apply_on_mobile

			, partner_seqno: partner
			, store_seqno: store
			, manager_seqno: manager
			, user_seqno: user_seqno
			, admin_seqno: {{ $seqno }}
		}, prevDataId, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
//			cancel();
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	function checkValidation(){
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager = $('#managerPop').val();
		var service_seqno = $('#servicePop').val();
		var use_icon_important = $('#use_icon_important').val();
		var use_icon_phone = $('#use_icon_phone').val();
		var use_custom_color = $('#use_custom_color').val();
		var estimated_time = $('#estimated_time').val(); 
		var start_dt1 = $('#startTime1').val(); 
		var start_dt2 = $('#startTime2').val(); 
		var memo = $('#memo').val(); 
		
		if(!user_seqno || user_seqno == '') {
			alert('예약할 고객을 선택해 주세요.');
			return false;
		}
		if(!partner || partner == '') {
			alert('제휴사를 선택해 주세요.');
			return false;
		}
		if(!store || store == '') {
			alert('매장을 선택해 주세요.');
			return false;
		}
		if(!manager || manager == '') {
			alert('담당자를 선택해 주세요.');
			return false;
		}		
		if(!service_seqno || service_seqno == '') {
			alert('서비스를 선택해 주세요.');
			return false;
		}
		if (!start_dt1 || start_dt1 == '' || !start_dt2 || start_dt2 == '') {
			alert('서비스 시작시간을 입력해 주세요.');
			return false;
		}
		if (!estimated_time || estimated_time == '') {
			alert('예상 소요시간 선택해 주세요.');
			return false;
		}

		return true;
	}

	function gotoInfoDetail(seq){
		location.href = '/admin/members/'+seq;
	}		
	function popOpen(id){
		$('body, html').css('overflow', 'hidden');
		if(id && id != '') {
			// 
		}
		$('#popReservation').show();
	}
	function popHide(){
		$('body, html').css('overflow', 'none');
		$('#popReservation').hide();
	}
	
	$(document).ready(function(){
		var _bodyContents = '<option value="">선택해주세요.</option>';
		for(var idx = 10; idx < 16; idx++){
			_bodyContents = _bodyContents + '<option value="'+idx+'">'+(idx == 0 ? '' : idx+'시 ')+'</option>';
		}
		$('#startTime1').html(_bodyContents);
		_bodyContents = '<option value="">선택해주세요.</option>';
		for(var jdx = 0; jdx < 6; jdx++){
			_bodyContents = _bodyContents + '<option value="'+(jdx*10)+'">'+(jdx*10+'분')+'</option>';
		}
		$('#startTime2').html(_bodyContents);
		_bodyContents = '<option value="">선택해주세요.</option>';
		for(var idx = 0; idx < 3; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="'+idx+':'+(jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#estimated_time').html(_bodyContents);
	});
</script>