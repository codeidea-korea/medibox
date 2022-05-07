
@include('user.header')
    
    <!-- header -->
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="location.href='/profile';">
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
            <span>결제 내역</span>
        </div>
    </header>


    <nav id="history_lnb">
        <ul class="depth01">
            <li>
                <a href="#!" id="searchMonthTit">전체 기간</a>
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
                <a href="#!" id="searchTypeTit">전체 내역</a>
                <ul class="depth02">
                    <!-- 22.03.31 추가 -->
                    <li><a href="#!" onclick="searchType('')">전체</a></li>
                    <!------------------>
                    <li><a href="#!" onclick="searchType('P')">포인트</a></li>
                    <li><a href="#!" onclick="searchType('!P')">정액권</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <section id="pay_history">
        <ul class="_history_items">
        <li></li>
        </ul>
    </section>


    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('user/js/medibox-apis.js') }}?v=2022012918"></script>
	<script>
    var startDay = "";
    var endDay = "{{ date('Y-m-d', strtotime('+1 day')) }}";
    var pointtype = "";
    var pageNo = 1;
    var pageSize = 70;

    function searchType(type){
        var searchTypeTit = '전체 내역';
        if(type == 'P') {
            searchTypeTit = '포인트';
        } else if(type == '!P') {
            searchTypeTit = '정액권';
        }
        pointtype = type;
        $('#searchTypeTit').html(searchTypeTit);
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
        } else if(type == 12) {
            searchMonthTit = '1년';
        }
        // 전체 기간
        $('#searchMonthTit').html(searchMonthTit);
        getList();
    }
    function getList(){
        var data = { user_seqno:{{ $seqno }}, point_type:pointtype, startDay: startDay, endDay: endDay,
            pageNo:pageNo, pageSize:pageSize };

		medibox.methods.point.history(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
            var tmpHtml = '';
            for(var inx = 0; inx < response.data.length; inx++){
                var productName = getProductName(response.data[inx]);
                tmpHtml = tmpHtml 
                    + '<li>'
                    + '    <div class="history_item">'
                    + '        <div class="left">'
                    + '            <h3>'+productName+'</h3>'
                    + '            <span class="category">'+getPointType(response.data[inx].point_type) +'</span>'
                    + '            <span class="date">'+response.data[inx].create_dt+'</span>'
                    + '        </div>'
                    + '        <div class="right">'
                    + '            <span class="point">'+getCalculate2HstType(response.data[inx].hst_type)+medibox.methods.toNumber(response.data[inx].point)+' P</span>'
                    + '            <span class="whether '+getClassByHstType(response.data[inx].hst_type)+'">'+getHstType(response.data[inx].hst_type)+(response.data[inx].hst_type == 'U' 
                                                ? (response.data[inx].canceled == 'N'
                                                    ? (response.data[inx].approved == 'N' ? '(승인중)'
                                                    : '')
                                                : ' (취소됨)')
                                            : '' )+'</span>'
                    + '        </div>'
                    + '    </div>'
                    + '</li>';
            }
            $('._history_items').html(tmpHtml);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    function getClassByHstType(type){
		switch(type){
			case 'U':
				return 'use';
			case 'R':
				return 'refund';
			case 'S':
				return 'charge';
			default:
				return '';
		}
    }
    function getHstType(type){
		switch(type){
			case 'U':
				return '사용';
			case 'R':
				return '환불';
			case 'S':
				return '충전';
			default:
				return '';
		}
    }
    function getCalculate2HstType(type){
		switch(type){
			case 'U':
				return '-';
			case 'R':
				return '-';
			case 'S':
				return '+';
			default:
				return '';
		}
    }
    function getPointType(type){
		switch(type){
			case 'S1':
			case 'S2':
			case 'S3':
			case 'S4':
				return '정액권';
			case 'P':
				return '내 포인트';
			case 'K':
				return '패키지';
			default:
				return '-';
		}
    }
    function getPointNameType(type){
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
				return '패키지';
			default:
				return '-';
		}
    }
    function getProductName(data){
        // hst_type, type, type_name, memo
		switch(data.hst_type){
			case 'U':
			case 'R':
                var serviceName = '';
                if(data.product_name && data.product_seqno < 1) {
                    return data.shop_name + ' ' + data.product_name + ' ' + getHstType(data.hst_type);
                }
                if(data.product_name && data.point_type == 'P') {
                    return data.product_name + ' ' + getHstType(data.hst_type);
                }
                if(data.detail && data.detail.service_name) {
                    serviceName = serviceName + data.detail.service_name;
                    if(data.detail && data.detail.type_name && data.detail.type_name != '') {
                        serviceName = serviceName + ' ' + data.detail.type_name;
                    }
                    if(data.detail && data.detail.service_sub_name && data.detail.service_sub_name != '') {
                        serviceName = serviceName + ' ' + data.detail.service_sub_name;
                    }
                    return serviceName + ' ' + getHstType(data.hst_type);
                }
				return getPointNameType(data.point_type) + ' ' + getHstType(data.hst_type);
			case 'S':
				return getPointNameType(data.point_type);
			default:
				return '';
        }
    }
	$(document).ready(function(){
		getList();
	});
	</script>
@include('user.footer')

</body>
</html>