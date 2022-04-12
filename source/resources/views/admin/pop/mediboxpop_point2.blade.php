
<div id="mediboxpop-point2" class="layerPopup zoom-anim-dialog mfp-hide">
	<div class="popContainer">
		
		<header class="pop-header">
			포인트 적립
		</header>

		<form name="fboardlist" action="" method="post">
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">포인트 적립 유저 정보</div>
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
					<div class="wr-list-label required">포인트 적립 종류 선택</div>
					<div class="wr-list-con flex">					
						<select id="collect_point_type" class="default _pointTypes">
							<option>포인트</option>
							<option>네일정액권</option>
							<option>발몽정액권</option>
							<option>포레스타정액권</option>
						</select>
						<select id="collect_point_detail_type" class="default _collectItem">
							<option>포인트 적립</option>
							<option>포인트 <포인트선택시 기재></option>
							<option>통합정액권 300</option>
							<option>통합정액권 500</option>
							<option>통합정액권 1000</option>
							<option>네일정액권 100</option>
							<option>네일정액권 200</option>
							<option>네일정액권 300</option>
							<option>발몽정액권 100</option>
							<option>발몽정액권 200</option>
							<option>발몽정액권 300</option>
							<option>포레스타정액권 100</option>
							<option>포레스타정액권 200</option>
							<option>포레스타정액권 300</option>
							<option>패키지 50</option>
							<option>패키지 100</option>
							<option>패키지 150</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">현재 보유 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="collect_pres_point" value="1,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label required">적립 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="collect_point" onkeyup="checkCollectPoint()" value="" class="span" placeholder="0 P">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">적립 후 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="collect_sum_point" value="2,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">담당자 아이디</div>
					<div class="wr-list-con flex">					
						<input type="text" id="collect_director_name" value="{{ $name }}" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<!--
				<div class="wr-list">
					<div class="wr-list-label ">포인트 차감자</div>
					<div class="wr-list-con flex">					
						<input type="text" id="calculator_name" name="calculator_name" value="" class="span">
					</div>
				</div>
-->
				<div class="wr-list">
					<div class="wr-list-label ">MEMO</div>
					<div class="wr-list-con flex">					
						<textarea name="" id="collect_memo" class="mini autoSize " style="min-height:150px;width:100%;" placeholder=""></textarea>
					</div>
				</div>
			</div>		

		</div>
		</form>

		<div class="btnSet">
			<a href="#" onclick="closePopCollect()" class="btn large gray popClose">닫기</a>
			<a href="#" onclick="collectPoint()" class="btn large green span120">적립</a>
		</div>

	</div>	
</div>



<script>
	function all_checked(sw) {
		var f = document.fboardlist;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk[]")
				f.elements[i].checked = sw;
		}
	}
function checkCollectPoint(){
	if($('#collect_point').val() == '') {
		return;
	}
	var pres = $('#collect_pres_point').val().trim().replace('P','').replaceAll(',', '');
	var refund = $('#collect_point').val().trim().replace('P','').replaceAll(',', '');
	if(isNaN(refund)) {
		alert('숫자만 입력해주세요.');
		$('#collect_point').val('');
		return;
	}
	$('#collect_sum_point').val(medibox.methods.toNumber(Number(pres) + Number(refund)) + ' P');
}
	function closePopCollect(){
		$.magnificPopup.close({
			items: {
				src: '#mediboxpop-point2'
			},
			type: 'inline'
		});
	}
	var pres_collect_before_point = 0;
	function getCollectTypes(){
		getTypes(function (){
			$('#collect_point_type').off().on('change', function(){
				getCollectItems($(this).val());
				var type = $(this).val();
				pres_collect_before_point = getPoint(type);
				$('#collect_pres_point').val(medibox.methods.toNumber(getPoint(type)) +' P'); 
			});
			getCollectItems('P');
			$('#collect_pres_point').val(medibox.methods.toNumber(pointDetails.point.point) +' P'); 
			$('#collect_point').val('');
			$('#collect_sum_point').val($('#collect_pres_point').val());
		});
	}
	function getCollectItems(pointType){
		medibox.methods.point.collects({ point_type: pointType }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpCollects = '';
			if(pointType == 'P') {
				tmpCollects = tmpCollects + '<option value="0" price="0" type="P" return="0">포인트 <포인트선택시 기재></option>';
			}
			for(var inx = 0; inx < response.data.length; inx++){
				tmpCollects = tmpCollects + '<option value="'+response.data[inx].product_seqno+'" type="'+response.data[inx].point_type+'" price="'+response.data[inx].price+'" return="'+response.data[inx].return_point+'">'+response.data[inx].type_name+'-'+response.data[inx].service_sub_name+'</option>';
			}
			$('._collectItem').html(tmpCollects);
			
			$('._collectItem').off().on('change', function(){
				product_seqno = $(this).val();
				$('#collect_point').val(medibox.methods.toNumber($(this).find('option:selected').attr('return')) +' P');
				var currentPoint = getPoint($(this).find('option:selected').attr('type'));
				var type = $(this).find('option:selected').attr('type');
				$('#collect_pres_point').val(medibox.methods.toNumber(currentPoint) +' P'); 
				// readonly
				if (type == 'P') {
					$('#collect_point').removeAttr('readonly');
					$('#collect_point').attr('style', ' ');
				} else {
					$('#collect_point').attr('readonly', 'readonly');
					$('#collect_point').attr('style', 'background:#d3d3d3;');
				}
				$('#collect_sum_point').val(medibox.methods.toNumber((currentPoint + Number($(this).find('option:selected').attr('return')))) +' P');
			});
			if(pointType == 'P') {
				product_seqno = 0;
				$('#collect_point').val('');
			} else {
				product_seqno = response.data[0].product_seqno;
				$('#collect_point').val(medibox.methods.toNumber(response.data[0].return_point) +' P');
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function collectPoint(){
		var point_type = $('#collect_point_detail_type').find('option:selected').attr('type');
		var memo = $('#collect_memo').val();
		var amount = $('#collect_point').val().trim().replace('P','').replaceAll(',',''); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
		var admin_name = ''; // $('#calculator_name').val();
		
		var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, product_seqno: product_seqno,
			point_type:point_type, memo:memo, amount:replacePoint(amount), admin_name: admin_name };

		medibox.methods.point.collect(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert(response.ment.replace('\\r', '\n'));
			location.reload();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	</script>