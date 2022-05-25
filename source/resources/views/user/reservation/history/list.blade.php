
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
            <span>예약내역</span>
        </div>
    </header>

    <nav id="reservation_lnb">
        <ul class="lnb_inner">
            @php
            if(count($stores) > 0) {
                for($inx = 0; $inx < count($stores); $inx++){
                    if(empty($stores[$inx]->partnerInfo)) continue;
                    echo '<li>'
                        .'    <a href="/reservation/'.$stores[$inx]->seqno.'">'
                        .'        <div class="menu_box">'
                        .'            <img src="'.$stores[$inx]->partnerInfo->icon_reservation_store.'" alt="'.$stores[$inx]->partnerInfo->cop_name.'">'
                        .'            <span>'.$stores[$inx]->name.'</span>'
                        .'        </div>'
                        .'    </a>'
                        .'</li>';
                }
            } else {
                echo '<li>매장이 없습니다.</li>';
            }
            @endphp
            {{--
            <li>
                <a href="./minishspa_reservation.html">
                    <div class="menu_box">
                        <img src="./img/icon_minish_spa.svg" alt="미니쉬 스파">
                        <span>포레스타 블랙 강남점</span>
                    </div>
                </a>
            </li>
            --}}
        </ul>
    </nav>

    <section id="reservation">
         <!-- <h2>예약내역</h2> -->

        <!-- 예약내역이 없을 때 -->
        <!-- <figure class="empty_reservation">
            <img src="/user/img/icon_empty_reservation.png" alt="예약내역이 없습니다.">
            <p>예약내역이 없습니다.</p>
        </figure> -->

        <!-- 예약내역이 있을 때 -->
        <ul class="history_wrap">
            <li>
                <div class="top">
                    <span class="current check">예약 확인</span>
                    <!-- 22.03.20 a 링크 수정 -->
                    <!-- <a href="#!" class="view_detail_btn">예약 상세보기</a> -->
                    <a href="/user/reservation_check.html" class="view_detail_btn">예약 상세보기</a>
                </div>
                <div class="mid">
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li>2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li>포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li>포레스타 펌</li>
                            <li>[디자이너] 릴리</li>
                        </ul>
                    </div>
                </div>
                <div class="bot">
                    <a href="#!" class="share_btn">
                        <img src="/user/img/icon_share.svg" alt="공유하기">
                    </a>
                    <a href="#!" class="change_btn">예약변경</a>
                    <a href="#!" class="cancle_btn">예약취소</a>
                </div>
            </li>
        </ul>



        <ul class="history_wrap">
            <li>
                <div class="top">
                    <span class="current cancel">예약 취소</span>
                    <!-- 22.03.20 a 링크 수정 -->
                    <!-- <a href="#!" class="view_detail_btn">예약 상세보기</a> -->
                    <a href="/user/reservation_check.html" class="view_detail_btn">예약 상세보기</a>
                </div>
                <div class="mid">
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li>2022년 3월 9일 (토) 9:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li>미니쉬스파</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li>잇몸튼튼 프로그램</li>
                        </ul>
                    </div>
                </div>
                <div class="bot">
                    <a href="#!" class="share_btn">
                        <img src="/user/img/icon_share.svg" alt="공유하기">
                    </a>
                    <a href="#!" class="change_btn">예약변경</a>
                    <a href="#!" class="cancle_btn">예약취소</a>
                </div>
            </li>
        </ul>



        <ul class="history_wrap">
            <li>
                <div class="top">
                    <span class="current completion">이용 완료</span>
                    <!-- 22.03.20 a 링크 수정 -->
                    <!-- <a href="#!" class="view_detail_btn">예약 상세보기</a> -->
                    <a href="/user/reservation_check.html" class="view_detail_btn">예약 상세보기</a>
                </div>
                <div class="mid">
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li>2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li>포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li>포레스타 펌</li>
                            <li>[디자이너] 릴리</li>
                        </ul>
                    </div>
                </div>
                <div class="bot">
                    <a href="#!" class="share_btn">
                        <img src="/user/img/icon_share.svg" alt="공유하기">
                    </a>
                    <a href="#!" class="change_btn">예약변경</a>
                    <a href="#!" class="cancle_btn">예약취소</a>
                </div>
            </li>
        </ul>



        <ul class="history_wrap">
            <li>
                <div class="top">
                    <span class="current check">예약 확인</span>
                    <!-- 22.03.20 a 링크 수정 -->
                    <!-- <a href="#!" class="view_detail_btn">예약 상세보기</a> -->
                    <a href="/user/reservation_check.html" class="view_detail_btn">예약 상세보기</a>
                </div>
                <div class="mid">
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li>2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li>포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li>포레스타 펌</li>
                            <li>[디자이너] 릴리</li>
                        </ul>
                    </div>
                </div>
                <div class="bot">
                    <a href="#!" class="share_btn">
                        <img src="/user/img/icon_share.svg" alt="공유하기">
                    </a>
                    <a href="#!" class="change_btn">예약변경</a>
                    <a href="#!" class="cancle_btn">예약취소</a>
                </div>
            </li>
        </ul>
    </section>


    <div class="modal_wrap share">
        <div class="modal_inner">
            <h4>링크 공유</h4>
            <ul>
                <li><a href="#">
                    <img src="/user/img/icon_copy.svg" alt="링크 복사">
                    <span>링크 복사</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/kakao.svg" alt="카카오톡 공유하기">
                    <span>카카오톡</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/naver.svg" alt="네이버 공유하기">
                    <span>네이버</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/google.svg" alt="구글 공유하기">
                    <span>구글</span>
                </a></li>
            </ul>
            <a href="#" class="close_btn">취소</a>
        </div>
    </div>


    <!-- 22.03.11 추가 -->
    <div id="popup22" class="popup select reservation">
        <div class="container">
            <div class="history_wrap">
                <div class="mid">
                    <h2>예약취소</h2>
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li class="cancelDt">2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li class="cancelShop">포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li class="cancelService">포레스타 펌</li>
                            <li class="cancelDesigner">[디자이너] 릴리</li>
                        </ul>
                    </div>
                    <!-- 22.03.14 추가 -->
                    <p>예약을 정말로 취소하시겠습니까?</p>
                </div>
            </div>
            <div class="bottom">
                <a href="#" class="close_btn">아니오</a>
                <a href="#" onclick="remove()">네</a>
            </div>
        </div>
    </div> 
    <!----------------->


    <!-- 22.03.14 추가 -->
    <div id="popup23" class="popup select reservation">
        <div class="container">
            <div class="history_wrap">
                <div class="mid">
                    <h2>예약취소완료</h2>
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li class="cancelDt">2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li class="cancelShop">포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li class="cancelService">포레스타 펌</li>
                            <li class="cancelDesigner">[디자이너] 릴리</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <a href="#" onclick="location.reload()">확인</a>
            </div>
        </div>
    </div>
    <!----------------->


    <script>
    var pageNo = 1;
    var pageSize = 50;
    var datas = [];
    // list get
    function loadHistory(){
        var data = { pageNo: pageNo, pageSize: pageSize, user_seqno:{{ $seqno }} };

		medibox.methods.store.reservation.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#totalCnt').text( medibox.methods.toNumber(response.count) );

			var bodyData = '<h2>예약내역</h2>';
			if(response.count == 0){
                if(pageNo == 1) {
                    datas = [];
                    $('#reservation').html(bodyData +
                        '<figure class="empty_reservation">'
                            +'<img src="/user/img/icon_empty_reservation.png" alt="예약내역이 없습니다.">'
                            +'<p>예약내역이 없습니다.</p>'
                        +'</figure>');
                }
				return;
            }
            if(pageNo > 1) {
                datas = [];
                bodyData = $('#reservation').html();
            }
			for(var inx=0; inx<response.data.length; inx++){
                datas[datas.length] = response.data[inx];
                bodyData = bodyData 
                    +'<ul class="history_wrap">'
                    +'    <li>'
                    +'        <div class="top">'
                    +'            <span class="current '+ convertStyleForStatus(response.data[inx].status)+'">'+convertTitForStatus(response.data[inx].status)+'</span>'
                    +'            <a href="#" '
                    + (response.data[inx].status == 'C' ? '></a>' : 'onclick="gotoDetail('+response.data[inx].seqno+')" class="view_detail_btn">예약 상세보기</a>')
                    +'        </div>'
                    +'        <div class="mid">'
                    +'            <div class="date">'
                    +'                <h3>예약 날짜</h3>'
                    +'                <ul>'
                    +'                    <li>'+toReservationDate(response.data[inx].start_dt)+'</li>'
                    +'                </ul>'
                    +'            </div>'
                    +'            <div class="store">'
                    +'                <h3>예약 매장</h3>'
                    +'                <ul>'
                    +'                    <li>'+response.data[inx].storeInfo.name +'</li>'
                    +'                </ul>'
                    +'            </div>'
                    +'            <div class="menu">'
                    +'                <h3>예약 메뉴</h3>'
                    +'                <ul>'
                    +'                    <li>'+(response.data[inx].serviceInfo ? response.data[inx].serviceInfo.name : '-')+'</li>'
                    + (
                        response.data[inx].managerInfo 
                            ? '                    <li>['+(response.data[inx].managerInfo ? response.data[inx].managerInfo.manager_type : '기본')+'] '
                                                +(response.data[inx].managerInfo ? response.data[inx].managerInfo.name : '-')+'</li>'
                            : ''
                    )
                    +'                </ul>'
                    +'            </div>'
                    +'        </div>'

                    + (response.data[inx].status == 'R' 
                        ? 
                            '        <div class="bot">'
                            +'            <a href="#!" onclick="shareUri('+response.data[inx].seqno+')" class="share_btn">'
                            +'                <img src="/user/img/icon_share.svg" alt="공유하기">'
                            +'            </a>'
                            +'            <a href="#!" onclick="gotoModify('+response.data[inx].seqno+')" class="change_btn">예약변경</a>'
                            +'            <a href="#!" onclick="openRemove('+response.data[inx].seqno+', '+(datas.length-1)+')" class="cancle_btn">예약취소</a>'
                            +'        </div>'
                        : ''
                    )

                    +'    </li>'
                    +'</ul>'
			}
			$('#reservation').html(bodyData);
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    
    function convertStyleForStatus(code) {
		switch(code){
			case 'C': return 'cancel';
			case 'D': return 'completion';
			case 'R': 
			case 'N': 
			case 'E': return 'check';
			default: break;
		}
    }
    function convertTitForStatus(code) {
		switch(code){
			case 'C': return '예약 취소';
			case 'R': return '예약 완료';
			case 'N': return '예약 불이행';
			case 'E': return '고객 입장';
			case 'D': return '서비스 완료';
			default: break;
		}
    }
	function convert2Day(code){
		switch(code){
			case 0: return '일';
			case 1: return '월';
			case 2: return '화';
			case 3: return '수';
			case 4: return '목';
			case 5: return '금';
			case 6: return '토';
			default: break;
		}
	}
    function toReservationDate(targetDt){
        var targetDate = new Date(targetDt);
        var date = targetDt.split('-');
        return targetDate.getFullYear() + '년 ' + (targetDate.getMonth() + 1) + '월 ' + targetDate.getDate() + '일 ' + convert2Day(targetDate.getDay()) + ' ' + targetDate.getHours() + ':' + (targetDate.getMinutes() < 10 ? '0'+targetDate.getMinutes(): targetDate.getMinutes());
    }
    // 공유하기
    function shareUri(seq){
        medibox.methods.share({
            title: '[MEDIBOX 예약]',
            text: '상세보기',
            url: '/reservation-history/' + seq,
        });
    }
    // 예약 취소
    function openRemove(seq, inx){
        prevReservationId = seq;
        // 세팅
        $('.cancelDt').text(toReservationDate(datas[inx].start_dt));
        $('.cancelShop').text(datas[inx].storeInfo.name);
        $('.cancelService').text((datas[inx].serviceInfo ? datas[inx].serviceInfo.name : '-'));
        $('.cancelDesigner').text('['+(datas[inx].managerInfo ? datas[inx].managerInfo.manager_type : '기본')+'] '
                                                +(datas[inx].managerInfo ? datas[inx].managerInfo.name : '-'));
        $('#popup22').addClass('on');
    }
    
	function remove(){
		medibox.methods.store.reservation.status({
			status: 'C'
		}, prevReservationId, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
            $('#popup23').addClass('on');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
    // 예약 상세
    function gotoDetail(seq){
        location.href = '/reservation-history/' + seq;
    }
    function gotoModify(seq){
        location.href = '/reservation-history/'+seq+'/modify';
    }

    function clip(){
        var url = '';
        var textarea = document.createElement("textarea");
        document.body.appendChild(textarea);
        url = location.origin + '/reservation-history/'+prevReservationId;
        textarea.value = url;
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("URL이 복사되었습니다.");
    }

    $(document).ready(function(){
        loadHistory();

        var shareTags = $('.share > .modal_inner > ul > li');
        $(shareTags[0]).on('click', clip);
    });
    </script>
    @include('user.footer')


</body>
</html>