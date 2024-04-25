<?php
//ambil id
$id_user = base64_decode(mysql_escape_string($_GET["id"]));
$db_pt=substr($id_user,0,1);
include "line/sambungan.php";
include "lib/library.php"; 



$list_ses=mysql_fetch_array(mysql_query("select passuser, nama, userid, login, timeout from  ".$db_prefix."session where id_session = '$id_user'"));

if($list_ses['login']==1){
	$timeout=$list_ses['timeout'];
	if(time()<$timeout){
		$time=3600;
		$settime=time()+$time;
		mysql_query("UPDATE ".$db_prefix."session SET timeout='$settime' where id_session='$id_user'");
	}else{
		mysql_query("UPDATE ".$db_prefix."session SET timeout='', login=0 where id_session='$id_user'");
		//unset($_SESSION['timeout']);
	}
}
if($list_ses['login']==0){
	?>
		<meta http-equiv="Refresh" content="0; URL=logout-<?php echo base64_encode($id_user);?>">
	<?php
}else{

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
    <!--<ul id="nav-accordion" class="sidebar-menu">
      <li><a href="#"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
	  <li class="sub-menu dcjq-parent-li"> <a href="javascript:;" class="dcjq-parent"> <i class="fa fa-book"></i> <span>Perkuliahan</span><b class="badge bg-danger pull-right">4</b></a>
        <ul class="sub">
          <li><a href="#"><i class="fa fa-angle-right"></i> Jadwal</a></li>
          <li><a href="#"><i class="fa fa-angle-right"></i> Rekapitulasi</a></li>
          <li><a href="#"><i class="fa fa-angle-right"></i> Pokok Bahasan</a></li>
          <li><a href="#"><i class="fa fa-angle-right"></i> Slide</a></li>
          
        </ul>
      </li>
      <li class="sub-menu dcjq-parent-li"> <a href="javascript:;" class="dcjq-parent"> <i class="fa fa-laptop"></i> <span>Ujian Online</span><b class="badge bg-danger pull-right">2</b></a>
        <ul class="sub">
          <li><a href="#"><i class="fa fa-angle-right"></i> UTS</a></li>
          <li><a href="#"><i class="fa fa-angle-right"></i> UAS</a></li>
        </ul>
      </li>
    </ul>/nav-accordion sidebar-menu--> 
    </div><!--/leftside-navigation--> 

  
  <div id="main-content">
    <div class="page-content">
      
      <div class="row">
		<!--
        <div class="col-md-12">
          <div class="block-web">
			<div id="dynamic-table_wrapper" class="dataTables_wrapper" >-->
            <p><?php include "content.php"; ?></p>
			<!--</div>
          </div>
        </div><!--/col-md-4-->
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
	
  </body>
<?php
}
}
?>

</html>

