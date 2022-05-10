@php 
$page_title = '패키지 관리';
@endphp
@include('admin.header')

<section class="container">
	<div class="page-title">패키지 관리</div>
	
	<form name="" action="" method="post">
	<div class="data-search-wrap">
		<div class="data-sel">
			<input type="text" name="searchField" id="searchField" value="" class="span250" onkeyup="enterkey()" placeholder="패키지명">
			<a href="#" onclick="loadList(1)" class="btn gray">검색</a>
		</div>		
	</div>
	</form>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption">총 <b id="totalCnt">123</b>개 글이 있습니다</div>
			<div class="rightSet">
                <a href="#" onclick="addItem()" class="btn green small icon-add">패키지 등록</a>
                <!-- <a href="#" onclick="removeAll()" class="btn red small icon-del">삭제</a> -->
            </div>
		</div>
		<table>
			<colgroup>
				<col width="50">
				<col width="90">
				<col width="60">
				<col width="60">
			</colgroup>
			<thead>
				<tr>
					<th><a href="#">번호</a></th>
					<th><a href="#">패키지 이름</a></th>
					<th><a href="#">적립 포인트</a></th>
					<th><a href="#">수정/삭제</a></th>
				</tr>
			</thead>

			<tbody class="_tableBody">
				<tr>
					<td>1</td>
					<td>010-0000-0000</td>
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
		return false;
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
	function getPointType(type){
		switch(type){
			case 'S1':
				return '통합';
			case 'S2':
				return '바라는 네일';
			case 'S3':
				return '발몽스파';
			case 'S4':
				return '포레스타 블랙';
			case 'S5':
				return '딥포커스 검안센터';
			case 'S6':
				return '미니쉬 스파';
			case 'S7':
				return '미니쉬 도수';
			case 'P':
				return '포인트';
			case 'K':
				return '패키지';
			default:
				return '-';
		}
	}
	function getDateType(code){
		if(code >= 365) {
			return Math.round(code / 365) + '년';
		} else if(code >= 30) {
			return Math.round(code / 30) + '개월';
		} else if(code >= 7) {
			return Math.round(code / 7) + '주';
		} else if(code == 0) {
			return '제한 없음';
		}
		return code + '일';
	}
	function getList(){
		var searchField = $('input[name=searchField]').val();
		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:{{ $seqno }}, offline_type:'N', point_type:'K', revers_type_condition: 'N' };

		if(searchField && searchField != '') {
			data.type_name = searchField;
		}

		medibox.methods.point.products.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('._tableBody').html('<tr>'
									+'    <td colspan="4" class="td_empty"><div class="empty_list" data-text="내용이 없습니다."></div></td>'
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
							+'	<td>'+response.data[inx].type_name+'</td>'
							+'	<td>'+medibox.methods.toNumber(response.data[inx].return_point)+'p</td>'
							+'	<td><a href="#" onclick="gotoDetail(\''+response.data[inx].product_seqno+'\')" class="btnEdit">수정/삭제</a></td>'
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
		location.href = '/admin/service/packages/'+seq;
	}
	function addItem(){
		location.href = '/admin/service/packages/0';
	}
	$(document).ready(function(){
		getList();
	});
	</script>

</section>

@include('admin.footer')
