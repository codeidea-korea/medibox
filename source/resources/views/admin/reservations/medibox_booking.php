<?php
$page_title = '예약현황';
include_once('header.php');
?>


<section id="background" class="container no-footer">

	<div class="section-header">
		예약현황
		<select class="small right">
			<option>제휴사 전체 (슈퍼어드민만 노출)</option>
			<option>OOO OOOOOO</option>
			<option>OOO OOOOOO</option>
			<option>OOO OOOOOO</option>
		</select>
	</div>

	<div id="bookingContainer">
		<section class="topCon">
			<div class="dateSet">
				<button class="prev"></button>
				<input type="text" id="current_date" class="datepick">			
				<button class="next"></button>
				<label for="current_date" class="calendar"></label>
			</div>
			<div class="btnSet">
				<a href="#" class="btn-list">예약내역</a>
				<a href="#" class="btn-write">예약등록</a>
			</div>
		</section>
		<section class="tabsCate">
			<a href="#" class="active">전체</a>
			<a href="#" class="">바라는 네일</a>
			<a href="#" class="">딥포커스 검안소</a>
			<a href="#" class="">포레스타 블랙</a>
			<a href="#" class="">미니쉬 스파</a>
			<a href="#" class="">발몽 스파</a>
			<a href="#" class="">미니쉬 도수</a>
		</section>
		<section class="bodyCon">
			<div class="leftCon">
				<a href="#" class="btn-day">일<br>3/6</a>
				<a href="#" class="btn-day">월<br>3/7</a>
				<a href="#" class="btn-day active">화<br>3/8</a>
				<a href="#" class="btn-day">수<br>3/9</a>
				<a href="#" class="btn-day">목<br>3/10</a>
				<a href="#" class="btn-day">금<br>3/11</a>
				<a href="#" class="btn-day">토<br>3/12</a>
				<div class="navigation">
					<button class="prev"></button>
					<button class="next"></button>
				</div>
				<a href="#" class="btn-setting">설정</a>
			</div>

			<div class="tableChart">
				
				<div class="leftContainer">
					<div class="col">
						<span class="cell">10:10</span>
						<span class="cell">10:20</span>
						<span class="cell">10:30</span>
						<span class="cell">10:40</span>
						<span class="cell">10:50</span>
						<span class="cell">11:00</span>
						<span class="cell">11:10</span>
						<span class="cell">11:20</span>
						<span class="cell">11:30</span>
						<span class="cell">11:40</span>
						<span class="cell">11:50</span>
						<span class="cell">12:00</span>
						<span class="cell">12:10</span>
						<span class="cell">12:20</span>
						<span class="cell">12:30</span>
						<span class="cell">12:40</span>
						<span class="cell">12:50</span>
						<span class="cell">13:00</span>
						<span class="cell">13:10</span>
						<span class="cell">13:20</span>
					</div>
				</div>

				<div class="bodyContainer">
					<div class="head">
						<div class="inner">
							<div class="row">
								<span class="cell">테라피리스트</span>
								<span class="cell">테라피리스트</span>
								<span class="cell">원장</span>
								<span class="cell">부원장</span>
								<span class="cell">디자이너</span>
								<span class="cell">매니저</span>
								<span class="cell">옵티션1</span>
								<span class="cell">옵티션2</span>
								<span class="cell">옵티션3</span>
								<span class="cell">옵티션4</span>
								<span class="cell">옵티션5</span>
								<span class="cell">옵티션6</span>
								<span class="cell">옵티션7</span>
								<span class="cell">옵티션8</span>
								<span class="cell">옵티션9</span>
								<span class="cell">옵티션10</span>
							</div>
						</div>
					</div>
				
					<div class="body">					
						<div class="inner">
							<div class="col" data-alt="테라피리스트">
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="테라피리스트">
								<span class="cell label-2"></span>
								<span class="cell label-2"></span>
								<span class="cell label-2"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="원장">
								<span class="cell label-2"></span>
								<span class="cell label-2"></span>
								<span class="cell label-2"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell label-5"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="부원장">
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell label-6"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="디자이너">
								<span class="cell label-2"></span>
								<span class="cell label-2"></span>
								<span class="cell label-4"></span>
								<span class="cell label-4"></span>
								<span class="cell label-4"></span>
								<span class="cell label-4"></span>
								<span class="cell label-4"></span>
								<span class="cell label-4"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="매니저">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell label-3"></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션1">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션2">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션3">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션4">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션5">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션6">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션7">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션8">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션9">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							<div class="col" data-alt="옵티션10">
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
								<span class="cell "></span>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<div class="labelSet">
			<span class="label-1">예약가능</span>
			<span class="label-2">예약불가</span>
			<span class="label-3">예약완료</span>
			<span class="label-4">예약불이행</span>
			<span class="label-5">고객입장</span>
			<span class="label-6">서비스완료</span>
		</div>
	</div>
	
