
@include('user.header')
    
        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                    <g id="back_arrow" transform="translate(-22.295 -60)">
                      <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)" fill="none"/>
                      <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                        <g id="그룹_388" data-name="그룹 388">
                          <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none" stroke="#1d1d1b" stroke-miterlimit="10" stroke-width="1"/>
                          <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331" transform="translate(-3352 -1077.894)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                          <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331" transform="translate(-3352 -1071.563)" fill="none" stroke="#000" stroke-linecap="square" stroke-width="1"/>
                        </g>
                      </g>
                    </g>
                  </svg>
            </button>
            <!-- page title -->
            <div class="title">
                <span>바우처 사용</span>
            </div>
        </header>

        <!---------------->
        <section id="point_payment">
            <!-- 바우처 사용 페이지  -->
            <!-- 미사용 바우처 사용 완료 버튼 클릭 시 바우처 해당 쿠폰 사용으로 변경 -->
            <div class="voucher_area coupon_tab">
                <div>
                    <a href="#">
                        <div class="left">
                            <p class="type gold">골드 멤버쉽</p>
                            <p class="coupon_service">[ 와인 1병 제공 ]</p>
                            
                            <strong>80,000원 <span>상당</span></strong>
                            <div class="deadline">
                                <ul class="hr_line">
                                    <li><span>발행일</span> : 22-01-15 </li>
                                    <li><span>종료일</span> : 22-07-14 </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right black">
                            <p>미사용</p>
                            <p>잔여횟수 1</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <a href="#" class="confirm_btn" onclick="useVoucher()">사용완료</a>
    

    
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022071318"></script>
    <script>

var isUsed = false;
	function useVoucher(){
        if(isUsed) {
            alert('이미 사용된 바우처입니다.');
            return false;
        }
        if(! confirm('바우처를 사용 하시겠습니까?')) {
            return false;
        }
		var memo = '사용자 사용 신청';
		
		var data = { admin_seqno:0, user_seqno:{{ $userSeqno }}, voucher_seqno: {{$id}}, memo:memo };

		medibox.methods.point.vouchers.use(data, {{$id}}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
            $('.confirm_btn').attr('style', 'background: gray;');
            alert('사용되었습니다.');
            history.back();
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    
	function getInfo(){		
		var data = { pageNo: 1, pageSize: 10, adminSeqno:0, user_seqno: {{$userSeqno}}, voucher_seqno: {{$id}} };

		medibox.methods.point.vouchers.mine(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}

			if(response.count == 0){
				$('#point_payment').html('<figure class="empty_reservation">'
                    +'<img src="/user/img/icon_empty_reservation.png" alt="바우처가 없습니다.">'
                    +'<p>바우처가 없습니다.</p>'
                    +'</figure>');
                alert("존재하지 않는 바우처입니다.");
                history.back();
				return;
			}

			var bodyData = '';
			couponInfos = response.data;
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*10) - inx;				
				bodyData = bodyData 
                        + (response.data[inx].used == 'N'
                        ? 
                            ('<div>'
                            +'    <a href="/profile/voucher/'+response.data[inx].seqno+'">'
                            +'        <div class="left">'
                            +'            <p class="type gold">'+(response.data[inx].membership_name ? response.data[inx].membership_name+' 멤버쉽' : '')+'</p>'
                            +'            <p class="coupon_service">[ '+response.data[inx].voucher_name+' ]</p>'
//                            +'            <strong>80,000원 <span>상당</span></strong>' // 입력란이 없음
                            +'            <div class="deadline">'
                            +'                <ul class="hr_line">'
                            +'                    <li><span>발행일</span> : '+response.data[inx].create_dt+' </li>'
                            +'                    <li><span>종료일</span> : '+response.data[inx].create_dt+' </li>'
                            +'                </ul>'
                            +'            </div>'
                            +'        </div>'
                            +'        <div class="right black">'
                            +'            <p>미사용</p>'
                            +'            <p>잔여횟수 '+(response.data[inx].remaindCount)+'</p>'
                            +'        </div>'
                            +'    </a>'
                            +'</div>')
                        : 
                            ('<div>'
                            +'    <a href="#">'
                            +'        <div class="left">'
                            +'            <p class="type gold">골드 멤버쉽</p>'
                            +'            <p class="coupon_service">[ '+response.data[inx].name+' ]</p>'
//                            +'            <strong>80,000원 <span>상당</span></strong>' // 입력란이 없음
                            +'            <div class="deadline">'
                            +'                <ul class="hr_line">'
                            +'                    <li><span>발행일</span> : '+response.data[inx].create_dt+' </li>'
                            +'                    <li><span>종료일</span> : '+response.data[inx].create_dt+' </li>'
                            +'                </ul>'
                            +'            </div>'
                            +'        </div>'
                            +'        <div class="right gray">'
                            +'            <p>사용</p>'
                            +'        </div>'
                            +'    </a>'
                            +'</div>')
                        );
            }
            $('#point_payment').html('<div class="voucher_area coupon_tab">'+bodyData+'</div>');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
	$(document).ready(function(){
        getInfo();
	});
    </script>
@include('user.footer')

</body>
</html>