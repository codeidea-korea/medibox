
@php 
$page_title = '쿠폰 이용 현황 상세';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">쿠폰 이용 현황 상세</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">아이디</div>
				<div class="wr-list-con">
					{{ $history->user_phone }}
				</div>
				<div class="wr-list-label">이름</div>
				<div class="wr-list-con">
					{{ $history->user_name }}
				</div>
			</div>
			
			<div class="wr-list">
				<div class="wr-list-label">쿠폰제휴사</div>
				<div class="wr-list-con">
					@php
					if(!empty($history->partners) && count($history->partners) > 0) {
						for($inx = 0; $inx < count($history->partners); $inx++){
							echo $history->partners[$inx]->cop_name . ($inx == count($history->partners) - 1 ? '' : ', ');
						}
					} else {
						echo '전체';
					}
					@endphp
				</div>
				<div class="wr-list-label">사용형태</div>
				<div class="wr-list-con">
					@php
					if($history->used == 'N') {
						if(strtotime($history->real_end_dt) < strtotime("now")) {
							echo '기간만료';
						} else {
							echo '사용전';
						}
					} else {
						echo '사용완료';
					}
					@endphp
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰명</div>
				<div class="wr-list-con">
					{{ $history->name }}
				</div>
				<div class="wr-list-label">쿠폰발급일</div>
				<div class="wr-list-con">
					{{ $history->create_dt }}
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰사용일</div>
				<div class="wr-list-con">
					{{ $history->update_dt }}
				</div>
				<div class="wr-list-label">쿠폰사용기간</div>
				<div class="wr-list-con">
					{{ $history->start_dt }} ~ {{ $history->end_dt }}
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">쿠폰할인 금액</div>
				<div class="wr-list-con">
					{{ $history->discount_price }}
				</div>
				<div class="wr-list-label">쿠폰 할인 유형</div>
				<div class="wr-list-con">
					@php
					if($history->type == 'F') {
						echo '정액할인';
					} else if($history->type == 'P') {
						echo '정률할인';
					} else if($history->type == 'G') {
						echo '상품 지급';
					} else {
						echo '-';
					}
					@endphp
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">지급 유형</div>
				<div class="wr-list-con">
					@php
					if($history->issuance_type == 'A') {
						echo '자동지급';
					} else {
						echo '-';
					}
					@endphp
				</div>
				<div class="wr-list-label">지급 조건</div>
				<div class="wr-list-con">
					@php
					if($history->issuance_condition_type == 'A') {
						echo '전체발급';
					} else if($history->issuance_condition_type == 'J') {
						echo '회원가입시';
					} else if($history->issuance_condition_type == 'M') {
						echo '멤버쉽';
					} else {
						echo '-';
					}
					@endphp
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">할인 금액</div>
				<div class="wr-list-con">
					{{ $history->discount_price }}
				</div>
				<div class="wr-list-label">최소 기준 금액</div>
				<div class="wr-list-con">
					{{ $history->limit_base_price }}
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">혜택 금액</div>
				<div class="wr-list-con">
					{{ $history->real_discount_price }}
				</div>
				<div class="wr-list-label">&nbsp;</div>
				<div class="wr-list-con">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
	</div>

	<script>
	function cancel(){
		window.location.href = '/admin/service/coupon-history';
	}
	</script>
</section>

@include('admin.footer')
