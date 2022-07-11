
@php 
$page_title = '포인트 자동 적립관리';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">포인트 자동 적립관리</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">회원가입 포인트</div>
				<div class="wr-list-con">
					<div>				
						<label class="radio-wrap"><input type="radio" name="join_bonus" value="Y" @php echo ($conf->join_bonus == 'Y' ? 'checked="checked"' : ''); @endphp><span></span>사용함</label>
						<label class="radio-wrap"><input type="radio" name="join_bonus" value="N" @php echo ($conf->join_bonus == 'N' ? 'checked="checked"' : ''); @endphp><span></span>사용안함</label>
					</div>
					<div>				
						<input type="number" id="join_bonus_point" name="" value="{{$conf->join_bonus_point}}" class="span200" placeholder="포인트 입력">
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">추천인 포인트</div>
				<div class="wr-list-con">
					<div>				
						<label class="radio-wrap"><input type="radio" name="recommand_bonus" value="Y" @php echo ($conf->recommand_bonus == 'Y' ? 'checked="checked"' : ''); @endphp><span></span>사용함</label>
						<label class="radio-wrap"><input type="radio" name="recommand_bonus" value="N" @php echo ($conf->recommand_bonus == 'N' ? 'checked="checked"' : ''); @endphp><span></span>사용안함</label>
					</div>
					<div>				
						<input type="number" id="recommand_bonus_point" name="" value="{{$conf->recommand_bonus_point}}" class="span200" placeholder="포인트 입력">
					</div>
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">추천인 적립 퍼센트</div>
				<div class="wr-list-con">
					<input type="text" id="recommand_bonus_rate" name="" value="{{$conf->recommand_bonus_rate}}" onkeyup="percent(this)" class="span200" placeholder="%"> %
					<p>
					**추천받은 사람이 최초 1회 결제시 추천한 회원/추천받은 회원 1회 적립. (최초세팅)결제 금액의 2%
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		<a href="#" onclick="modify()" class="btn blue">저장</a>
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/point/history';
	}	
	function percent(target) {
		let check = /^[0-9]*.[0-9]*$/;
		const val = $(target).val().replace('.', '');
		if(!check.test(val)) {
			alert('숫자만 입력해주세요.');
			return false;
		}
		if(val < 0 || val > 100) {
			alert('수수료율은 0 ~ 100 의 실수만 가능합니다.');
			return false;
		}
		return true;
	}
	function modify(){
		var join_bonus = $('input[name=join_bonus]:checked').val();
		var join_bonus_point = document.querySelector('#join_bonus_point').value;
		var recommand_bonus = $('input[name=recommand_bonus]:checked').val();
		var recommand_bonus_point = document.querySelector('#recommand_bonus_point').value;
		var recommand_bonus_rate = document.querySelector('#recommand_bonus_rate').value;

		medibox.methods.point.conf({
			join_bonus: join_bonus
			, join_bonus_point: join_bonus_point
			, recommand_bonus: recommand_bonus
			, recommand_bonus_point: recommand_bonus_point
			, recommand_bonus_rate: recommand_bonus_rate
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			location.reload();
		}, function(e){
			console.log(e);
		});
	}
	</script>
</section>

@include('admin.footer')
