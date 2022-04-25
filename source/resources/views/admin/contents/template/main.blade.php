
@php 
$page_title = '메인화면 디자인 선택';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">메인화면 디자인 선택</div>
	<div class="wrtieContents">
		<div class="gallery">
			<ul>
				<li>
					<a href="#">
						<div class="imgCon"><img src="/adm/img/temp/temp01.jpg"></div>
						<label class="radio-wrap"><input type="radio" name="main_design" value="1"><span></span>디자인1</label>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<script>
	function cancel(){
		window.location.href = '/admin/contents/notices-partner';
	}

	function saveTemplate(seq){
		if(!confirm('선택한 디자인으로\n메인디자인을 변경하시겠습니까?')) {
			return;
		}
		medibox.methods.contents.template.choose({
			admin_seqno: {{ $seqno }},
			id: seq
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$("input:radio[name='main_design']:radio[value='"+seq+"']").prop('checked', true); 
			alert('저장 되었습니다.');
		}, function(e){
			console.log(e);
		});
	}

	function getInfo(){
		var data = { adminSeqno:{{ $seqno }} };

		medibox.methods.contents.template.list(data, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			var bodyData = '';
			for(var inx=0; inx<response.data.length; inx++){                
				bodyData = bodyData 
								+'<li>'
								+'	<a href="#" onclick="saveTemplate('+response.data[inx].seqno+')">'
								+'		<div class="imgCon"><img src="'+response.data[inx].representative_img+'"></div>'
								+'		<label class="radio-wrap"><input type="radio" name="main_design" value="'+response.data[inx].seqno
											+'" '+(response.data[inx].choosed == 'Y' ? 'checked="true"' : '')+'><span></span>디자인'+(inx+1)+'</label>'
								+'	</a>'
								+'</li>';
			}
			$('.gallery').html('<ul>'+bodyData+'</ul>');
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}

	$(document).ready(function(){
		getInfo();
	});
	</script>
</section>

@include('admin.footer')
