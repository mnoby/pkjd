$(document).ready(function() {
	$('a.more').click(function() {
	
		// Toggle Class
		$tr = $(this).parent().parent();
		$tr.toggleClass('expanded');
		
		// Tampilkan - sembunyikan baris
		$i = $(this).children('i');
		$i.removeClass('fa-chevron-down', 'fa-chevron-up');
		var arrow = $tr.hasClass('expanded') ? 'fa-chevron-up' : 'fa-chevron-down';
		$i.addClass(arrow);
		
		return false;
	});
})