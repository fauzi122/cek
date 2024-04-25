$(document).ready(function() { 

$('.selesai').click(function() {
    localStorage.clear();
});
$('.no_soal').click(function() {
    // localStorage.clear();
    var $this = $(this);
    $('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
    $('#no_soal_detail').html($this.attr('data-no'));
    var id_soal = $this.attr('data-id');
    var no_urut = $this.attr('data-no');
    var soal = window.localStorage.getItem(`${id_soal}`);
    window.localStorage.setItem('current_soal', no_urut);
    $('span.no_soal').removeClass('soal_terpilih');
    $(`span#no_soal${no_urut}`).addClass('soal_terpilih');

    if(soal == null){
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/get-soal",
        data: {
            id_soal: id_soal,
            no_urut: no_urut
        },
        success: function(data) {
            $('#wrap-soal').html(data.html);
            window.localStorage.setItem(`${id_soal}`, data.html);
        }
    });
    }else{
        $('#wrap-soal').html(soal);
    }
    var max = parseInt(  $('div#maxsoal').data('max') );
    if(no_urut >= max){
        $('button#next').hide();
    }else{
        $('button#next').show();
    }
});

$('button#next').click(function(){
    var cs = parseInt( window.localStorage.getItem('current_soal') ?? 1 );
    var ns = cs + 1;
    var max = parseInt(  $('div#maxsoal').data('max') );
    ns = ns > max ? max : ns;  
    $(`span#no_soal${ns}`).trigger('click');
});

$(document).on('click', ".jawab", function() {       
    var $this = $(this);
    var get_jawab = $this.attr('data-jawab');
    var id_soal = $this.attr('data-id');
    var no_urut = $('div#nomerurut').data('id')
    $('span.no_soal').removeClass('soal_terpilih');
    $(`span#no_soal${no_urut}`).addClass('soal_terjawab');
    $('#nav' + id_soal).css({
        "background-color": "#1a8e5f",
        "color": "#fff"
    });
    $('#nava' + id_soal).css({
        "color": "#fff"
    });
    
    $(".jawab").css({
        "background-color": "#fff",
        "color": "#000",
        "padding": "0",
        "border-radius": "0"
    });
    $this.css({
        "background-color": "#1980d4",
        "color": "#fff",
        "padding": "5px 10px",
        "border-radius": "3px"
    });
    $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
   });
//    var jawab = window.localStorage.getItem(`${id_soal}${get_jawab}`);
//    console.log(jawab);
//    if(jawab != id_soal+get_jawab){
    localStorage.removeItem(`${id_soal}`);
    // localStorage.removeItem(`${id_soal}${get_jawab}`);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/jawaban",
        data: {
            'get_jawab': get_jawab
        },
        success: function(data) {
            // console.log(data.success);
            if (data == 2) {
                // localStorage.clear();
                $("#selesai").html('Selesai Ujian').show();
            }
        }
    });
    // window.localStorage.setItem(`${id_soal}${get_jawab}`, id_soal+get_jawab);
// }

});
});

// Mengatur waktu akhir perhitungan mundur
var id_soal = document.getElementById("waktu-akhir").innerHTML;
var countDownDate = new Date(id_soal).getTime();

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

// Untuk mendapatkan tanggal dan waktu hari ini
var now = new Date().getTime();


// Temukan jarak antara sekarang dan tanggal hitung mundur
var distance = countDownDate - now;

// Perhitungan waktu untuk hari, jam, menit dan detik
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);

// Keluarkan hasil dalam elemen dengan id = "demo"
document.getElementById("demo").innerHTML = hours + " : "
+ minutes + " : " + seconds + " ";

// Jika hitungan mundur selesai, tulis beberapa teks 
if (distance < 0) {
localStorage.clear();
clearInterval(x); alert('Waktu Ujian Anda Habis'); location.reload();
//clearInterval(x);
//document.getElementById("demo").innerHTML = "EXPIRED";
}
}, 1000);

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
        



