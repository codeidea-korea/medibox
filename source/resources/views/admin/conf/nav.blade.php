
@php 
$navData = [];
$navData['회원관리'] = ['회원관리', '회원등록', '회원수정'];


$navData['제휴사 관리'] = ['제휴사 정보', '매장 정보'];
$navData['제휴사 정보'] = ['제휴사 정보', '제휴사 등록', '제휴사 수정'];
$navData['매장 정보'] = ['매장 정보', '매장 등록', '매장 수정'];

$navData['콘텐츠관리'] = ['공지사항 (유저/APP)', '공지사항 (파트너)', '자주 묻는 질문', '도움말', '이용약관', '개인정보약관', '메인화면 디자인 선택'];

$navData['공지사항 (유저/APP)'] = ['공지사항 (유저/APP)', '공지사항 (유저/APP) 등록', '공지사항 (유저/APP) 수정'];
$navData['공지사항 (파트너)'] = ['공지사항 (파트너)', '공지사항 (파트너) 등록', '공지사항 (파트너) 수정'];
$navData['자주 묻는 질문'] = ['자주 묻는 질문', '자주 묻는 질문 등록', '자주 묻는 질문 수정'];
$navData['도움말'] = ['도움말', '도움말 등록', '도움말 수정'];
$navData['이용약관'] = ['이용약관', '이용약관 등록', '이용약관 수정'];
$navData['개인정보약관'] = ['개인정보약관', '개인정보약관 등록', '개인정보약관 수정'];
$navData['메인화면 디자인 선택'] = ['메인화면 디자인 선택'];

$navData['예약 관리'] = ['예약 현황', '예약 내역', '예약 환경설정'];
$navData['예약 환경설정'] = ['예약가능시간 관리', '디자이너 정보', '서비스 정보'];

$navData['예약가능시간 관리'] = ['예약가능시간 관리'];
$navData['디자이너 정보'] = ['디자이너 등록', '디자이너 수정', '디자이너 정보'];
$navData['서비스 정보'] = ['서비스 등록', '서비스 수정', '서비스 정보'];

$navData['서비스/바우처/쿠폰 관리'] = ['이벤트 쿠폰 관리', '쿠폰 관리', '포인트 관리', '정액권 관리', '패키지 관리', '멤버쉽 관리', '바우처 관리'];

$navData['이벤트 쿠폰 관리'] = ['이벤트 쿠폰 관리', '이벤트 쿠폰 등록', '이벤트 쿠폰 수정', '이벤트 쿠폰 유저별 발급내역'];
$navData['쿠폰 관리'] = ['쿠폰 관리', '쿠폰 등록', '쿠폰 수정', '쿠폰 이용 현황', '쿠폰 이용 현황 상세'];
$navData['포인트 관리'] = ['포인트 사용내역', '포인트 자동 적립관리'];
$navData['정액권 관리'] = ['정액권 관리', '정액권 등록', '정액권 수정'];
$navData['패키지 관리'] = ['패키지 관리', '패키지 등록', '패키지 수정'];
$navData['멤버쉽 관리'] = ['멤버쉽 관리', '멤버쉽 등록', '멤버쉽 수정', '멤버쉽 사용내역'];
$navData['바우처 관리'] = ['바우처 관리', '바우처 등록', '바우처 수정'];

$navData['결제 사용내역'] = ['포인트 사용내역', '쿠폰/바우처/멤버쉽 사용내역'];
$navData['포인트 사용내역'] = ['포인트 사용내역'];
$navData['쿠폰/바우처/멤버쉽 사용내역'] = ['쿠폰/바우처/멤버쉽 사용내역'];

$navData['레벨 권한 설정'] = ['레벨 권한 설정', '관리자 아이디 권한 등록', '관리자 아이디 권한 수정'];
$navData['관리자 history'] = ['관리자 history'];

@endphp

