
@php 
$page_title = '공지사항 상세';
@endphp
@include('admin.header')

<section id="wrtie" class="container">

	<div class="section-header">공지사항 @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">제목</div>
				<div class="wr-list-con" id="title">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">내용</div>
				<div class="wr-list-con" id="contents">
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if(session()->get('admin_type') == 'A' || session()->get('admin_type') == 'B') {
		@endphp
		@php
		if($id != 0) {
		@endphp
		<a href="#" onclick="remove()" class="btn red">삭제</a>
		@php 
		}
		@endphp
		@php
		if($id == 0) {
		@endphp
		<a href="#" onclick="add()" class="btn blue">등록</a>
		@php 
		}
		@endphp
		@php
		}
		@endphp
	</div>

	<script>
	var userId;
	function cancel(){
		window.location.href = '/admin/main';
	}
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $id }}' };

		medibox.methods.contents.partnerNotice.one(data, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			$('#title').text( response.data.title );
$('#title').val( response.data.title );
			$('#contents').text( response.data.contents );$('#contents').val( response.data.contents );
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
