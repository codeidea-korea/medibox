
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

        <!-- 브랜드 시안4 -->
        <div class="brand_menu4">
            <h2>브랜드 소개</h2>


            <ul class="brand_wrap">
                
            @php
            if(count($brands) > 0) {
                for($inx = 0; $inx < count($brands); $inx++){
                    echo '    <li class="minish_spa" style="background-image:linear-gradient(to right ,rgba(0,0,0,0.5), transparent), url(/user/img/img_brand0'.$brands[$inx]->seqno.'_02.jpg);">'
                        .'    <a href="/brand/'.$brands[$inx]->seqno.'">'
                        .'        <div class="txt_box">'
                        .'            <img src="'.str_replace('.svg', '_w.svg', $brands[$inx]->icon_reservation_store).'" alt="'.$brands[$inx]->cop_name.'">'
                        .'            <span>'.$brands[$inx]->cop_eng_name.'</span>'
                        .'            <h3>'.$brands[$inx]->cop_name.'</h3>'
                        .'        </div>'
                        .'    </a>'
                        .'</li>';
                }
            } else {
                echo '<li>브랜드가 없습니다.</li>';
            }
            @endphp

            {{--
                <li class="minish_spa">
                <a href="/brand/minishspa">
                    <div class="txt_box">
                        <img src="/user/img/icon_minish_spa_w.svg" alt="미니쉬 스파">
                        <span>Minsh Spa</span>
                        <h3>미니쉬 스파</h3>
                    </div>
                </a>
            </li>
            <li class="valmont_spa">
                <a href="/brand/valmontspa">
                    <div class="txt_box">
                        <img src="/user/img/icon_valmont_spa_w.svg" alt="발몽 스파">
                        <span>MINISH Valmont Spa</span>
                        <h3>발몽 스파</h3>
                    </div>
                </a>
            </li>
            <li class="nail">
                <a href="/brand/nail">
                    <div class="txt_box">
                        <img src="/user/img/icon_nail_w.svg" alt="바라는 네일">
                        <span>Tomorrow’s wish</span>
                        <h3>바라는 네일</h3>
                    </div>
                </a>
            </li>
            <li class="deep_fucus">
                <a href="/brand/deepfocus">
                    <div class="txt_box">
                        <img src="/user/img/icon_deep_focus_w.svg" alt="딥포커스 검안센터">
                        <span>Deep Focus</span>
                        <h3>딥포커스 검안센터</h3>
                    </div>
                </a>
            </li>
            <li class="minish_manul_therapy">
                <a href="/brand/minishtherapy">
                    <div class="txt_box">
                        <img src="/user/img/icon_minish_manul_therapy_w.svg" alt="미니쉬 도수">
                        <span>Minish Manul Therapy</span>
                        <h3>미니쉬 도수</h3>
                    </div>
                </a>
            </li>
            <li class="foresta_black">
                <a href="/brand/forestablack">
                    <div class="txt_box">
                        <img src="/user/img/icon_foresta_black_w.svg" alt="포레스타 블랙">
                        <span>Foresta Black</span>
                        <h3>포레스타 블랙</h3>
                    </div>
                </a>
            </li>
            --}}
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