
@include('user.header2')
    
    <!-- header -->
    <header id="header">
        <!-- 뒤로가기 버튼 -->
        <button class="back" onclick="history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24.705" height="24" viewBox="0 0 24.705 24">
                <g id="back_arrow" transform="translate(-22.295 -60)">
                    <rect id="사각형_207" data-name="사각형 207" width="24" height="24" transform="translate(23 60)"
                        fill="none" />
                    <g id="그룹_389" data-name="그룹 389" transform="translate(-0.231)">
                        <g id="그룹_388" data-name="그룹 388">
                            <line id="선_29" data-name="선 29" x2="22.655" transform="translate(23.845 72)" fill="none"
                                stroke="#1d1d1b" stroke-miterlimit="10" stroke-width="1" />
                            <path id="패스_174" data-name="패스 174" d="M3382.394,1143.563l-7.163,6.331"
                                transform="translate(-3352 -1077.894)" fill="none" stroke="#000" stroke-linecap="square"
                                stroke-width="1" />
                            <path id="패스_175" data-name="패스 175" d="M3375.231,1143.563l7.163,6.331"
                                transform="translate(-3352 -1071.563)" fill="none" stroke="#000" stroke-linecap="square"
                                stroke-width="1" />
                        </g>
                    </g>
                </g>
            </svg>
        </button>        
        <!-- page title -->
        <div class="title">
            <span>도움말</span>
        </div>
    </header>
    <!-- 이벤트 상세 페이지-->
    <section id="event_detail">
        <div class="container">
            <h3 id="title">건강한 치아성형 미니쉬 리얼 모델 모집!</h3>
            <span id="createDt">이벤트기간 : 11.01 ~ 11.27</span>
            <p id="contents">
                안녕하세요 미니쉬치과병원입니다. ^^<br>
                이번 달부터 진행되는 본원 진료 대기고객분들을 위한 체형교정 서비스를 안내해드립니다.<br>
                <br>
                저희 미니쉬가진료 중간에 생기는 대기 시간을 이용하여<br>
                고객분들의 지치고 힘든 몸에 휴식을 드리고자 합니다. 관절 전문 병원에서 근무하셨던 원내 물리치료사분이 50분 동안 고객님을 꼼꼼하고 세심하게 봐 드리며 집에 돌아가 혼자서도 직접할 수 있는 운동법들을 알려드립니다.<br>
                <br>
                건강은 예방과 관리가 중요하기에<br>
                환자고객분의 치아 건강뿐만이 아니라 전신 건강을 위해<br>
                미니쉬치과병원은 끊임없이 노력합니다.<br>
                <br>
                프로그램<br>
                -거북목, 일자목 예방 및 관리<br>
                -목과 어깨 근육의 뭉침 관리<br>
                -허리 통증 예방 및 관리<br>
                -골반 비대칭 예방 및 관리<br>              
            </p>
        </div>
    </section>  

        @include('user.footer')

        <script>
            function getOne(){
                medibox.methods.contents.help.one({ id: {{$id}} }, {{$id}}, function(request, response){
                    console.log('output : ' + response);
                    if(!response.result){
                        alert(response.ment);
                        return false;
                    }

                    $('#title').text(response.data.title);
                    $('#createDt').text(response.data.create_dt);
                    $('#contents').text(response.data.contents);
                }, function(e){
                    console.log(e);
                    alert('서버 통신 에러');
                });
            }
            $(document).ready(function(){
                getOne();
            });
        </script>
</body>
</html>