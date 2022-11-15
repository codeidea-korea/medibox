@include('user.header')

<form id="lgnFrm" method="post" action="/user/sns-login/proccess">
	{{ csrf_field() }}
	<input type="hidden" name="id" id="id">
	<input type="hidden" name="type" id="type" value="naver">
</form>
<script>
var naver_id_login = new naver_id_login("w6z6OE_m70O7AnhQJXAb", "https://techmedibox.com/login/oauth/naver");
if(naver_id_login) {
    console.log(naver_id_login.oauthParams.access_token);
    naver_id_login.get_naver_userprofile("naverSignInCallback()");
}

function naverSignInCallback() {
//  alert(naver_id_login.getProfileData('email'));
//  alert(naver_id_login.getProfileData('nickname'));
//  alert(naver_id_login.getProfileData('age'));

	console.log(naver_id_login);

	var authId = naver_id_login.getProfileData('email');
	// sns_google <-- 존재 확인, 없으면 가입. SNS 연동은 별도 등록 과정 필요.
	$('#id').val(authId);
	$('#lgnFrm').submit();
}

</script>

@include('user.footer')