

<footer id="footer">
	<div class="footer_container">
		<span class="copyrights">&copy;2021 ADMIN. All Rights Reserved.</span>
	</div>
</footer>

</div>
<!-- //#wrapper -->

<script>
$('#main, #view, #wrtie, #background').parent().addClass('bg');

//location text넣기
$(document).ready(function(){
	var opener_name = $('#header #nav_ul li.open > a').text(),
		page_name = $('#header #nav_ul li.active').text() ? $('#header #nav_ul li.active').text() : '{{ $page_title }}';
	if(typeof opener_name !== typeof undefined && opener_name !== '') {
		$('#topContainer .loaction').append('<span>'+opener_name+'</span>');
	}
	$('#topContainer .loaction').append('<span>'+page_name+'</span>');
});


</script>

</body>
</html>