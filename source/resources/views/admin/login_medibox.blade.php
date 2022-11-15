@include('admin.lib.commonlib')

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>메디박스 관리자</title>
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
<link rel="shortcut icon" href="img/favorite/favorite.ico" />
<link rel="stylesheet" href="{{ asset('adm/css/root.css') }}">
<link rel="stylesheet" href="{{ asset('adm/js/form/myform.css') }}">
<link rel="stylesheet" href="{{ asset('adm/css/styleDefault.css') }}">
<link rel="stylesheet" href="{{ asset('adm/css/style.css') }}">
<script type="text/javascript" src="{{ asset('adm/js/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/form/myform.js') }}"></script>
<script type="text/javascript" src="{{ asset('adm/js/myScript.js') }}"></script>
</head>
<body>


<section id="section-login" >	

	<div class="visual"style="background:#fee4e5;position:relative;display:flex;align-items:center;">		
		<img src="{{ asset('adm/img/medibox/login-bg.png') }}" style="position:absolute;bottom:0;left:0;">
	</div>

	<div style="flex:1;display:flex;padding-left:360px;background:#7fa6ff;">
		<div style="margin-top:280px;">
			<img src="{{ asset('adm/img/medibox/logo-w.png') }}">
			<p style="color:#7fa6ff;margin-top:20px;">
				<span class="h2" style="font-size:40px;font-weight:300;display:inline-block;background:#fff;line-height:1em;padding:3px 2px">특별한 당신을 위한</span><br>
				<span class="h2" style="font-size:56px;font-weight:400;display:inline-block;background:#fff;line-height:1em;padding:0 2px 1px 2px;margin-top:4px;">Heal Care</span>
			</p>
		</div>
	</div>

	<div class="login-wrap" style="position:absolute;top:100px;left:50%;z-index:5;display:block;width:480px;padding:70px;margin-left:-240px;text-align:center;background:#fff;border-radius:10px;box-shadow:0 12px 15px rgba(0,0,0,0.06);">
		<form name="#" id="lgnFrm" method="post" action="/admin/login/proccess">
			{{ csrf_field() }}
			<div class="title" style="font-size:20px;line-height:1.3em;margin-bottom:25px;">메디박스 제휴사<br/>로그인 페이지</div>
			<input type="text" name="id" id="login_id2" required class="large span" placeholder="아이디">
			<input type="password" name="pw" id="login_pw2" required class="large span" placeholder="비밀번호">
			<div class="tcenter">
				<a href="#" onclick="login()" class="btn login">로그인</a>
			</div>
			<div class="flex flex-middle mb40">
				<label class="checkbox-wrap" style="font-size:13px;font-weight:bold"><input type="checkbox" id="autologin" name="" value="" checked  /><span class="mr10"></span>로그인 유지</label>
				<a href="#" onclick="wait()" class="btn small gray" style="margin-left:auto">비밀번호 찾기</a>
			</div>
			<p class="help-block">
				아이디 및 비밀번호를 분실 하셨을 경우<br>
				메디박스로 연락해주시면 안내해 드리겠습니다.
			</p>
			<p class="mt20">
				메디박스 고객센터<br>
				<span style="font-weight:bold;font-size:1.3em">0000-0000</span>
			</p>
			<p class="mt20 color-blue">
				평일 오전 10시 ~ 오후 6시<br>
				(점심시간:오후 12시 30분 ~ 1시 30분)
			</p>
		</form>
	</div>

	@if(Session::has('error'))
	<script type="text/javascript" >
		localStorage.clear();
		alert('{{ session()->get('error') }}');
		{{ session()->forget('error') }}
	</script>
	Session::forget('error');
	@endif
</section>

	<script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('adm/js/medibox-adm-apis.js') }}?v=2022012918"></script>
    <script>
		function wait(){
			alert('준비중입니다.');
		}
        function checkValidation(){
            var id = document.querySelector('#login_id2').value;
            var pw = document.querySelector('#login_pw2').value;

            if(!id || id == '') {
                alert('올바른 아이디를 입력해주세요.');
                return false;
            }
            if(!pw || pw == '' || pw.length < 4) {
                alert('비밀번호를 입력해주세요.');
                return false;
			}

            return true;
        }
        function login(){
            if(!checkValidation()) {
                return false;
            }
			var isAutoLogin = $('#autologin').is(":checked");
			if(isAutoLogin){
				var id = document.querySelector('#login_id2').value;
				var pw = document.querySelector('#login_pw2').value;

				localStorage.setItem('medibox-adm-id', btoa(id));
				localStorage.setItem('medibox-adm-pw', btoa(pw));
			} else {
				localStorage.clear();
			}
			$('#lgnFrm').submit();
		}
		$(document).ready(function(){
			var id = localStorage.getItem('medibox-adm-id');
			var pw = localStorage.getItem('medibox-adm-pw');

			if(id && pw) {
				$('#login_id2').val(atob(id));
				$('#login_pw2').val(atob(pw));
				$('#lgnFrm').submit();
			}
		});
    </script>

</body>
</html>
