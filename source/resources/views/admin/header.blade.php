@include('admin.lib.commonlib')

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>메디박스</title>
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
<link rel="shortcut icon" href="{{ asset('adm/img/favorite/favorite.ico') }}">
<link rel="stylesheet" href="{{ asset('adm/css/root.css') }}">
<link rel="stylesheet" href="{{ asset('adm/js/magnific-popup/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('adm/js/form/datepicker/datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('adm/js/form/myform.css') }}">
<link rel="stylesheet" href="{{ asset('adm/js/form/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('adm/css/styleDefault.css') }}">
<link rel="stylesheet" href="{{ asset('adm/css/style.css') }}">
<script type="text/javascript" src="{{ asset('adm/js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/animation/easing.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/dropdown.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/bootstrap-select/bootstrap.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('adm/js/form/bootstrap-select/bootstrap-select.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('adm/js/form/datepicker/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/datepicker/datepicker.ko-KR.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/myform.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/myScript.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/medibox-adm-apis.js') }}?v=202205030459"></script>
</head>
<body>

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


@endphp

<header id="header">
	<div class="header_container">
		<!--<div class="logo bg"><a href="./index.php">마이 <span>관리자</span></a></div> (텍스트만..)-->
		<div class="logo"><a href="/admin/members"><img src="{{ asset('adm/img/medibox/logo.png') }}"><br/><small>관리자 페이지</small></a></div>
		<nav id="nav">
			<ul id="nav_ul">
				<li class=""><a href="/admin/members" class="mont">홈</a></li>
				<li class="@if (in_array($page_title, $navData['회원관리'])) active @endif">
					<a href="/admin/members" class="mont">회원관리</a>
					<ul>
						<li class="@if ($page_title == '회원관리' || $page_title == '회원수정') active @endif"><a href="/admin/members">회원관리</a></li>
						<li class="@if ($page_title == '회원등록') active @endif"><a href="/admin/members/0">회원등록</a></li>
						<li style="display:none;" class="@if ($page_title == '회원수정') active @endif"><a href="#">회원수정</a></li>
					</ul>
				</li>
				<li class="@if (in_array($page_title, $navData['제휴사 관리'])) active @endif">
					<a href="#" class="mont">제휴사 관리</a>
					<ul>
						<li class="@if (in_array($page_title, $navData['제휴사 정보'])) active @endif"><a href="/admin/partners">제휴사 정보</a></li>
						<li class="@if (in_array($page_title, $navData['매장 정보'])) active @endif"><a href="/admin/stores">매장 정보</a></li>
					</ul>
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
			</ul>
		</nav>
	</div>
</header>

<script>
function logout(){
	localStorage.clear();
	location.href = '/admin/logout/proccess';
}
</script>

<div id="wrapper">
	
	<div id="topContainer">
		<div class="loaction"></div>
		<ul class="gbMenu">
			<li><a href="#" onclick="logout()">로그아웃</a></li>
		</ul>
	</div>