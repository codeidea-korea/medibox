@php 
$page_title = '서비스 정보';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">서비스 정보</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
				<option value="">검색가능 셀렉트</option>
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
				<option value="">검색가능 셀렉트</option>
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

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
<!--			<div class="caption">총 <b id="totalCnt">123</b>건이 있습니다</div> -->
			<div class="rightSet">
                <a href="#" onclick="addItem()" class="btn green small icon-add">등록</a>
                <!-- <a href="#" onclick="removeAll()" class="btn red small icon-del">삭제</a> -->
            </div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="90">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
				<col width="60">
			</colgroup>
			<thead>
				<tr>
					<th><a href="#">번호</a></th>
					<th><a href="#">제휴사</a></th>
					<th><a href="#">매장</a></th>
					<th><a href="#">서비스명</a></th>
					<th><a href="#">소요시간</a></th>
					<th><a href="#">가격</a></th>
					<th><a href="#">직위</a></th>
					<th><a href="#">수정</a></th>
				</tr>
			</thead>

			<tbody class="_tableBody">
				<tr>
					<td>1</td>
					<td>010-0000-0000</td>
					<td>홍길동</td>
					<td>홍길동</td>
					<td>홍길동</td>
					<td>홍길동</td>
					<td>홍길동</td>
					<td>홍길동</td>
				</tr>
			</tbody>			
		</table>	

		<nav class="pg_wrap">
			<a href="#" class="pg_btn first"></a>
			<a href="#" class="pg_btn prev"></a>
			<a href="#" class="pg_btn active">1</a>
			<a href="#" class="pg_btn">2</a>
			<a href="#" class="pg_btn">3</a>
			<a href="#" class="pg_btn">4</a>
			<a href="#" class="pg_btn">5</a>
			<a href="#" class="pg_btn">6</a>
			<a href="#" class="pg_btn">7</a>
			<a href="#" class="pg_btn">8</a>
			<a href="#" class="pg_btn">9</a>
			<a href="#" class="pg_btn">10</a>
			<a href="#" class="pg_btn next"></a>
			<a href="#" class="pg_btn last"></a>
		</nav>
	</div>	
	
	<script>	
	var pageNo = 1;
	var pageSize = 10;

	function wait(){
		alert('준비중입니다.');
	}
	function loadList(no) {
		pageNo = no;
		getList();
	}
	function enterkey() {
		if (window.event.keyCode == 13) {
			loadList(1);
		}
	}
	function viewInfo(row){
		var key;
		var target = $(row.target).parent();
		
		if(target.dataset && target.dataset.key) {
			key = target.dataset.key;
		} else {
			// NOTICE: IE 11+ 이하버전, 엣지 구버전, 크롬 84 아래버전의 안드로이드 웹뷰를 사용하는 인앱
			key = $(target).attr('data-key');
		}
		gotoDetail(key);
	}
	function getList(){
		var partnersPop = $('#partnersPop').val();
		var storePop = $('#storePop').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }} };

		if(partnersPop && partnersPop != '') {
			data.partner_seqno = partnersPop;
		}
		if(storePop && storePop != '') {
			data.store_seqno = storePop;
		}

		medibox.methods.store.manager.services.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
//			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(!response.data || response.data.length == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="8" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
									+'</tr>');
				$('.pg_wrap').html('<nav class="pg_wrap">'
									+'    <a href="#" class="pg_btn first"></a>'
									+'    <a href="#" class="pg_btn prev"></a>'
									+'    <a href="#" class="pg_btn active">1</a>'
									+'    <a href="#" class="pg_btn next"></a>'
									+'    <a href="#" class="pg_btn last"></a>'
									+'</nav>');
				return;
			}

			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
							+'<tr>'
							+'	<td>'+no+'</td>'
							+'	<td>'+response.data[inx].partnerInfo.cop_name+'</td>'
							+'	<td>'+response.data[inx].storeInfo.name+'</td>'
							+'	<td>['+response.data[inx].dept + '] ' +response.data[inx].name+'</td>'
							+'	<td>'+response.data[inx].estimated_time+'</td>'
							+'	<td>'+response.data[inx].price+'</td>'
							+'	<td>'+response.data[inx].manager_type+'</td>'
							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].seqno+'\')" class="btnEdit">수정하기</a></td>'
							+'</tr>';
			}
			$('._tableBody').html(bodyData);
