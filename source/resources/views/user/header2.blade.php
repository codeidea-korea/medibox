<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medibox</title>

    <link rel="stylesheet" href="{{ asset('user/css/common.css') }}?v=202203171921">
    <link rel="stylesheet" href="{{ asset('user/css/jquery-ui.min.css') }}?v=202204011821">
    <link rel="stylesheet" href="{{ asset('user/css/medibox.css') }}?v=202204011821">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}?v=202203171921">
    <script src="{{ asset('user/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery-ui.min.js') }}"></script>    
    <script src="{{ asset('user/js/slick.min.js') }}?v=202203171921"></script>
    <script src="{{ asset('user/js/tabmenu.js') }}?v=202203171921"></script>
    <script src="{{ asset('user/js/medibox.js') }}?v=202204011421"></script>
    <script src="{{ asset('user/js/medibox-apis.js') }}?v=202205062259"></script>
    <script src="{{ asset('user/js/datepicker.js') }}?v=202205062259"></script>
    
    <link rel="stylesheet" href="{{ asset('user/css/footbar.css') }}?v=202203231321">

</head>
<body>

@if(Session::has('error'))
	<script >
		$(document).ready(function(){
		  localStorage.clear();
      $('#popup01').addClass('on');
    });
		{{ session()->forget('error') }}
// location.href = '/user/login';
	</script>
  @endif
  
    <header id="header">
        <!-- page title -->
        <div class="title">
            <h2 class="brand_title">MEDI BOX</h2>
            <!-- 바코드결제링크 아이콘 -->
            <a href="/user/barcode" class="pay_icon">
                <img src="/user/img/icon_barcode.svg" alt="">
            </a>
        </div>
    </header>

    <script>
function wait(){
    alert('준비중입니다.');
}
    </script>
