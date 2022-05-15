
<div class="layer-popup" id="popCouponDetail">
	<button class="pop-closer" onclick="popHide()"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header"> 이벤트 쿠폰 사용현황 </header>
			
			<div class="wrtieContents" style="flex-direction: column;">
				<div class="wr-wrap line label160">
					<div class="wr-list">
						<div class="wr-list-label">이벤트명</div>
						<div class="wr-list-con" id="event_name"></div>
						<div class="wr-list-label">이벤트 내용</div>
						<div class="wr-list-con" id="event_content"></div>
					</div>
					<div class="wr-list">
						<div class="wr-list-label">이벤트 기간</div>
						<div class="wr-list-con" id="event_time"></div>
						<div class="wr-list-label">&nbsp;</div>
						<div class="wr-list-con">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</div>
					<br>
					<div class="wr-list">
						<div class="wr-list-label">쿠폰 제휴사</div>
						<div class="wr-list-con" id="coupon_partners"></div>
						<div class="wr-list-label">쿠폰명</div>
						<div class="wr-list-con" id="coupon_name"></div>
					</div>
					<div class="wr-list">
						<div class="wr-list-label">쿠폰 내용</div>
						<div class="wr-list-con" id="coupon_content"></div>
						<div class="wr-list-label">쿠폰 기간</div>
						<div class="wr-list-con" id="coupon_time"></div>
					</div>
					<div class="wr-list">
						<div class="wr-list-label">쿠폰 할인유형</div>
						<div class="wr-list-con" id="coupon_type"></div>
						<div class="wr-list-label">할인 금액</div>
						<div class="wr-list-con" id="coupon_discount_price"></div>
					</div>
					<div class="wr-list">
						<div class="wr-list-label">최소기준금액</div>
						<div class="wr-list-con" id="coupon_limit_base_price"></div>
						<div class="wr-list-label">&nbsp;</div>
						<div class="wr-list-con">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					</div>
					<br>
					<div class="wr-list">
						<div class="wr-list-label">유저 아이디</div>
						<div class="wr-list-con" id="user_phone"></div>
						<div class="wr-list-label">유저 쿠폰 발급일</div>
						<div class="wr-list-con" id="user_issue_time"></div>
					</div>
					<div class="wr-list">
						<div class="wr-list-label">유저 쿠폰 사용상태</div>
						<div class="wr-list-con" id="user_used"></div>
						<div class="wr-list-label">유저 혜택금액</div>
						<div class="wr-list-con" id="user_real_discount_price"></div>
					</div>
				</div>
			</div>

			<div class="btnSet">
				<a href="#" class="btn large gray popClose" onclick="popHide()">닫기</a>
			</div>
		</div>
	</div>

	<div class="pop-bg"></div>
</div>

<script>	
	var couponInfos;
	function popHide(){
		$('body, html').css('overflow', 'none');
		$('#popCouponDetail').hide();
	}

	function loadCouponInfo(idx){
		if(couponInfos.length < idx || idx < 0) {
			alert('존재하지 않는 쿠폰 정보입니다.');
			return false;
		}
		$('#event_name').text(couponInfos[idx].name);
		$('#event_content').text(couponInfos[idx].content);
		$('#event_time').text(couponInfos[idx].start_dt + ' ~ ' + couponInfos[idx].end_dt);
		
		$('#coupon_partners').text(response.data[idx].partners.map(p => p.name));
		$('#coupon_name').text(couponInfos[idx].coupon_name);
		$('#coupon_content').text(couponInfos[idx].coupon_context);
		$('#coupon_time').text(couponInfos[idx].coupon_start_dt + ' ~ ' + couponInfos[idx].coupon_end_dt);
		$('#coupon_type').text(getType(couponInfos[idx].type));
		$('#coupon_discount_price').text(medibox.methods.toNumber(couponInfos[idx].discount_price));
		$('#coupon_limit_base_price').text(medibox.methods.toNumber(couponInfos[idx].limit_base_price));

		$('#user_phone').text(couponInfos[idx].user_id);
		$('#user_issue_time').text(couponInfos[idx].create_dt);
		$('#user_used').text(getTypeCouponTime(couponInfos[idx].used, couponInfos[idx].real_end_dt));
		$('#user_real_discount_price').text(medibox.methods.toNumber(couponInfos[idx].real_discount_price));

		popOpenCoupon();
	}
	
	function popOpenCoupon(){
		$('body, html').css('overflow', 'hidden');
		$('#popCouponDetail').show();
	}
</script>