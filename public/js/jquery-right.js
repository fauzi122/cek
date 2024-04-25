if(jQuery)(function(){$.extend($.fn,{rightClick:function(a){$(this).each(function(){$(this).mousedown(function(b){var c=b;$(this).mouseup(function(){$(this).unbind("mouseup");if(c.button==2){a.call($(this),c);return false}else{return true}})});$(this)[0].oncontextmenu=function(){return false}});return $(this)},rightMouseDown:function(a){$(this).each(function(){$(this).mousedown(function(b){if(b.button==2){a.call($(this),b);return false}else{return true}});$(this)[0].oncontextmenu=function(){return false}});return $(this)},rightMouseUp:function(a){$(this).each(function(){$(this).mouseup(function(b){if(b.button==2){a.call($(this),b);return false}else{return true}});$(this)[0].oncontextmenu=function(){return false}});return $(this)},noContext:function(){$(this).each(function(){$(this)[0].oncontextmenu=function(){return false}});return $(this)}})})(jQuery);

// Jalankan fungsi...
$(function() {
    $(document).rightClick(function(e) {
         $('.myvideo').show(); //menampilkan overlay saat aksi klik-kanan dilakukan
    });

    $('.myvideo').click(function() {
         $(this).fadeOut("fast"); //menghilangkan overlay saat overlay diklik
    });
});
$('#specialstuff').bind('cut copy paste',function(e) {
    e.preventDefault(); return false; 
});




var elem = document.getElementById("myvideo");
function openFullscreen() {
var width = window.screen.width;
var height = window.screen.height;
    if(width<770){
		alert('Perangkat Anda Tidak Diperbolehkan untuk Ujian Online, resolusi layar anda '+width+'px x '+height+'px');
		document.location = "http://elearning.bsi.ac.id/exercise";
	}
  if (elem.requestFullscreen) {
    $("#specialstuff").show();
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) { /* Safari */
  $("#specialstuff").show();
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE11 */
  $("#specialstuff").show();
    elem.msRequestFullscreen();
  }
}
$(document).bind("fullscreenchange", function(e) {
		if ($(document).fullScreen()) {
			console.log('sedang ujian!');
		} else {
			$("#specialstuff").hide();
		}
	});
    $("#start-exam").click(function() {
			$("#specialstuff").show();
		});
        