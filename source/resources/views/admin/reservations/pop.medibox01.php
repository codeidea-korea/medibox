<?php
include_once('header.php');
?>


<section class="container background" style="display:flex;align-items:center;justify-content:center;height:900px;">
	내용없음	
</section>


<div class="layer-popup">
	<button class="pop-closer"></button>

	<div class="popContainer">
		<div class="pop-inner" style="width:1200px;">
			<header class="pop-header">
				예약수정/삭제2
			</header>
			<div class="wr-wrap line label130 padding10">
				<div class="wr-list" style="width:50%;float:left;">
					<div class="wr-list-label ">
						<select data-style="">
							<option data-subtext="">전화번호</option>
							<option>이름</option>
						</select>
					</div>
					<div class="wr-list-con">			
						<input type="text" name="" value="" required class="span" style="width:160px;">		
						<a href="#" class="btn large blue span100">조회</a>
						<a href="#" class="btn large blue span100">고객등록</a>
					</div>
					
					<div style="width:100%;clear:both;height:5px;"></div>
	
					<form name="fboardlist" action="" method="post">
					<div class="tbl-basic cell td-h1">
						<!-- <div class="tbl-header">
							<div class="caption">총 000건</div>
						</div> -->
						<table id="resident_list">
							<colgroup>
								<col width="60">
								<col>
								<col width="180">
								<col width="180">
							</colgroup>
							<thead>
								<tr>
									<th>이름</th>
									<th>고객번호</th>
									<th>휴대폰</th>
									<th>정보</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>김메디</td>
									<td>1234565213</td>
									<td>010-1123-4123</td>
									<td><a href="#" class="btn large blue span100">고객정보</a></td>
								</tr>
								<tr>
							</tbody>
							</table>
					</div>
					</form>	
				</div>		
				<div class="wr-list" style="width:50%;float:left;">	
						<form name="fboardlist" action="" method="post">
						<div class="tbl-basic cell td-h1">
							<table id="resident_list">
								<colgroup>
									<col width="120">
									<col width="120">
									<col width="120">
									<col width="120">
								</colgroup>
								<tbody>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">아이콘표시</td>
										<td  style="border:1px solid #000;" colspan="3">
											<label class="checkbox-wrap"><input type="checkbox" name="" value="" checked  /><span></span>중요고객★</label>
											<label class="checkbox-wrap"><input type="checkbox" name="" value=""  /><span></span>전화☏</label>
											<label class="checkbox-wrap"><input type="checkbox" name="" value=""  /><span></span>색상선택</label>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">제휴사</td>
										<td  style="border:1px solid #000;">
											<select data-style="">
												<option data-subtext="">제휴사</option>
												<option>제휴사A</option>
											</select>
										</td>
										<td  style="border:1px solid #000;">매장</td>
										<td  style="border:1px solid #000;">
											<select data-style="">
												<option data-subtext="">바라는 네일</option>
												<option data-subtext="">바라는 네일</option>
												<option data-subtext="">바라는 네일</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">디자이너</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select data-style="">
												<option data-subtext="">원장 A</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약일시</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<label class="inp-wrap left-label"><span class="label">날짜</span><input type="text" name="" value="" class="span130 datepicker"></label>
											<select data-style="">
												<option data-subtext="">12시</option>
												<option data-subtext="">12시</option>
											</select>
											<select data-style="">
												<option data-subtext="">30분</option>
												<option data-subtext="">30분</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약항목</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select data-style="">
												<option data-subtext="">컷</option>
												<option>컷</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">소요시간</td>
										<td  style="border:1px solid #000;text-align:left;" colspan="3">
											<select data-style="">
												<option data-subtext="">1시간 50분</option>
												<option>1시간 50분</option>
											</select>
										</td>
									</tr>
									<tr style="border:1px solid #000;">
										<td  style="border:1px solid #000;">예약메모</td>
										<td  style="border:1px solid #000;" colspan="3">
											<textarea name="" class="mini autoSize" placeholder="메모"></textarea>
										</td>
									</tr>
								</tbody>
								</table>
						</div>
						</form>
				</div>
			</div>	
			<div class="btnSet">
				<a href="#" class="btn large blue span120">수정/삭제</a>
				<a href="#" class="btn large gray popClose">취소</a>
			</div>
		</div>
	</div>

	<div class="pop-bg"></div>
</div>


<script>
$('body, html').css('overflow', 'hidden'); //팝업열릴때 body, html에 스크롤을 방지한다. 팝업을 닫을때 해당 스타일삭제..
</script>

<?php include_once('footer.php'); ?>