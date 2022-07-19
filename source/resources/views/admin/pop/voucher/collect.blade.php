
<div id="mediboxpop-voucher-collect" class="layerPopup zoom-anim-dialog mfp-hide">
	<div class="popContainer">
		
		<header class="pop-header">
			바우처 충전
		</header>

		<form name="fboardlist" action="" method="post">
		<div class="tbl-basic cell td-h1">
			<div class="tbl-header">
				<div class="caption">바우처 충전 유저 정보</div>
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
				<div class="caption">바우처 사용</div>
			</div>
		</div>

		<form name="fboardlist" action="" method="post">
		<div class="wrtieContents">
			<div class="wr-wrap line label130">
				<div class="wr-list">
					<div class="wr-list-label required">바우처 충전 종류 선택</div>
					<div class="wr-list-con flex">					
						<select class="default _voucherType">

						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">현재 보유 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="voucher_collect_pres_point" value="1,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label required">사용 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="voucher_collect_point" value="0" class="span" placeholder="0 P" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">사용 후 포인트</div>
					<div class="wr-list-con flex">					
						<input type="text" id="voucher_collect_sum_point" value="2,000,000 P" class="span" style="background:#d3d3d3;" readonly>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label ">MEMO</div>
					<div class="wr-list-con flex">					
						<textarea name="" id="voucher_collect_memo" class="mini autoSize " style="min-height:150px;width:100%;" placeholder=""></textarea>
					</div>
				</div>
			</div>		

		</div>
		</form>

		<div class="btnSet">
			<a href="#" onclick="closePopVoucherCollect()" class="btn large gray popClose">닫기</a>
			<a href="#" onclick="collectVoucher()" class="btn large green span120">적립</a>
		</div>

	</div>	
</div>



<script>
	function closePopVoucherCollect(){
		$.magnificPopup.close({
			items: {
				src: '#mediboxpop-voucher-collect'
			},
			type: 'inline'
		});
	}
	var voucher_seqno = 0;
	var voucherInfos;
	var pres_voucher_collect_before_point = 0;
	function getVoucherCollect(){
		medibox.methods.point.vouchers.list({ pageNo: 1, pageSize: 100 }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			// 바우처 데이터 넣어주기
			var tmpCollects = '';
			voucherInfos = response.data;

			tmpCollects = tmpCollects + '<option value="0" price="0" return="0">바우처를 선택해주세요.</option>';
			for(var inx = 0; inx < response.data.length; inx++){
				tmpCollects = tmpCollects + '<option value="'+response.data[inx].seqno+'" price="'+response.data[inx].price+'">'+response.data[inx].name+'</option>';
			}
			$('._voucherType').html(tmpCollects);
			
			$('._voucherType').off().on('change', function(){
				voucher_seqno = $(this).val();
				$('#voucher_collect_point').val(medibox.methods.toNumber($(this).find('option:selected').attr('price')) +' P');
				var currentPoint = getPoint($(this).find('option:selected').attr('type'));
				var type = $(this).find('option:selected').attr('type');
				$('#voucher_collect_pres_point').val(medibox.methods.toNumber(currentPoint) +' P'); 
				$('#voucher_collect_pres_point').val(medibox.methods.toNumber(currentPoint) +' P'); 
				$('#voucher_collect_sum_point').val(medibox.methods.toNumber((currentPoint - Number($(this).find('option:selected').attr('price')))) +' P');
			});
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function collectVoucher(){
		var memo = $('#voucher_collect_memo').val();

		if(!confirm('[('+userInfo.user_phone+') '+userInfo.user_name+' ] 회원님에게 ['+voucherInfos.filter(voucher => voucher.seqno == voucher_seqno)[0].name+'] 바우처를 추가하시겠습니까?')) {
			return;
		}
		
		var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, voucher_seqno: voucher_seqno, memo:memo };

		medibox.methods.point.vouchers.collect(data, function(request, response){
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