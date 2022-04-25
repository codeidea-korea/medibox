
@include('user.header2')

    <section id="brand">
        <div class="event_slider slick-initialized slick-slider">
            <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 1500px; transform: translate3d(0px, 0px, 0px);"><a href="#!" class="event01 slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" style="width: 740px;" tabindex="0">
                <h3>
                    미니쉬<br>
                    집중예방 관리센터<br>
                    오픈 기념 이벤트
                </h3>
                <p>
                    스페셜 관리 프로그램
                </p>
            </a><a href="#!" class="event02 slick-slide" data-slick-index="1" aria-hidden="true" style="width: 740px;" tabindex="-1">
                <h3>
                    미니쉬<br>
                    집중예방 관리센터<br>
                    오픈 기념 이벤트
                </h3>
                <p>
                    스페셜 관리 프로그램
                </p>
            </a></div></div>
            
        </div>

        <!-- 브랜드 시안3 -->
        <div class="brand_menu3">
            <h2>브랜드 소개</h2>

            <ul>
                <li><a href="/brand/minishspa">
                    <figure class="minish_spa"></figure>
                    <div class="txt_box">
                        <h3>미니쉬 스파</h3>
                        <p>
                            미니쉬 치과 병원 구강관리 SPA 1:1<br>
                            맞춤 관리 및 코칭 서비스
                        </p>
                    </div>
                </a></li>
                <li><a href="/brand/valmontspa">
                    <figure class="valmont_spa"></figure>
                    <div class="txt_box">
                        <h3>발몽 스파</h3>
                        <p>미니쉬 발몽 스파 스페셜 테라피</p>
                    </div>
                </a></li>
                <li><a href="/brand/nail">
                    <figure class="nail"></figure>
                    <div class="txt_box">
                        <h3>바라는 네일</h3>
                        <p>1:1 관리 예약 우선제 / 전문적인 케어</p>
                    </div>
                </a></li>
                <li><a href="/brand/deepfocus">
                    <figure class="deep_focus"></figure>
                    <div class="txt_box">
                        <h3>딥포커스 검안센터</h3>
                        <p>
                            기존 뉴욕스토리안경원의<br>
                            프리미엄 검안 전문체
                        </p>
                    </div>
                </a></li>
                <li><a href="/brand/minishtherapy">
                    <figure class="minish_manul_therapy"></figure>
                    <div class="txt_box">
                        <h3>미니쉬 도수</h3>
                        <p>
                            전문교육을 이수한 도수 치료사가 손을<br>
                            이용하여 시행하는 프리미엄 물리치료
                        </p>
                    </div>
                </a></li>
                <li><a href="/brand/forestablack">
                    <figure class="foresta_black"></figure>
                    <div class="txt_box">
                        <h3>포레스타 블랙</h3>
                        <p>
                            국내 최초이자 유일한 아베다의 뷰티<br>
                            최상 등급 라이프 살롱
                        </p>
                    </div>
                </a></li>
            </ul>
        </div>   
    </section>

    <script>
        @if ( session('user_seqno') )
            $(document).ready(function(){
                $('.gnb li:nth-child(1)>a').off();
            });
        @else
    //        $('.gnb li:nth-child(1)>a').off();
        @endif
        window.onpageshow = function(event) {
            $('#loading').fadeOut('slow');
            $('.popup').removeClass('on');
        }
    </script>
@include('user.footer')

</body>
</html>