@php 
$page_title = '레벨 권한 설정';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">레벨 권한 설정</div>
	
	<div class="data-search-wrap">
		<div class="data-sel">
			<div class="wr-wrap line label160">
				<div class="wr-list">
					<div class="wr-list-label">제휴사명</div>
					<div class="wr-list-con">
						<select class="default" id="partnersPop" onchange="getStoresPop(this.value)">
							<option value="">선택해주세요</option>
						</select>
						<select class="default" id="storePop">
							<option value="">선택해주세요</option>
						</select>
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">아이디</div>
					<div class="wr-list-con">
						<input type="text" name="id" id="id" value="" class="span250" onkeyup="enterkey()" placeholder="제목">
					</div>
				</div>
				<div class="wr-list">
					<div class="wr-list-label">권한</div>
					<div class="wr-list-con">
						<select class="default" id="admin_type" onchange="getPartnersPop(this.value)">
							<option value="">전체 권한</option>
							<option value="A">슈퍼 관리자</option>
							<option value="B">본사 관리자</option>
							<option value="P">제휴사 관리자</option>
							<option value="S">매장 관리자</option>
						</select>
					</div>
				</div>
			</div>

			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="#" onclick="addItem()" class="btn green small icon-add">관리자 아이디 권한등록</a>
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
			</colgroup>
			<thead>
				<tr>
					<th><a href="#">번호</th>
					<th><a href="#">제휴사명</th>
					<th><a href="#">매장명</th>
					<th><a href="#">아이디</th>
					<th><a href="#">권한</th>
					<th><a href="#">수정</th>
				</tr>
			</thead>

			<tbody class="_tableBody">
				<tr>
					<td>1</td>
					<td>010-0000-0000</td>
					<td>홍길동</td>
				</tr>
				<tr>
					<td>2</td>
					<td>010-0000-0000</td>
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
	function getPartnersPop(val) {
		/*
		$('#partnersPop').hide();
		$('#storePop').hide();

		if(val == 'P') {
			$('#partnersPop').show();
		} else if(val == 'S') {
			$('#partnersPop').show();
			$('#storePop').show();
		} else {
			$('#partnersPop').val('');
			$('#storePop').val('');
		}
		*/
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
			$('#storePop').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
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
	function getPartnerName(code, name){
		if(code == 'A') {
			return '슈퍼 관리자';
		} else if(code == 'B') {
			return '본사 관리자';
		} else {
			return name;
		}
	}
	function getStoreName(code, name){
		if(code == 'A') {
			return '슈퍼 관리자';
		} else if(code == 'B') {
			return '본사 관리자';
		} else if(code == 'P') {
			return '-';
		} else {
			return name;
		}
	}
	function getList(){
		var partnersPop = $('#partnersPop').val();
		var storePop = $('#storePop').val();
		var id = $('#id').val();
		var admin_type = $('#admin_type').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }},  };

		if(partnersPop && partnersPop != '') {
			data.partner_seqno = partnersPop;
		}
		if(storePop && storePop != '') {
			data.store_seqno = storePop;
		}
		if(id && id != '') {
			data.id = id;
		}
		if(admin_type && admin_type != '') {
			data.admin_type = admin_type;
		}

		medibox.methods.admin.level.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="6" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
							+'	<td>'+getPartnerName(response.data[inx].admin_type, response.data[inx].partner_name)+'</td>'
							+'	<td>'+getStoreName(response.data[inx].admin_type, response.data[inx].store_name)+'</td>'
							+'	<td>'+response.data[inx].admin_id+'</td>'
							+'	<td>'+(response.data[inx].level_partner_grp_seqno == 0 
									? '전체'
									: response.data[inx].partners.map(p => p.name))+'</td>'
							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].admin_seqno+'\')" class="btnEdit">수정</a></td>'
							+'</tr>';
				
			}
			$('._tableBody').html(bodyData);

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
	function gotoDetail(seq){
		location.href = '/admin/level/'+seq;
	}
	function addItem(){
		location.href = '/admin/level/0';
	}		
	
	$(document).ready(function(){
		getList();
		getPartners();
	});
	</script>

</section>

@include('admin.footer')
