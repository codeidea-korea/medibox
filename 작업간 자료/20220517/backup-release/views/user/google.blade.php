@include('user.header')
<!--
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="212708314746-p8sopoc8o3u8utf0sam77nscdf0krqch.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
-->
<form id="lgnFrm" method="post" action="/user/sns-login/proccess">
	{{ csrf_field() }}
	<input type="hidden" name="id" id="id">
	<input type="hidden" name="type" id="type" value="google">
</form>
<script>

setTimeout(() => {
    gapi.load('auth2', function() {
        var gauth = gapi.auth2.init({
            client_id: '473022129853-9lub1aopq2814f7o4k31ek2t9qc81c5u.apps.googleusercontent.com'
        });

        gauth.then(function (){
            var isLogined = gauth.isSignedIn.get();

            if(!isLogined) {
                alert('로그인에 실패하였습니다. 최신 사파리 브라우저(iOS, Mac)인 경우에는 타사 쿠키 허용을 해야만 구글 로그인이 가능합니다.');
                location.href='/user/login?set=test1';
                return false;
            }

            var authId = gauth.currentUser.get().getBasicProfile().getEmail();

            if(!authId || (authId+'').length < 2) {
                alert('로그인에 실패하였습니다. [프로필 로드 실패]');
                alert(gauth.currentUser.get().getBasicProfile());
                location.href='/user/login?set=test1';
                return false;
            }
            $('#id').val(authId);
            $('#lgnFrm').submit();
        }, function (){
            if(!isLogined) {
                alert('로그인에 실패하였습니다. [gauth 초기화 오류]');
                location.href='/user/login?set=test1';
                return false;
            }
        });
    });
}, 300);

</script>

@include('user.footer')