<script>
//date
$('.datepick').each(function() {
	$(this).datepicker({
		language: 'ko-KR',
		autoPick: true,
		autoHide: true,
		format: 'yyyy년 m월 d 일'
	}).on('change', function(e) {
		var current_date = $('.datepick').val();
		var week = $(this).datepicker('getDayName');
		$(this).val(current_date + ' (' + week + ')');
	});
	var current_date = $('.datepick').val();
	var week = $(this).datepicker('getDayName');
	$(this).val(current_date + ' (' + week + ')');
});

$('.head .row').each(function() {
	var cell_width = 136;
	var row_count = $(this).children('.cell').length;
	$(this).parent('.inner').css({'width':cell_width*row_count+6});
	$('.body .inner').css({'width':cell_width*row_count});
});
$(".tableChart .body").scroll(function () {
    $(".leftContainer").scrollTop($(this).scrollTop());
    $(".tableChart .head").scrollLeft($(this).scrollLeft());
});
$(".leftContainer").scroll(function () {
    $(".tableChart .body").scrollTop($(this).scrollTop());
});

var layer_select3 = '<ul class="layerSelect">';
layer_select3 += '<li><a href="#" class="active">예약완료</a></li>';
layer_select3 += '<li><a href="#">고객입장</a></li>';
layer_select3 += '<li><a href="#">예약수정</a></li>';
layer_select3 += '<li><a href="#">예약취소</a></li>';
layer_select3 += '<li><a href="#">예약불이행</a></li>';
layer_select3 += '<li><a href="#">고객정보</a></li>';
layer_select3 += '</ul>';

var layer_select4 = '<ul class="layerSelect">';
layer_select4 += '<li><a href="#" class="active">고객입장</a></li>';
layer_select4 += '<li><a href="#">서비스완료</a></li>';
layer_select4 += '<li><a href="#">예약수정</a></li>';
layer_select4 += '<li><a href="#">예약취소</a></li>';
layer_select4 += '<li><a href="#">고객정보</a></li>';
layer_select4 += '</ul>';

var layer_select5 = '<ul class="layerSelect">';
layer_select5 += '<li><a href="#" class="active">서비스완료</a></li>';
layer_select5 += '<li><a href="#">예약수정</a></li>';
layer_select5 += '<li><a href="#">완료취소</a></li>';
layer_select5 += '<li><a href="#">고객정보</a></li>';
layer_select5 += '</ul>';

var layer_select6 = '<ul class="layerSelect">';
layer_select6 += '<li><a href="#" class="active">예약불이행</a></li>';
layer_select6 += '<li><a href="#">불이행취소</a></li>';
layer_select6 += '<li><a href="#">고객정보</a></li>';
layer_select6 += '</ul>';


$('html').click(function(e) {
	if(!$(e.target).hasClass("cell")) {
		$('.cell .layerSelect').remove();
	}
});
$('.tableChart .body .cell').click(function() {
	$('.cell .layerSelect').remove();
	
	if($(this).hasClass("label-3")) {
		$(this).html(layer_select3);
	} else if($(this).hasClass("label-4")) {
		$(this).html(layer_select4);
	} else if($(this).hasClass("label-5")) {
		$(this).html(layer_select5);
	} else if($(this).hasClass("label-6")) {
		$(this).html(layer_select6);
	}
});

</script>

</section>



<?php include_once('footer.php'); ?>