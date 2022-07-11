
<div id="mediboxpop-point3" class="layerPopup zoom-anim-dialog mfp-hide">
	<div class="popContainer">
		
		<header class="pop-header">
			포인트 환불
		</header>

		<form name="fboardlist" action="" method="post">
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">포인트 환불 유저 정보</div>
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
				</thead>		
			</table>
		</div>
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">보유 멤버쉽</div>
			</div>
			<table id="resident_list">
				<colgroup>
					<col width="80">
					<col width="180">
				</colgroup>
				<thead>
					<tr>
						<th>멤버쉽</th>
						<td class="tright _userMembership">100,000 P</td>
					</tr>
				</thead>		
			</table>
		</div>
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">보유 패키지</div>
			</div>
			<table id="resident_list">
				<colgroup>
					<col width="80">
					<col width="180">
				</colgroup>
				<thead>
					<tr>
						<th>패키지</th>
						<td class="tright _userPackage">100,000 P</td>
					</tr>
				</thead>		
			</table>
		</div>
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">보유 정액권</div>
			</div>
			<table id="resident_list">
				<colgroup>
					<col width="80">
					<col width="180">
				</colgroup>
				<thead>
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
				<div class="caption">포인트 환불</div>
			</div>
		</div>

		<form name="fboardlist" action="" method="post">
		<div class="wrtieContents">
			<div class="wr-wrap line label130">
				<div class="wr-list">
					<div class="wr-list-label required">포인트 환불 확인</div>
					<div class="wr-list-con flex">					
						<select id="refund_point_type" class="default _pointTypes">
							<option>포인트</option>
							<option>네일정액권</option>
							<option>발몽정액권</option>
							<option>포레스타정액권</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">현재 보유 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="refund_pres_point" name="" value="1,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label required">환불 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="refund_point" name="" onkeyup="checkRefundPoint()" value="" class="span" placeholder="0 P">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">환불 후 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="refund_sum_point" name="" value="500,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">담당자 아이디</div>
					<div class="wr-list-con flex">					
						<input type="text" name="" value="{{ $name }}" class="span" style="background:#d3d3d3;" readonly>
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
						<textarea name="" id="refund_memo" class="mini autoSize " style="min-height:150px;width:100%;" placeholder=""></textarea>
					</div>
				</div>
			</div>		

		</div>
		</form>

		<div class="btnSet">
			<a href="#" onclick="closePopRefund()" class="btn large gray popClose">닫기</a>
			<a href="#" onclick="refundPoint()" class="btn large red span120">환불</a>
		</div>

	</div>	
</div>



<script>
function checkRefundPoint(){
	if($('#refund_point').val() == '') {
		return;
	}
	var pres = $('#refund_pres_point').val().trim().replace('P','').replaceAll(',', '');
	var refund = $('#refund_point').val().trim().replace('P','').replaceAll(',', '');
	if(isNaN(refund)) {
		alert('숫자만 입력해주세요.');
		$('#refund_point').val('');
		return;
	}
	$('#refund_sum_point').val(medibox.methods.toNumber(Number(pres) - Number(refund)) + ' P');
}
	function all_checked(sw) {
		var f = document.fboardlist;

		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "chk[]")
				f.elements[i].checked = sw;
		}
	}
	function closePopRefund(){
		$.magnificPopup.close({
			items: {
				src: '#mediboxpop-point3'
			},
			type: 'inline'
		});
	}
	function getRefundTypes(){
		getTypes(function (){
			$('#refund_point_type').off().on('change', function(){
				var type = $(this).val();
				var point = 0;
				switch(type) {
					case 'P':
						point = pointDetails.point.point;
						break;
					case 'K':
						point = pointDetails.point.point;
						break;
					case 'S1':
						point = pointDetails.point.point;
						break;
					case 'S2':
						point = pointDetails.nail.point;
						break;
					case 'S3':
						point = pointDetails.balmong.point;
						break;
					case 'S4':
						point = pointDetails.foresta.point;
						break;
					default:
						point = pointDetails.point.point;
						break;
				}
				pres_collect_before_point = point;
				$('#refund_pres_point').val(medibox.methods.toNumber(point) +' P'); 
			});
			$('#refund_pres_point').val(medibox.methods.toNumber(pointDetails.point.point) +' P'); 
			$('#refund_point').val('');
			$('#refund_sum_point').val($('#refund_pres_point').val());
		});
	}
	function refundPoint(){
		var point_type = $('#refund_point_type').val();
		var memo = $('#refund_memo').val();
		var amount = $('#refund_point').val().trim().replace('P','').replaceAll(',',''); // 입력된 포인트 양 (포인트일때만 적용, 나머지는 무시)
		var admin_name = ''; // $('#calculator_name').val();

		if(!confirm('[('+userInfo.user_phone+') '+userInfo.user_name+' ] 회원님의 ['+$('#refund_point').val()+'] point를 환불하시겠습니까?')) {
			return;
		}
		
		var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, product_seqno: 0,
			point_type:point_type, memo:memo, amount:replacePoint(amount), admin_name: admin_name };

		medibox.methods.point.refund(data, function(request, response){
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
	</script>