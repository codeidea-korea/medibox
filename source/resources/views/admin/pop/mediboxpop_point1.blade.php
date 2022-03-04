
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
				<div class="wr-list">
					<div class="wr-list-label required">서비스</div>
					<div class="wr-list-con flex">					
						<select class="default _services">
							<option>에너지-30분</option>
							<option>에너지-30분</option>
							<option>에너지-30분</option>
						</select>
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
			for(var inx = 0; inx < response.data.length; inx++){
				tmpShops = tmpShops + '<option value="'+response.data[inx].service_name+'">'+response.data[inx].service_name+'</option>';
			}
			$('._shops').html(tmpShops);
			
			$('._shops').off().on('change', function(){
				getServices(point_type, $(this).val());
			});
			getServices(point_type, response.data[0].service_name);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var service_name;
	var product_seqno;
	function getServices(pointType, shopName){
		service_name = shopName;
		medibox.methods.point.services({ point_type: pointType, service_name: shopName }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpServices = '';
			for(var inx = 0; inx < response.data.length; inx++){
				tmpServices = tmpServices + '<option value="'+response.data[inx].product_seqno+'" price="'+response.data[inx].price+'">'+response.data[inx].type_name+(response.data[inx].service_sub_name ? '-'+response.data[inx].service_sub_name : '')+'</option>';
			}
			$('._services').html(tmpServices);
			
			$('._services').off().on('change', function(){
				product_seqno = $(this).val();
				$('._price').val(medibox.methods.toNumber($(this).find('option:selected').attr('price')) +' P');
			});
			product_seqno = response.data[0].product_seqno;
			$('._price').val(medibox.methods.toNumber(response.data[0].price) +' P');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function usePoint(){
		var point_type = $('#use_point_type').val();
		var memo = $('#use_memo').val();
		
		var data = { admin_seqno:{{ $seqno }}, user_seqno:{{ $id }}, product_seqno: product_seqno,
			point_type:point_type, memo:memo };

		medibox.methods.point.use(data, function(request, response){
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