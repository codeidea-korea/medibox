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
<link rel="stylesheet" href="{{ asset('adm/css/style.css?v=202207092200') }}">
<script type="text/javascript" src="{{ asset('adm/js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/animation/easing.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/dropdown.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/bootstrap-select/bootstrap.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('adm/js/form/bootstrap-select/bootstrap-select.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('adm/js/form/datepicker/datepicker.js?v=20220528') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/datepicker/datepicker.ko-KR.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/myform.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/myScript.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/medibox-adm-apis.js') }}?v=202207200120"></script>
</head>
<body>

@include('admin.conf.nav')

<script>
function logout(){
	localStorage.clear();

	var menu = '관리자 화면 상단';
	var action = '로그 아웃';

	$.ajax({
		url: '/api/admin/history/action'
		, data: JSON.stringify({
			admin_seqno: admin_seqno,
			admin_id: admin_id,
			menu: menu,
			action: action,
			params: " ",
		})
		, type: 'POST'
		, async: false
		, contentType: 'application/json'
		, cache: false
		, timeout: 20000
		, success: function(response){ 
			console.log(response); 
		}, error: function(e, xpr, mm){ 
			console.log(e); 
		}
	});
	location.href = '/admin/logout/proccess';
}
function wait(){
	alert('준비중입니다.');
}
var admin_seqno = "{{ session()->get('admin_seqno') }}";
var admin_id = "{{ session()->get('admin_id') }}";

</script>

<div id="wrapper">
	
	<div id="topContainer">
		<div class="loaction"></div>
		<ul class="gbMenu">
			<li><a href="#" onclick="logout()">로그아웃</a></li>
		</ul>
	</div>