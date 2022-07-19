
@php 
$page_title = $id == 0 ? '이용약관 등록' : '이용약관 수정';
@endphp
@include('admin.header')

<script type="text/javascript" src="/adm/js/smartedit2.0/HuskyEZCreator.js" charset="utf-8"></script>

<section id="wrtie" class="container">

	<div class="section-header">이용약관 @php echo $id == 0 ? '등록' : '상세'; @endphp</div>
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
					<textarea id="contents" name="contents" value="" class="nse_content" placeholder="내용을 작성해주세요."></textarea>
					<script type="text/javascript">
					var oEditors = [];
					nhn.husky.EZCreator.createInIFrame({
						oAppRef: oEditors,
						elPlaceHolder: "contents",
						sSkinURI: "/adm/skin/SmartEditor2Skin.html",
						fCreator: "createSEditor2"
					});
					</script>
				</div>
			</div>
		</div>
	</div>
	
	<div class="btnSet">
		<a href="#" onclick="cancel()" class="btn gray">취소</a>
		@php
		if($id != 0) {
		@endphp
		<a href="#" onclick="modify()" class="btn green">수정</a>
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
		window.location.href = '/admin/contents/usages';
	}
	function checkValidation(){
		var title = document.querySelector('#title').value;
        var contents = oEditors.getById["contents"].exec("UPDATE_CONTENTS_FIELD", []);
        
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
		oEditors.getById["contents"].exec("UPDATE_CONTENTS_FIELD", []);
		if(!checkValidation()) {
			return;
		}
		var title = document.querySelector('#title').value;
        var contents = document.querySelector('#contents').value;

		medibox.methods.contents.usage.add({
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
    
	function modify(){
		oEditors.getById["contents"].exec("UPDATE_CONTENTS_FIELD", []);
		if(!checkValidation()) {
			return;
		}
		var title = document.querySelector('#title').value;
        var contents = document.querySelector('#contents').value;

		medibox.methods.contents.usage.modify({
			title: title
			, contents: contents
			, admin_seqno: {{ $seqno }}
		}, userId, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
			}
			alert('수정 되었습니다.');
			cancel();
		}, function(e){
			console.log(e);
		});
    }
    
	function getInfo(){
		var data = { adminSeqno:{{ $seqno }}, id:'{{ $id }}' };

		medibox.methods.contents.usage.one(data, '{{ $id }}', function(request, response){
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
		medibox.methods.contents.usage.remove({
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
