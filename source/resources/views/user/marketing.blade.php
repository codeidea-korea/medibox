
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
                <span>마케팅 활용 및 광고성 정보 수신 동의</span>
            </div>
        </header>

        <section id="privacy">
            <h2>[선택] 마케팅 활용 및 광고성 정보 수신 동의</h2>
            <ul class="txt_wrap">
                <li>
                    <p>미니쉬테크놀로지 주식회사(이하 “미니쉬테크”)가 운영하는 미니쉬라운지(이하 “라운지”)는 「개인정보보호법」 제30조에 따라 정보주체의 개인정보를 보호하고 이와 관련한 고충을 신속하고 원활하게 처리할 수 있도록 하기 위하여 다음과 같이 개인정보처리방침을 수립•공개합니다.
                    본 개인정보처리방침은 법률의 제•개정, 정부의 정책 변경, 회사의 내부 방침의 변경에 따라 변경될 수 있으며, 수시로 확인하여 주시기 바랍니다.</p>
                    <table>
                        <tr>
                            <td>수집항목</td>
                            <td>수집목적</td>
                            <td>보유기간</td>
                        </tr>
                        <tr>
                            <td rowspan="2">휴대폰 번호</td>
                            <td>SMS/MMS<br>마케팅</td>
                            <td rowspan="2">회원탈퇴 또는 5년간 이용실적 없을 시</td>
                        </tr>
                        <tr>
                            <td>전화 마케팅</td>
                        </tr>
                    </table>
                    <p>*위 개인정보 수집·이용에 대한 동의를 거부할 수 있으나 동의 거부 시 할인 및 이벤트 정보 안내 등의 서비스가 제한됩니다.</p>
                </li>
            </ul>
        </section>

        @include('user.footer')

        
</body>
</html>