//			$('._tableBody > tr > td').not('._tableBody > tr > td[data-action-type=none]').off().on('click', viewInfo);

			if(response.count > 0)
			{
				var totSize = response.count;
				var totPagePt = Math.ceil(totSize / pageSize);
				var pageStt = (Math.ceil(request.pageNo/pageSize)-1)*pageSize +1;
				var pageEnd = Math.ceil(request.pageNo/pageSize)*pageSize;
				pageEnd = pageEnd > totPagePt ? totPagePt : pageEnd;
				var eventName = 'onclick'; var pageTmp = '';
				
				pageTmp+= '<nav class="pg_wrap">'
						+'    <a href="#" class="pg_btn first" '+(pageStt > 5 ? eventName+'="loadList(1)"' : '')+'></a>'
						+'    <a href="#" class="pg_btn prev" '+(pageStt > 5 ? eventName+'="loadList('+(pageStt-1)+')"' : '')+'></a>';
				for(var inx=pageStt; inx <= pageEnd; inx++)
				{
					pageTmp+='<a href="#" class="pg_btn '+(inx == request.pageNo ? 'active' : '')+'" '+eventName+'="loadList('+(inx)+')">'+(inx)+'</a>';
				}
				pageTmp+='    <a href="#" class="pg_btn next" '+(totPagePt > pageEnd ? eventName+'="loadList('+(pageEnd+1)+')"' : '')+'></a>'
						+'    <a href="#" class="pg_btn last" '+(totPagePt > pageEnd ? eventName+'="loadList('+(totPagePt)+')"' : '')+'></a>'
						+'</nav>';

				$('.pg_wrap').html(pageTmp);
			}
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getPartners(){
		// TODO: 제휴사 로그인시에는 해당 값에 할당
		var partnerId = '';
		var data = { adminSeqno:{{ $seqno }} };

		if(partnerId && partnerId != '') {
			data.id = partnerId;
		}
// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
					+'<option value="'+response.data[inx].seqno+'" onclick="getStoresPop('+response.data[inx].seqno+')">'+response.data[inx].cop_name+'</option>';
			}
			$('#partnersPop').html(bodyData);
			getStoresPop(partnerId);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getStoresPop(partner_seqno){
		var data = { partner_seqno:partner_seqno, adminSeqno:{{ $seqno }} };
// {{session()->get('admin_type')}}
		@php
		if(session()->get('admin_type') == 'P') {
			echo 'data.partner_ids = "'.session()->get('level_partner_grp_seqno').'";';
		} else if(session()->get('admin_type') == 'S') {
			echo 'data.partner_ids = "'.session()->get('partner_seqno').'";';
			echo 'data.store_seqno = "'.session()->get('store_seqno').'";';
		}
		@endphp

		medibox.methods.store.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<option value="">선택해주세요.</option>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData + '<option value="'+response.data[inx].seqno+'" onclick="getManagersPop('+response.data[inx].seqno+')">'+response.data[inx].name+'</option>';
			}
			$('#storePop').html(bodyData);
			getList();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	function getManagersPop(seq){
		getList();
	}

	function gotoDetail(seq){
		location.href = '/admin/services/'+seq;
	}
	function addItem(){
		location.href = '/admin/services/0';
	}		
	function remove(name, seq){
		if(!confirm('\''+name+'\'\n서비스를 삭제 하시겠습니까?\n*기존 데이터는 모두 삭제됩니다.')) {
			return;
		}
		medibox.methods.store.manager.services.remove({}, seq, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('삭제 되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	
	$(document).ready(function(){
		getPartners();
		getList();
	});
	</script>

</section>

@include('admin.footer')
