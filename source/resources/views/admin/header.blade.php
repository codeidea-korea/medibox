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
<script type="text/javascript" src="{{ asset('adm/js/medibox-adm-apis.js') }}?v=202203081025"></script>
</head>
<body>

<header id="header">
	<div class="header_container">
		<!--<div class="logo bg"><a href="./index.php">마이 <span>관리자</span></a></div> (텍스트만..)-->
		<div class="logo"><a href="/admin/members"><img src="{{ asset('adm/img/medibox/logo.png') }}"><br/><small>관리자 페이지</small></a></div>
		<nav id="nav">
			<ul id="nav_ul">
				<li class=""><a href="/admin/members" class="mont">홈</a></li>
				<li class="active">
					<a href="/admin/members" class="mont">회원관리</a>
					<ul>
						<li class="active"><a href="/admin/members">회원관리</a></li>
						<li class=""><a href="/admin/members/0">회원등록</a></li>
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