<header id="header">
	<div class="header_container">
		<!--<div class="logo bg"><a href="./index.php">마이 <span>관리자</span></a></div> (텍스트만..)-->
		<div class="logo"><a href="/admin/members"><img src="{{ asset('adm/img/medibox/logo.png') }}"><br/><small>관리자 페이지</small></a></div>
		<nav id="nav">
			<ul id="nav_ul">
				<li class=""><a href="/admin/members" class="mont">홈</a></li>
				<li class="@if (in_array($page_title, $navData['제휴사 관리'])) active @endif">
					<a href="#" class="mont">제휴사 관리</a>
					<ul>
						@php
						if(session()->get('admin_type') != 'S') {
						@endphp
						<li class="@if (in_array($page_title, $navData['제휴사 정보'])) active @endif"><a href="/admin/partners">제휴사 정보</a></li>
						@php
						}
						@endphp
						<li class="@if (in_array($page_title, $navData['매장 정보'])) active @endif"><a href="/admin/stores">매장 정보</a></li>
					</ul>
				</li>
				<li class="@if (in_array($page_title, $navData['예약 관리'])) active @endif">
					<a href="#" class="mont">예약 관리</a>
					<ul>
						<li class="@if ($page_title == '예약 현황') active @endif"><a href="/admin/reservations/condition">예약 현황</a></li>
						<li class="@if ($page_title == '예약 내역') active @endif"><a href="/admin/reservations">예약 내역</a></li>
						<li class="@if (in_array($page_title, $navData['예약 환경설정'])) active @endif">
							<a href="#" class="mont">예약 환경설정</a>
							<ul>
								<li class="@if (in_array($page_title, $navData['예약가능시간 관리'])) active @endif"><a href="/admin/business-hours">(매장) 예약가능시간 관리</a></li>
								<li class="@if (in_array($page_title, $navData['디자이너 정보'])) active @endif"><a href="/admin/managers">(매장) 디자이너 관리</a></li>
								<li class="@if (in_array($page_title, $navData['서비스 정보'])) active @endif"><a href="/admin/services">(매장) 서비스 관리</a></li>
							</ul>
						</li>
					</ul>
				</li>
				@php
				if(session()->get('admin_type') == 'A' || session()->get('admin_type') == 'B') {
				@endphp
				<li class="@if (in_array($page_title, $navData['서비스/바우처/쿠폰 관리'])) active @endif">
					<a href="#" class="mont">서비스/바우처/쿠폰 관리</a>
					<ul>
						<li class="@if (in_array($page_title, $navData['이벤트 쿠폰 관리'])) active @endif"><a href="/admin/service/event-coupon">이벤트 쿠폰 관리</a></li>
						<li class="@if (in_array($page_title, $navData['쿠폰 관리'])) active @endif"><a href="/admin/service/coupon">쿠폰 관리</a></li>
						<li class="@if (in_array($page_title, $navData['포인트 관리'])) active @endif"><a href="/admin/point/history">포인트 관리</a></li>
						<li class="@if (in_array($page_title, $navData['정액권 관리'])) active @endif"><a href="/admin/service/tickets">정액권 관리</a></li>
						<li class="@if (in_array($page_title, $navData['패키지 관리'])) active @endif"><a href="/admin/service/packages">패키지 관리</a></li>
						<li class="@if (in_array($page_title, $navData['멤버쉽 관리'])) active @endif"><a href="/admin/service/membership">멤버쉽 관리</a></li>
						<li class="@if (in_array($page_title, $navData['바우처 관리'])) active @endif"><a href="/admin/service/vouchers">바우처 관리</a></li>
					</ul>
				</li>
				@php
				}
				@endphp
				<li class="@if (in_array($page_title, $navData['회원관리'])) active @endif">
					<a href="/admin/members" class="mont">회원관리</a>
					<ul>
						<li class="@if ($page_title == '회원관리' || $page_title == '회원수정') active @endif"><a href="/admin/members">회원관리</a></li>
						<li class="@if ($page_title == '회원등록') active @endif"><a href="/admin/members/0">회원등록</a></li>
						<li style="display:none;" class="@if ($page_title == '회원수정') active @endif"><a href="#">회원수정</a></li>
					</ul>
				</li>
				<li class="@if (in_array($page_title, $navData['결제 사용내역'])) active @endif">
					<a href="#" class="mont">결제 사용내역</a>
					<ul>
						<li class="@if (in_array($page_title, $navData['포인트 사용내역'])) active @endif"><a href="/admin/payments/point">포인트 사용내역</a></li>
						<li class="@if (in_array($page_title, $navData['쿠폰/바우처/멤버쉽 사용내역'])) active @endif"><a href="/admin/payments/membership">쿠폰/바우처/멤버쉽 사용내역</a></li>
					</ul>
				</li>
				@php
				if(session()->get('admin_type') == 'A' || session()->get('admin_type') == 'B') {
				@endphp
				<li class="@if (in_array($page_title, $navData['레벨 권한 설정'])) active @endif">
					<a href="/admin/level" class="mont">레벨 권한 설정</a>
				</li>
				<li class="@if (in_array($page_title, $navData['관리자 history'])) active @endif">
					<a href="/admin/history/action" class="mont">관리자 history</a>
				</li>
				<li class="@if (in_array($page_title, $navData['콘텐츠관리'])) active @endif">
					<a href="#" class="mont">콘텐츠관리</a>
					<ul>
						<li class="@if (in_array($page_title, $navData['공지사항 (유저/APP)'])) active @endif"><a href="/admin/contents/notices">공지사항 (유저/APP)</a></li>
						<li class="@if (in_array($page_title, $navData['공지사항 (파트너)'])) active @endif"><a href="/admin/contents/notices-partner">공지사항 (파트너)</a></li>
						<li class="@if (in_array($page_title, $navData['자주 묻는 질문'])) active @endif"><a href="/admin/contents/faqs">자주 묻는 질문</a></li>
						<li class="@if (in_array($page_title, $navData['도움말'])) active @endif"><a href="/admin/contents/helps">도움말</a></li>
						<li class="@if (in_array($page_title, $navData['이용약관'])) active @endif"><a href="/admin/contents/usages">이용약관</a></li>
						<li class="@if (in_array($page_title, $navData['개인정보약관'])) active @endif"><a href="/admin/contents/privacies">개인정보약관</a></li>

						<li class="@if (in_array($page_title, $navData['메인화면 디자인 선택'])) active @endif"><a href="/admin/contents/template">메인화면 디자인 선택</a></li>
					</ul>
				</li>
				@php
				}
				@endphp
			</ul>
		</nav>
	</div>
</header>
