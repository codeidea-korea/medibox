
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
                <span>바우처</span>
            </div>
        </header>

        <!-- 22.03.30 추가 -->
        <nav id="history_lnb">
            <ul class="depth01">
                <li>
                    <a href="#!">전체 기간</a>
                    <ul class="depth02">
                        <!-- 22.03.31 추가 -->
                        <li><a href="#!" onclick="searchMonth(0)">전체</a></li>
                        <!------------------>
                        <li><a href="#!" onclick="searchMonth(1)">1개월</a></li>
                        <li><a href="#!" onclick="searchMonth(3)">3개월</a></li>
                        <li><a href="#!" onclick="searchMonth(6)">6개월</a></li>
                        <li><a href="#!" onclick="searchMonth(12)">1년</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#!">전체 내역</a>

                    <!-- 22.03.31 수정 -->
                    <ul class="depth02">
                        <!-- <li><a href="#!">포인트</a></li>
                        <li><a href="#!">정액권</a></li> -->

                    <!-- 1차에선 삭제 (2차에서 추가 - 기획중) -->
                    <!-- <ul class="depth02">
                        <li><a href="#!">포인트</a></li>
                        <li><a href="#!">정액권</a></li>
                    </ul> -->
                    </ul>
                </li>
            </ul>
        </nav>
        <!---------------->

        <!-- 포인트 & 정액권 페이지 -->
        <section id="point_payment">

            <!-- 22.03.30 추가 -->
            <!-- 바우처가 없을 때 -->
            <figure class="empty_reservation">
                <img src="/user/img/icon_empty_reservation.png" alt="바우처가 없습니다.">
                <p>바우처가 없습니다.</p>
            </figure>

            <!-- 바우처가 있을 때 -->
            <!-- 
            <div class="voucher_area coupon_tab">
                <div>
                    <a href="">
                        <div class="left">
                            <p class="type platinum">플래티넘 멤버쉽</p>
                            <p class="store_title">바라는 네일</p>
                            <p class="coupon_service">[ 젤컬러 네일or 패디 ]</p>
                            
                            <strong>5000,000원 <span>상당</span></strong>
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
                 미사용 + 매장명없을때(일반 쿠폰) 바우처 사용 페이지 이동
                <div>
                    <a href="./voucher_confirm.html">
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
                 사용
                <div>
                    <a href="">
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
                        <div class="right gray">
                            <p>사용</p>
                        </div>
                    </a>
                </div>
            </div> -->
        </section>
    
@include('user.footer')

<script>
    var startDay = "";
    var endDay = "{{ date('Y-m-d', strtotime('+1 day')) }}";
    var pageNo = 1;
    var pageSize = 70;
    var partner_seqno;

    function searchType(type, name){
        partner_seqno = type;
        $('#searchTypeTit').html(name);
        getList();
    }
    function searchMonth(month){
        var searchMonthTit = month + '개월';
        var dd = new Date();
        dd.setMonth(dd.getMonth() - month);
        startDay = dd.getFullYear() + '-' + (dd.getMonth() < 9 ? '0' : '') + (dd.getMonth()+1) + '-' + (dd.getDate() < 10 ? '0' : '') + dd.getDate();
        if(month == 0) {
            searchMonthTit = '전체 기간';
            startDay = '';
        } else if(month == 12) {
            searchMonthTit = '1년';
        }
        // 전체 기간
        $('#searchMonthTit').html(searchMonthTit);
        getList();
    }
	function getPartners(){
		var data = { adminSeqno:0 };
		medibox.methods.partner.findAll(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '<li><a href="#!" onclick="searchType(\'\', \'전체\')">전체</a></li>';
			for(var inx=0; inx<response.data.length; inx++){
				bodyData = bodyData 
                    +'<li><a href="#!" onclick="searchType('+response.data[inx].seqno+', \''+response.data[inx].cop_name+'\')">'+response.data[inx].cop_name+'</a></li>';
			}
			$('#partners').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    function isAfter(targetDate){
        return new Date(targetDate).getTime() > new Date().getTime();
    }
    function getList(){		
		var data = { pageNo: pageNo, pageSize: pageSize, adminSeqno:0, user_seqno: {{$userSeqno}} };

		if(partner_seqno && partner_seqno != '') {
			data.partner_seqno = partner_seqno;
		}
		if(startDay && startDay != '') {
			data.start_dt = startDay;
		}
		if(endDay && endDay != '') {
			data.end_dt = endDay;
		}

		medibox.methods.point.vouchers.mine(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
//			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			if(response.count == 0){
				$('#point_payment').html('<figure class="empty_reservation">'
                    +'<img src="/user/img/icon_empty_reservation.png" alt="바우처가 없습니다.">'
                    +'<p>바우처가 없습니다.</p>'
                    +'</figure>');
				return;
			}

			var bodyData = '';
			couponInfos = response.data;
			for(var inx=0; inx<response.data.length; inx++){
                var no = (response.count - (request.pageNo - 1)*pageSize) - inx;				
				bodyData = bodyData 
                        + (response.data[inx].used == 'N'
                        ? 
                            ('<div>'
                            +'    <a href="/profile/voucher/'+response.data[inx].seqno+'">'
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
                            +'        <div class="right black">'
                            +'            <p>미사용</p>'
                            +'            <p>잔여횟수 '+(response.data[inx].voucherInfo.unit_count - response.data[inx].membershipHst.unit_count)+'</p>'
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
            if(pageNo == 1) {
                $('#point_payment').html('<div class="coupon_tab">'+bodyData+'</div>');
            } else {
                $('#point_payment > .coupon_tab').html($('#point_payment > .coupon_tab').html()+bodyData);
            }
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	$(document).ready(function(){
		getPartners();
		getList();
	});
</script>

</body>
</html>