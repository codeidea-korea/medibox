<?php
$page_title = '정산 내역';
include_once('header.php');
?>

<section class="container">
	<div class="page-title"><?=$page_title?></div>
	
	<form name="" action="" method="post">
	<div class="data-search-wrap">
		<div class="data-sel" style="width:100%;">
			매장&nbsp;&nbsp;&nbsp;&nbsp;<select class="default">
				<option>발몽스파</option>
				<option>바라는네일</option>
				<option>포레스타 블랙</option>
				<option>딥포커스</option>
				<option>미니쉬 스파</option>
				<option>미니쉬 도수</option>
			</select>		
		</div>	
		<div class="data-sel" style="width:100%;">
			기간&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="" value="" class="span130 datepicker" data-label="날짜" placeholder="전화번호/이름">&nbsp;&nbsp;~
			<input type="text" name="" value="" class="span130 datepicker" data-label="날짜" placeholder="전화번호/이름">
			<a href="#" class="btn gray">검색</a>				
		</div>		
	</div>
	</form>

	<div class="tbl-basic cell td-h4 mt10">
		<div class="tbl-header">
			<div class="caption"><span style="font-weight:bold;font-size:16px;">매장정산내역</span>&nbsp;&nbsp;총 <b>11</b>개 글이 있습니다</div>
			<div class="rightSet"><a href="#" class="btn green small icon-excel">엑셀 다운로드</a></div>
		</div>
		<table>
			<colgroup>
				<col width="80">
				<col width="90">
				<col width="60">
				<col width="140">
				<col width="60">

				<col width="140">
				<col width="160">
				<col width="60">
			</colgroup>
			<thead>
				<tr>
					<th><a href="#" class="sort">회원번호</a></th>
					<th><a href="#" class="sort asc">종류</a></th>
					<th><a href="#" class="sort desc">사용유형</a></th>
					<th><a href="#" class="sort desc">결제매장</a></th>
					<th><a href="#" class="sort desc">결제자</a></th>

					<th><a href="#" class="sort desc">사용대장</a></th>
					<th><a href="#" class="sort desc">서비스명</a></th>
					<th><a href="#" class="sort desc">예약/취소일</a></th>
					<th><a href="#" class="sort desc">결제/환불일</a></th>
					<th><a href="#" class="sort desc">금액</a></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>1</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>2</td>
					<td>미니쉬 라운지 통합 정액권</td>
					<td>예약취소</td>
					<td></td>
					<td></td>
					<td>미니쉬도수</td>
					<td>SPECIAL-웨딩 관리</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>3</td>
					<td>미니쉬 라운지 통합 정액권</td>
					<td>예약</td>
					<td></td>
					<td></td>
					<td>미니쉬도수</td>
					<td>SPECIAL-웨딩 관리</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>- 100,000 P</td>
				</tr>
				<tr>
					<td>4</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>5</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>6</td>
					<td>미니쉬 라운지 통합 정액권</td>
					<td>예약</td>
					<td></td>
					<td></td>
					<td>미니쉬도수</td>
					<td>SPECIAL-웨딩 관리</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>- 100,000 P</td>
				</tr>
				<tr>
					<td>7</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>8</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>9</td>
					<td>미니쉬 라운지 통합 정액권</td>
					<td>예약</td>
					<td></td>
					<td></td>
					<td>미니쉬도수</td>
					<td>SPECIAL-웨딩 관리</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>- 100,000 P</td>
				</tr>
				<tr>
					<td>10</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
				<tr>
					<td>11</td>
					<td>포인트</td>
					<td>충전</td>
					<td>미니쉬도수</td>
					<td>김수민</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="date">2020-01-23 00:00:00</td>
					<td>+ 100,000 P</td>
				</tr>
			</tbody>			
		</table>	

		<nav class="pg_wrap">
			<a href="#" class="pg_btn first"></a>
			<a href="#" class="pg_btn prev"></a>
			<a href="#" class="pg_btn active">1</a>
			<a href="#" class="pg_btn">2</a>
			<a href="#" class="pg_btn">3</a>
			<a href="#" class="pg_btn">4</a>
			<a href="#" class="pg_btn">5</a>
			<a href="#" class="pg_btn">6</a>
			<a href="#" class="pg_btn">7</a>
			<a href="#" class="pg_btn">8</a>
			<a href="#" class="pg_btn">9</a>
			<a href="#" class="pg_btn">10</a>
			<a href="#" class="pg_btn next"></a>
			<a href="#" class="pg_btn last"></a>
		</nav>

		<div class="btnSet">
			<a href="#" class="btn large">회원등록</a>
		</div>
	</div>	
	
	<script>
	$(function() {
		$(document).on("click", ".add-list", function() {
			add_list();
		});

		$(document).on("click", ".del-list", function() {
			if(!confirm("선택하신 OOO이 삭제됩니다. 계속하시겠습니까?"))
				return false;
			var $tr = $(this).closest("tr");
			$tr.remove();        
		});
	});	

	function add_list() {
		var $resident_list = $("#resident_list");
		var list = '<tr>';
		list += '<td><label class="checkbox-wrap"><input type="checkbox" name="" /><span></span></label></td>';
		list += '<td>';
		list += '<select class="span">';
		list += '<option>분류A</option>';
		list += '<option>분류B</option>';
		list += '<option>분류C</option>';
		list += '<option>분류D</option>';
		list += '</select>';
		list += '</td>';
		list += '<td><input type="text" name="" value="" class="span" placeholder=""></td>';
		list += '<td><input type="text" name="" value="" class="phone span" placeholder=""></td>';
		list += '<td class="cell-red">미가입</td>';
		list += '<td>-</td>';
		list += '<td class="date">-</td>';
		list += '<td><span class="btn small gray del-list">삭제</span></td>';
		list += '</tr>';
		var $tr_last = null;
		var $tr_last = $resident_list.find("tr:last");
		$tr_last.after(list);
		$('select').selectpicker('refresh');
	}
	</script>

</section>

<?php include_once('footer.php'); ?>