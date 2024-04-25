<?php
//ambil id
// fungsi enkripsi //
function enkripsime($kata_en, $chipper_en) {
	static $karakter = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chipper_en = (int)$chipper_en % 26;
	if (!$chipper_en) return $kata_en;
	if ($chipper_en == 13) return str_rot13($kata_en);
	for ($i = 0, $l = strlen($kata_en); $i < $l; $i++) {
		$c = $kata_en[$i];
		if ($c >= 'a' && $c <= 'z') {
			$kata_en[$i] = $karakter[(ord($c) - 71 + $chipper_en) % 26];
		} else if ($c >= 'A' && $c <= 'Z') {
			$kata_en[$i] = $karakter[(ord($c) - 39 + $chipper_en) % 26 + 26];
		}
	}
	return $kata_en;
}
//====================================//
$s_id=mysql_escape_string($_GET["id"]);
/* $encode_sid=base64_encode($s_id);
$en_sid=enkripsime($encode_sid, 213091); */
								
$dec_sid=enkripsime($s_id, -213091);
$decode_sid=base64_decode($dec_sid);

$id_user = $decode_sid;
$db_pt=substr($id_user,0,1);
					
include "line/sambungan.php";
include "lib/library.php"; 

$list_ses=mysql_fetch_array(mysql_query("select passuser, nama, userid, login, timeout from  ".$db_prefix."session where id_session = '$id_user'"));
$timeout=$list_ses['timeout'];

if(time()>$timeout){
	?>
		<meta http-equiv="Refresh" content="0; URL=logout-<?php echo $s_id;?>">
	<?php
}else{
	
	$time=3600;
	$settime=time()+$time;
	mysql_query("UPDATE ".$db_prefix."session SET timeout='$settime' where id_session='$id_user'");
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title><?php echo $web_title;?></title>

<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>-->
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<link href="plugins/kalendar/kalendar.css" rel="stylesheet">
<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="plugins/gallery/magnific-popup.css" rel="stylesheet">

	<script src="js/jquery-1.11.1.min.js"></script> 
	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="bootstrap/js/bootstrap.min.js"></script> 
	<script src="js/accordion.js"></script> 
	<script src="js/common-script.js"></script> 
	<script src="js/jquery.nicescroll.js"></script> 
	<script src="plugins/gallery/jquery.magnific-popup.min.js"></script>
	<script>
 $(document).ready(function(){
  if ($.fn.magnificPopup) {
			$('.image-zoom').magnificPopup({
				type: 'image',
				closeOnContentClick: false,
				closeBtnInside: true,
				fixedContentPos: true,
				mainClass: 'mfp-no-margins mfp-with-zoom', 
				image: {
					verticalFit: true,
					tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
				}
			});

		}

    });
</script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
	

  
<?php
	
if (empty($list_ses['userid']) AND empty($list_ses['passuser']) and empty($list_ses['nama'])){
?>
	 <meta http-equiv="Refresh" content="0; URL=login">
	 <script language='javascript'>document.location = 'login';</script>
<?php
}else{
?>

<body class="dark-theme" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
<div class="header navbar navbar-inverse box-shadow navbar-fixed-top">
  <div class="navbar-inner">
    <div class="header-seperation">
      <ul class="nav navbar-nav">
        <li class="sidebar-toggle-box"> <a href="#"><i class="fa fa-bars"></i></a> </li>
        <li> <a href=""><strong><?php echo $web_title;?></strong></a> </li>
		<li class="hidden-xs">
          <div class="hov">
            <div class="btn-group"> <a data-toggle="dropdown" href="" class="con"><span class="fa fa-tag"></span></a>
              <ul role="menu" class="dropdown-menu pull-right dropdown-alerts" >
                <li class="title" style="padding-top:0;padding-left:151%;">
                  <img src="images/logo_campus1.png">
                </li>
              </ul>
            </div>
          </div>
        </li>
		<li class="hidden-xs">
			<a>
			<font style="font-weight:bold;"><?php echo $list_ses['userid']." - ".$list_ses['nama'];?></font>
			</a>
        </li>
		<!--<li> <img alt="avatar" src="images/avatar.jpg" width="10%"> <?php echo $list_ses['nama'];?></li>-->
        <li><a href="logout-<?php echo base64_encode($id_user);?>">Log Out</a></li>
      </ul><!--/nav navbar-nav--> 
    </div><!--/header-seperation--> 
  </div><!--/navbar-inner--> 
</div><!--/header-->

<div class="page-container">
  <div class="nav-collapse top-margin fixed box-shadow2 hidden-xs" id="sidebar" >
	
    <img alt="avatar" src="images/logo_campus.png" width="100%">       
    
    </div><!--/leftside-navigation--> 

  
  <div id="main-content">
    <div class="page-content">
      
      <div class="row">
            <p><?php include "content.php"; ?></p>
      </div><!--/row-->

      <hr>


    </div><!--/.fluid-container-->
</div>
    <!-- Le javascript
    ================================================== -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	
	<script type="text/javascript" language="javascript">
		$(document).ready(function(){
			$(this).bind("cut copy paste", function(e) {
				e.preventDefault();
			});
		}); 
	</script>
	<script type="text/javascript">
		window.history.forward();function noBack(){window.history.forward();}
	</script>
	<script>
		/*$('#myInfo').modal('show')*/
	</script>
  </body>
<?php
}
}
?>

</html>

