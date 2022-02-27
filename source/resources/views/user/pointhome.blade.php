<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medibox</title>

    <link rel="stylesheet" href="{{ asset('user/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/medibox.css') }}">
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('user/js/tabmenu.js') }}"></script>
</head>
<body>

        <!-- header -->
        <header id="header">
            <!-- 뒤로가기 버튼 -->
            <button class="back" onclick="location.href='/';">
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


        <!-- 포인트 필터 탭메뉴 -->
        <div id="point_tab_menu">
            <ul>
                <li>전체</li>
                <li>포인트</li>
                <li>정액권</li>
            </ul>
            <span class="highlight"></span>
        </div>


        <!-- 포인트 & 정액권 페이지 -->
        <section id="point_payment">

            <div class="my_point_wrap">
                <h2>내 포인트</h2>
                <div class="container">
                    <div class="my_point">
                        <span><strong id="point" class="_userPoint">6,000,000</strong>P</span>
                    </div>
                    <div class="payment">
                        <a href="/point/payment/P">결제하기</a>
                        <a href="/point/history">결제내역</a>
                    </div>
                </div>
            </div>

            <div class="my_pass_wrap _subscribe">
                <h2>정액권</h2>
    
                <div class="container foresta">
                    <div class="my_pass">
                        <h3>포레스타 정액권</h3>
                        <span><strong id="point">2,200,000</strong>P</span>
                    </div>
                    <div class="payment">
                        <a href="/point/payment">결제하기</a>
                    </div>
                </div>
    
                <div class="container nail">
                    <div class="my_pass">
                        <h3>네일 정액권</h3>
                        <span><strong id="point">1,050,000</strong>P</span>
                    </div>
                    <div class="payment">
                        <a href="/point/payment">결제하기</a>
                    </div>
                </div>
    
                <div class="container package">
                    <div class="my_pass">
                        <h3>PACKAGE</h3>
                        <span><strong id="point">500,000</strong>P</span>
                    </div>
                    <div class="payment">
                        <a href="/point/payment">결제하기</a>
                    </div>
                </div>
            </div>

        </section>
    
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
	<script>
	function getInfo(){		
		var data = { user_seqno:{{ $seqno }}, 
			rpageNo:1, rpageSize:5, upageNo:1, upageSize:5 };

		medibox.methods.point.mine(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
            $('._userPoint').text( medibox.methods.toNumber(response.data.filter(a => a.point_type == 'P')[0].point));
            
            var tmpItem = '<h2>정액권</h2>';
            for(var inx = 0; inx<response.data.length; inx++){
                if(response.data[inx].point_type == 'P') {
                    continue;
                }
                if(response.data[inx].point < 1) {
                    continue;
                }
                tmpItem = tmpItem + 
                    '<div class="container '+getPointType2Class(response.data[inx].point_type)+'">'
                    +'    <div class="my_pass">'
                    +'        <h3>'+getPointType(response.data[inx].point_type)+'</h3>'
                    +'        <span><strong id="point">'+medibox.methods.toNumber(response.data[inx].point)+'</strong>P</span>'
                    +'    </div>'
                    +'    <div class="payment">'
                    +'        <a href="/point/payment/'+response.data[inx].point_type+'">결제하기</a>'
                    +'    </div>'
                    +'</div>';
            }
            $('._subscribe').html(tmpItem);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
	function getPointType(type){
		switch(type){
			case 'S1':
				return '통합 정액권';
			case 'S2':
				return '네일 정액권';
			case 'S3':
				return '발몽 정액권';
			case 'S4':
				return '포레스타 정액권';
			case 'P':
				return '포인트';
			case 'K':
				return 'PACKAGE';
			default:
				return '-';
		}
	}
	function getPointType2Class(type){
		switch(type){
			case 'S1':
				return 'nail';
			case 'S2':
				return 'nail';
			case 'S3':
				return 'foresta';
			case 'S4':
				return 'foresta';
			case 'P':
				return 'foresta';
			case 'K':
				return 'foresta';
			default:
				return '-';
		}
	}
	$(document).ready(function(){
		getInfo();
	});
	</script>

</body>
</html>