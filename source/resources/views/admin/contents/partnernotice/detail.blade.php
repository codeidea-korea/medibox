
@php 
$page_title = $id == 0 ? '공지사항 (파트너) 등록' : '공지사항 (파트너) 수정';
@endphp
@include('admin.header')

<script type="text/javascript" src="/adm/js/smartedit2.0/HuskyEZCreator.js" charset="utf-8"></script>

<section id="wrtie" class="container">

	<div class="section-header">공지사항 (파트너) @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
	<div class="wrtieContents">
		<div class="wr-wrap line label160">
			<div class="wr-list">
				<div class="wr-list-label">제목</div>
				<div class="wr-list-con">
					<input type="text" id="title" name="" value="" class="span200" placeholder="제목을 작성해주세요.">
				</div>
			</div>
			<div class="wr-list">
				<div class="wr-list-label">내용</div>
				<div class="wr-list-con">
					<textarea id="contents" name="" value="" class="" placeholder="내용을 작성해주세요."></textarea>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
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
	</div>

	<script>
		var userId;
	function cancel(){
		window.location.href = '/admin/contents/notices-partner';
	}
	function checkValidation(){
		var title = document.querySelector('#title').value;
        var contents = document.querySelector('#contents').value;
        
		if(!title || title == '') {
			alert('제목을 입력해주세요.');
			return false;
		}
		if (!contents || contents == '') {
			alert('내용을 입력해주세요.');
			return false;
		}

		return true;
	}
	// 등록일 경우
	@php
	if($id == 0) {
	@endphp
	function add(){
		if(!checkValidation()) {
			return;
		}
		var title = document.querySelector('#title').value;
        var contents = document.querySelector('#contents').value;

		medibox.methods.contents.partnerNotice.add({
			title: title
			, contents: contents
			, admin_seqno: {{ $seqno }}
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('추가 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	@php
	}
	@endphp
	// 수정일 경우
	@php
	if($id != 0) {
	@endphp
    userId = {{$id}}
    /*
	function modify(){
		if(!checkValidation()) {
			return;
		}
		var id = document.querySelector('#userId').value;
		var pw = document.querySelector('#userPassword').value;
		var name = document.querySelector('#userName').value;

		medibox.methods.user.modify({
			id: userId
			, pw: pw
			, pw2: pw
			, name: name
		}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			window.location.href = '/admin/members';
		}, function(e){
			console.log(e);
		});
    }
    */
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
	
	function remove(){
		if(!confirm('정말 삭제 하시겠습니까?')) {
			return;
		}
		medibox.methods.contents.partnerNotice.remove({
			id: userId
		}, '{{ $id }}', function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('삭제 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
	}
	$(document).ready(function(){
		getInfo();
	});
	@php
	}
	@endphp
	</script>
</section>

@include('admin.footer')
