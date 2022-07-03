
@php 
$page_title = $id == 0 ? '디자이너 등록' : '디자이너 수정';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">디자이너 정보 @php echo $id == 0 ? '등록' : '수정'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">매장 이름</div>
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
				<div class="wr-list-label">직위</div>
				<div class="wr-list-con">
					<select class="default" id="manager_type">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
					</select>
				</div> 
			</div>
			<div class="wr-list">
				<div class="wr-list-label">디자이너 이름</div>
				<div class="wr-list-con">
					<input type="text" id="name" name="" value="" class="span200" placeholder="디자이너 명을 기입해주세요. *이름이 없는 경우 직위만 노출됩니다.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">디자이너 소개글</div>
				<div class="wr-list-con">
					<textarea id="memo"></textarea>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">시작시각</div>
				<div class="wr-list-con">
					<select class="default" id="start_dt">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
					</select>
				</div>
				<div class="wr-list-label">종료시각</div>
				<div class="wr-list-con">
					<select class="default" id="end_dt">
						<option>검색가능 셀렉트</option>
						<option>옵션A</option>
					</select>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">입사일</div>
				<div class="wr-list-con">
					<input type="text" id="join_dt" name="" value="" class="span130 datepicker">
				</div>
				<div class="wr-list-label">퇴사일</div>
				<div class="wr-list-con">
					<input type="text" id="unjoin_dt" name="" value="9999-12-30" class="span130 datepicker">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">노출 여부</div>
				<div class="wr-list-con">
					<label class="toggle-light">
						<input type="checkbox" id="visible" name="" value="1" class="" checked=""><span></span>
						<span class="labelOn">ON</span>
						<span class="labelOff">OFF</span>
					</label>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">탈퇴 신청</div>
				<div class="wr-list-con">
					<a href="#" onclick="remove()" class="btn black ml5">회원 탈퇴</a>
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
		window.location.href = '/admin/managers';
	}
	function checkValidation(){
		
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager_type = $('#manager_type').val(); 
		var name = $('#name').val(); 
		var memo = $('#memo').val(); 
		var start_dt = $('#start_dt').val(); 
		var end_dt = $('#end_dt').val(); 
		var join_dt = $('#join_dt').val(); 
		var unjoin_dt = $('#unjoin_dt').val(); 
		var visible = $('#visible').is(":checked");
        
		if(!partner || partner == '') {
			alert('제휴사를 선택해 주세요.');
			return false;
		}
		if(!store || store == '') {
			alert('매장을 선택해 주세요.');
			return false;
		}
		if(!manager_type || manager_type == '') {
			alert('직위를 선택해 주세요.');
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
		var manager_type = $('#manager_type').val(); 
		var name = $('#name').val(); 
		var memo = $('#memo').val(); 
		var start_dt = $('#start_dt').val(); 
		var end_dt = $('#end_dt').val(); 
		var join_dt = $('#join_dt').val(); 
		var unjoin_dt = $('#unjoin_dt').val(); 
		var visible = $('#visible').is(":checked") ? 'Y' : 'N';
		var use_img = 'N';
		var holiday_type = 'C';
		

		medibox.methods.store.manager.add({
			partner_seqno: partner
			, store_seqno: store
			, manager_type: manager_type
			, name: name
			, memo: memo
			, start_dt: start_dt
			, end_dt: end_dt
			, join_dt: join_dt
			, unjoin_dt: unjoin_dt
			, visible: visible
			, use_img: use_img
			, holiday_type: holiday_type
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
		var partner = $('#partnersPop').val(); 
		var store = $('#storePop').val();
		var manager_type = $('#manager_type').val(); 
		var name = $('#name').val(); 
		var memo = $('#memo').val(); 
		var start_dt = $('#start_dt').val(); 
		var end_dt = $('#end_dt').val(); 
		var join_dt = $('#join_dt').val(); 
		var unjoin_dt = $('#unjoin_dt').val(); 
		var visible = $('#visible').is(":checked") ? 'Y' : 'N';
		var use_img = 'N';
		var holiday_type = 'C';

		medibox.methods.store.manager.modify({
			partner_seqno: partner
			, store_seqno: store
			, manager_type: manager_type
			, name: name
			, memo: memo
			, start_dt: start_dt
			, end_dt: end_dt
			, join_dt: join_dt
			, unjoin_dt: unjoin_dt
			, visible: visible
			, use_img: use_img
			, holiday_type: holiday_type
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

		medibox.methods.store.manager.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			$('#name').val( response.data.name );
			$('#memo').val( response.data.memo );
			$('#start_dt').val( response.data.start_dt );
			$('#end_dt').val( response.data.end_dt );
			$('#join_dt').val( response.data.join_dt );
			$('#unjoin_dt').val( response.data.unjoin_dt );
			$('#visible').prop('checked', response.data.visible == 'Y');
			
			$('#partnersPop').val( response.data.partner_seqno );
			$('#storePop').val( response.data.store_seqno );

			data = response.data;

			if(response.data.manager_type && response.data.manager_type != '') {
				var types = response.data.manager_type.split(',');
				for(var inx=0; inx<types.length; inx++){
					$('#manager_type').html(
						$('#manager_type').html() + '<option value="'+types[inx]+'">'+types[inx]+'</option>'
					);
				}
			}
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
		medibox.methods.store.manager.remove({}, '{{ $id }}', function(request, response){
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
		// start_dt end_dt
		var times = '<option value="">선택해주세요.</option>';

		var minTime = temp.start_dt;
		var maxTime = temp.end_dt;

		var targetTime = minTime;
		var prevHour = 0;
		var minArr = [];
		while(targetTime <= maxTime){
			var timeinfos = targetTime.split(':');
			var isDueTime = true;
			timeinfos[0] = Number(timeinfos[0]);
			timeinfos[1] = Number(timeinfos[1]);
            
            // 점심 시간을 사용하는 매장의 경우
            if(temp.allow_lunch_reservate == 'Y') {
                if(temp.lunch_start_dt && temp.lunch_start_dt <= targetTime
                    && temp.lunch_end_dt && temp.lunch_end_dt > targetTime) {
                        isDueTime = false;
                }
            }

			// 점심시간을 제외하고 넣기
			if(isDueTime) {
				if(prevHour != timeinfos[0]) {
					prevHour = timeinfos[0];
				}
				times = times + '<option value="'+(timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0])+':'+(timeinfos[1] < 10 ? '00' : timeinfos[1])+'">'
					+(timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0])+'시 '+(timeinfos[1] < 10 ? '0' : timeinfos[1])+'분</option>';
			}

			timeinfos[1] = Number(timeinfos[1]) + 10;
			if(timeinfos[1] >= 60) {
				timeinfos[0] = Number(timeinfos[0]) + 1;
				timeinfos[1] = '00';
			}
			targetTime = (timeinfos[0] < 10 ? '0'+timeinfos[0] : timeinfos[0]) + ':' + (timeinfos[1] < 10 ? '00' : timeinfos[1]);
		}
		$('#start_dt').html(times);
		$('#end_dt').html(times);
	}

	$(document).ready(function(){
		var _bodyContents = '<option>선택해주세요.</option>';
		for(var idx = 0; idx < 2; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="0'+idx+':'+(jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#start_dt').html(_bodyContents);
		var _bodyContents = '<option>선택해주세요.</option>';
		for(var idx = 10; idx < 16; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="'+idx+':'+(jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#start_dt').html(_bodyContents);
		$('#end_dt').html(_bodyContents);
		var _bodyContents = '<option>선택해주세요.</option>';
		for(var idx = 10; idx < 16; idx++){
			for(var jdx = 0; jdx < 6; jdx++){
				if(idx == 0 && jdx == 0) continue;
				_bodyContents = _bodyContents + '<option value="'+idx+':'+(jdx*10)+'">'+(idx == 0 ? '' : idx+'시간 ')+(jdx == 0 ? '' : jdx*10+'분')+'</option>';
			}
		}
		$('#end_dt').html(_bodyContents);
	});
	</script>
</section>

@include('admin.footer')
