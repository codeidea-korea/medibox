
@include('user.header2')

    <section id="brand">
        <div class="event_slider slick-initialized slick-slider">
            <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 1500px; transform: translate3d(-750px, 0px, 0px);"><a href="#" onclick="wait()" class="event01 slick-slide" data-slick-index="0" aria-hidden="true" style="width: 740px;" tabindex="-1">
                <h3>
                    미니쉬<br>
                    집중예방 관리센터<br>
                    오픈 기념 이벤트
                </h3>
                <p>
                    스페셜 관리 프로그램
                </p>
            </a><a href="#" onclick="wait()" class="event02 slick-slide slick-current slick-active" data-slick-index="1" aria-hidden="false" style="width: 740px;" tabindex="0">
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

        <!-- 브랜드 시안2 -->
        <div class="brand_menu2">
            <h2>브랜드 소개</h2>
            <nav id="reservation_lnb">
                <ul class="lnb_inner">
                    <li>
                        <a href="/brand/minishspa">
                            <div class="menu_box">
                                <img src="/user/img/icon_minish_spa.svg" alt="미니쉬 스파">
                                <span>미니쉬<br>스파</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/brand/valmontspa">
                            <div class="menu_box">
                                <img src="/user/img/icon_valmont_spa.svg" alt="발몽스파">
                                <span>발몽스파</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/brand/nail">
                            <div class="menu_box">
                                <img src="/user/img/icon_nail.svg" alt="바라는 네일">
                                <span>바라는<br>네일</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/brand/deepfocus">
                            <div class="menu_box">
                                <img src="/user/img/icon_deep_focus.svg" alt="딥 포커스">
                                <span>딥포커스<br>검안센터</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/brand/minishtherapy">
                            <div class="menu_box">
                                <img src="/user/img/icon_minish_manul_therapy.svg" alt="미니쉬도수">
                                <span>미니쉬<br>도수</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/brand/forestablack">
                            <div class="menu_box">
                                <img src="/user/img/icon_foresta_black.svg" alt="포레스타블랙">
                                <span>포레스타<br>블랙</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>  

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