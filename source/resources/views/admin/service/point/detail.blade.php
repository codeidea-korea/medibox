
@php 
$page_title = '포인트 사용내역';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">포인트 사용내역</div>
	<div class="wrtieContents">
		<div class="flexbox">
			<div class="view-wrap label160">
				<div class="view-list">
					<div class="view-list-label">아이디</div>
					<div class="view-list-con">{{ $history->userInfo->user_phone }}</div>
					<div class="view-list-label">이름</div>
					<div class="view-list-con">{{ $history->userInfo->user_name }}</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">포인트 종류</div>
					<div class="view-list-con _type">{{ $history->point_type }}</div>
					<div class="view-list-label">결제일</div>
					<div class="view-list-con">{{ $history->create_dt }}</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">사용유형</div>
					<div class="view-list-con">@php if($history->hst_type == 'U') echo '사용'; if($history->hst_type == 'S') echo '충전'; if($history->hst_type == 'R') echo '환불'; @endphp</div>
					<div class="view-list-label">&nbsp;</div>
					<div class="view-list-con">&nbsp;</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">포인트</div>
					<div class="view-list-con">{{ $history->point }}</div>
					<div class="view-list-label">제휴사</div>
					<div class="view-list-con">{{ $history->shop_name }}</div>
				</div>
				<div class="view-list">
					<div class="view-list-label">결제매장</div>
					<div class="view-list-con">{{ $history->shop_name }}</div>
					<div class="view-list-label">결제서비스</div>
					<div class="view-list-con">{{ $history->product_name }}</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/point/history';
	}
	function getPointType(type){
		switch(type){
			case 'S1':
				return '통합';
			case 'S2':
				return '네일';
			case 'S3':
				return '발몽';
			case 'S4':
				return '포레스타';
			case 'P':
				return '포인트';
			case 'K':
				return '패키지';
			default:
				return '-';
		}
	}
	$(document).ready(function(){
		var serviceName;
		var point_type = $('._type').text();
		if(point_type == 'P') {
			serviceName = '포인트';
		} else if(point_type == 'K') {
			serviceName = '패키지';
		} else {
			serviceName = '정액권-' + getPointType(point_type);
		}
		$('._type').text(serviceName);
	});
	
	</script>
</section>

@include('admin.footer')
