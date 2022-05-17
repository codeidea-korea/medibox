@include('user.header')

@php
$code = $_GET['code'];

$client_id = 'd4aeeca0375caae66d2a2aa8bfa2efd9';
$client_secret = 'fdCGuzG5yfY6Ig2Q3bZEpn4nD20i0Ili';
$redirect_uri = 'https://techmedibox.com/login/oauth/kakao';

$data = sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s&client_secret=%s', $client_id, $redirect_uri, $code, $client_secret);

$url = 'https://kauth.kakao.com/oauth/token';
$header_data = array(
    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
);

$ch = curl_init($url);
curl_setopt_array($ch, array(
	CURLOPT_URL => $url
	, CURLOPT_SSL_VERIFYPEER => false
	, CURLOPT_SSLVERSION => 1
	, CURLOPT_POST => true
	, CURLOPT_POSTFIELDS => $data
	, CURLOPT_RETURNTRANSFER => true
	, CURLOPT_HEADER => false
));

$response = curl_exec($ch);
$result = json_decode($response);

curl_close($ch);

if(empty($result)){
	echo '<script>alert("토큰 발급이 거절되었습니다."); history.back();</script>';
	exit(0);
}
if(empty($result->access_token)){
	echo '<script>alert("토큰 발급이 거절되었습니다."); history.back();</script>';
	exit(0);
}

$access_token = $result->access_token;

$url = 'https://kapi.kakao.com/v2/user/me';
$header_data = array(
    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
	, 'Authorization: Bearer ' . $access_token
);

$ch = curl_init($url);
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => $header_data,
    CURLOPT_POSTFIELDS => []
));

$response = curl_exec($ch);
$result = json_decode($response);

echo '<script>console.log("'.$response.'");</script>';

curl_close($ch);

if(empty($result)){
	echo '<script>alert("사용할 수 없는 토큰입니다."); history.back();</script>';
	exit(0);
}
if(empty($result->kakao_account->email)){
	echo '<script>alert("사용할 수 없는 토큰입니다."); history.back();</script>';
	exit(0);
}

@endphp

<form id="lgnFrm" method="post" action="/user/sns-login/proccess">
	{{ csrf_field() }}
	<input type="hidden" name="id" id="id">
	<input type="hidden" name="type" id="type" value="kakao">
</form>
<script>
@php
if(empty($response)) {
	echo 'history.back();';
	exit(0);
}
@endphp


@php
echo 'var authId = "'.$result->kakao_account->email.'";';
@endphp

$('#id').val(authId);
$('#lgnFrm').submit();
</script>

@include('user.footer')