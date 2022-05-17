
@include('user.header')
    
        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="location.href='/point';">
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
                <span>포인트 결제</span>
            </div>
        </header>

        <!-- 포인트 결제 페이지 -->
        <section id="payment_page">

            <div class="service_select_wrap">
                <!-- 포인트 사용 매장 -->
                <div class="point_use_store">
                    <h2>포인트 사용 매장</h2>
                    <div class="select_wrap">
                        <div class="select_box">
                            <span class="_choosedShop">매장 선택</span>
                            <img src="/user/img/arrow_bottom.svg" alt="">
                        </div>
                        <ul class="option _shops">
                        <!-- 2022-04-04 default 값 문제  -->
                        <!--
                            <li>발몽스파</li>
                            <li>바라는 네일</li>
                            <li>딥포커스</li>
                            <li>미니쉬 스파</li>
                            <li>미니쉬 도수</li>
                            <li>포레스타 블랙</li>
                            -->
                        </ul>
                    </div>
                </div>
            
                <!-- 매장별 서비스  -->
                <div class="store_service">
                    <h2>매장별 서비스</h2>
                    <div class="select_wrap">
                        <div class="select_box">
                            <span class="_choosedService">서비스 선택</span>
                            <img src="/user/img/arrow_bottom.svg" alt="">
                        </div>
                        <ul class="option _services">
                        <!-- 2022-04-04 default 값 문제  -->
                        <!--
                            <li>베이직 케어</li>
                            <li>베이직 케어 + 패디 + 각질</li>
                            <li>베이직 젤네일 + 패디젤</li>
                            -->
                        </ul>
                    </div>
                </div>
    
                <!-- 보유 포인트 -->
                <div class="holding_point_wrap point_wrap">
                    <h2>보유 포인트</h2>
                    <span><em id="holding_point">6,000,000</em>P</span>
                </div>
    
                <!-- 사용 포인트 -->
                <div class="use_point_wrap point_wrap">
                    <h2>사용 포인트</h2>
                    <span><em id="use_point"></em>P</span>
                </div>
            </div>

            <div class="service_result_wrap">
                <!-- 사용 포인트 결과 -->
                <div class="holding_point_wrap point_wrap">
                    <h2>사용 포인트</h2>
                    <span><em id="use_result_point">0</em>P</span>
                </div>
    
                <!-- 결제 후 잔액 포인트 -->
                <div class="use_point_wrap point_wrap">
                    <h2>결제 후 잔액 포인트</h2>
                    <span><em id="use_result_point2">0</em>P</span>
                </div>                
            </div>

            <!-- 결제 버튼 -->
            <!-- 22.03.18 수정 -->
            <!-- <button type="submit" id="payment_btn">결제하기</button> -->

            <!-- 버튼 비활성화 -->
            <button type="button" onclick="usePoint()" id="payment_btn" class="btn">결제하기</button>
            <!-- 버튼 활성화 -->
            <!-- <button type="button" onclick="usePoint()" id="payment_btn" class="btn on">결제하기</button> -->

        </section>
    
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
    <script>
    var point_type = '{{ $type }}';
    var isInFirst = true;
	function getShops(){
		medibox.methods.point.shops({ point_type: point_type }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpShops = '';
			for(var inx = 0; inx < response.data.length; inx++){
                tmpShops = tmpShops + '<li onclick="getServices(point_type, \''+response.data[inx].service_name+'\')">'+response.data[inx].service_name+'</li>';
			}
            $('._shops').html(tmpShops);
            if(isInFirst && point_type != 'P') {
                $('._choosedShop').text(response.data[0].service_name);
                $('._choosedShop').parent().addClass('on');
                getServices(point_type, response.data[0].service_name);
                isInFirst = false;
            }            
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
	var service_name;
    var product_seqno;
    var currect_point = 0;
	function getServices(pointType, shopName){
        service_name = shopName;
        $('._choosedShop').text(shopName);
        $('._choosedShop').parent().addClass('on');
        $('._shops').removeClass('on');

		medibox.methods.point.services({ point_type: pointType, service_name: shopName }, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var tmpServices = '';
			for(var inx = 0; inx < response.data.length; inx++){
                tmpServices = tmpServices + '<li onclick="chooseProduct('+response.data[inx].product_seqno+', \''+(response.data[inx].type_name+(response.data[inx].service_sub_name ? '-'+response.data[inx].service_sub_name : ''))+'\', '+response.data[inx].price+')" value="'+response.data[inx].product_seqno+'" price="'+response.data[inx].price+'">'+response.data[inx].type_name+(response.data[inx].service_sub_name ? '-'+response.data[inx].service_sub_name : '')+'</li>';
			}
			$('._services').html(tmpServices);
//            $('._choosedService').text(response.data[0].type_name+(response.data[0].service_sub_name ? '-'+response.data[0].service_sub_name : ''));
            $('._choosedService').text('서비스 선택');
            $('._choosedService').parent().removeClass('on');
			product_seqno = response.data[0].product_seqno;
            /*
			$('#use_point').html(medibox.methods.toNumber(response.data[0].price));
			$('#use_result_point').html(medibox.methods.toNumber(response.data[0].price));
			$('#use_result_point2').html(medibox.methods.toNumber(currect_point - Number(response.data[0].price)));
            */
			$('#use_point').html(0);
			$('#use_result_point').html(0);
			$('#use_result_point2').html(medibox.methods.toNumber(currect_point));
            $('#payment_btn').removeClass('on');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    function chooseProduct(seqno, name, price) {
        product_seqno = seqno;
        $('._choosedService').parent().addClass('on');
        $('._choosedService').text(name);
        $('._services').removeClass('on');
        $('#use_point').html(medibox.methods.toNumber(price));
        $('#use_result_point').html(medibox.methods.toNumber(price));
        $('#use_result_point2').html(medibox.methods.toNumber(currect_point - Number(price)));
        $('#payment_btn').addClass('on');
    }
	function usePoint(){
        if(! $('#payment_btn').hasClass('on') || !product_seqno) {
            return false;
        }
        if(! confirm('포인트 결제 하시겠습니까?')) {
            return false;
        }
		var point_type = '{{ $type }}';
		var memo = '사용자 구매 신청';
		
		var data = { admin_seqno:1, user_seqno:{{ $seqno }}, product_seqno: product_seqno,
			point_type:point_type, memo:memo };

		medibox.methods.point.use(data, function(request, response){
			console.log('output : ' + response);
            location.href = '/point/approval/' + response.code + '?id='+response.data;
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    
	function getInfo(){		
		var data = { user_seqno:{{ $seqno }}, point_type: '{{ $type }}',
			rpageNo:1, rpageSize:5, upageNo:1, upageSize:5 };

		medibox.methods.point.mine(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
            }
            currect_point = Number(response.data.filter(a => a.point_type == '{{ $type }}')[0].point);
            $('#holding_point').text( medibox.methods.toNumber(currect_point));
            getShops();
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