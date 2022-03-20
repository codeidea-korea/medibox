
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
                <span>약관 및 정책</span>
            </div>
        </header>

        <section id="privacy">
            <ul class="privacy_txt_wrap">
                <li>
                    1. 개인정보의 수집 이용 목적<br>
                    개인정보란 회원개인을 식별할 수 있는 정보 (당해 정보만으로는 특정개인을 식별할 수 없더라도 다른 정보와 용이하게 결합하여 식별할 수 있는 것을 포함)를 말한다.<br>
                    회사는 아래와 같은 목적으로 서비스 제공을 위한 최소한의 개인정보만을 수집하며, 수집한 정보를 목적 외로 사용하거나, 회원의 동의 없이 외부에 공개하지 않는다.                                        
                </li>
                <li>
                    1)회원관리: 회원제 서비스 제공에 따른 개인식별, 가입의사 확인, 가입 및 가입횟수 제한, 이용약관 위반 회원에 대한 이용제한 조치, 불량 회원의 서비스 부정이용 방지, 비인가 사용 방지, 고충 처리 및 분쟁 조정을 위한 기록 보존, 고지사항 전달, 회원 탈퇴의사의 확인                    
                </li>
                <li>
                    2) 신규 서비스 개발, 기능 개선, 마케팅 및 광고에 활용 : 신규서비스 개발 및 맞춤 서비스 제공, 기능 개선, 인구 통계학적 특성에 따른 서비스 제공 및 광고 게재, 서비스의 유효성 확인, 이벤트 광고성 정보 및 참여 기회 제공 (회원의 개인정보는 광고를 의뢰한 개인이나 단체에는 제공되지 않음), 접속 빈도 파악, 회원의 서비스 이용에 대한 통계                    
                </li>
                <li>
                    3) 서비스 이용 “ 이벤트/의사지정 상담예약 신청 및 신청완료 문자 수신, 콘텐츠 작성 및 저장, 활동포인트 획득 및 상품 교환
                </li>
                <li>
                    4) 접근제한 : 연령에 따른 콘텐츠 접근 제한 및 서비스 부정이용 방지
                </li>
            </ul>
        </section>

    
@include('user.footer')


        
</body>
</html>