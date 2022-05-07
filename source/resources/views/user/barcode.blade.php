
@include('user.header2')

<body style="padding-bottom:0;">
    
    <!-- header -->
    <header id="header" class="black">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                <g id="back_arrow" transform="translate(-22.295 -60)">
                    <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)" fill="none"></rect>
                    <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                    <g id="그룹_388" data-name="그룹 388">
                        <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none" stroke="#FFF" stroke-miterlimit="10" stroke-width="1"></line>
                        <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331" transform="translate(-3352 -1077.894)" fill="none" stroke="#FFF" stroke-linecap="square" stroke-width="1"></path>
                        <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331" transform="translate(-3352 -1071.563)" fill="none" stroke="#FFF" stroke-linecap="square" stroke-width="1"></path>
                    </g>
                    </g>
                </g>
                </svg>
        </button>
        <!-- page title -->
        <div class="title">
            <span>바코드리딩</span>
        </div>
    </header>


    <!-- 브랜드 메뉴 -->
    <section id="barcode">
        <div class="container">
            <h2>
                본 화면을<br>
                직원에게 보여주세요.
            </h2>
            <figure>
                <img src="/user/img/img_barcode.png" alt="">
            </figure>
            <a href="#!" class="closeup_btn">확대하기</a>
            <!-- 22.03.16 추가 -->
            <a href="#!" class="close_btn">
                <span></span>
                <span></span>
            </a>
        </div>
    </section>



</body>

@include('user.footer')

</body>
</html>