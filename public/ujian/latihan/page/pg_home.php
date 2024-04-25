<script>

// Current Server Time script (SSI or PHP)- By JavaScriptKit.com (http://www.javascriptkit.com)
// For this and over 400+ free scripts, visit JavaScript Kit- http://www.javascriptkit.com/
// This notice must stay intact for use.

//Depending on whether your page supports SSI (.shtml) or PHP (.php), UNCOMMENT the line below your page supports and COMMENT the one it does not:
//Default is that SSI method is uncommented, and PHP is commented:

var currenttime = '<?php date_default_timezone_set('Asia/Jakarta'); echo date("F d, Y H:i:s", time())?>' //SSI method of getting server date
//var currenttime = '<? print date("F d, Y H:i:s", time())?>' //PHP method of getting server date

///////////Stop editting here/////////////////////////////////

var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1)
//var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
//document.getElementById("clock").innerHTML=datestring+" "+timestring
document.getElementById("clock").innerHTML=timestring
}

window.onload=function(){
setInterval("displaytime()", 1000)
}

</script>

<?php
//ambil id
//$id_user = mysql_real_escape_string(base64_decode($_GET["id"]));
//echo $id_user;exit();
	/*print_r ($_SESSION);*/
	/*if($_SESSION['851namauser']<>'' OR $_SESSION['851nama']<>'' OR $_SESSION['851group']<>'' ){
		$nim=$_SESSION['851namauser'];
		$nama=$_SESSION['851nama'];	
		$group=$_SESSION['851group'];
	}else{ */
		$q_session=mysql_query("SELECT userid,nama,groups,testuser,testname,questionid FROM ".$db_prefix."session WHERE id_session='".$id_user."'");
		$l_sess=mysql_fetch_array($q_session);
		$nim=$l_sess['userid'];
		$nama=$l_sess['nama'];
		$group=$l_sess['groups'];
		
		if($l_sess['testuser']<>"" or $l_sess['testname']<>"" or $l_sess['questionid']<>""){
			mysql_query("UPDATE ".$db_prefix."session SET testuser='',testname='',questionid='', nomor='', resultid='' WHERE id_session='".$id_user."'");
		}
	/*} */
	
?>
	
		<div class="col-md-3">
          <div class="block-web">
            <div class="user-profile-sidebar">
              <div class="row">
				<?php
					$pathavatar = $path_fprofile."".$nim.".jpg";
					$file_headers = @get_headers($pathavatar);
					if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
						$fotoavatar="images/avatar.jpg";
					}else{
						$fotoavatar=$pathavatar;
					}
					//print_r($file_headers); exit();
					/*
					if(file_exists($pathavatar)) {
						$fotoavatar=$pathavatar;
					}else{
						//$fotoavatar=$pathavatar;
						$fotoavatar="images/avatar.jpg";
					} */
				?>
                <div class="col-md-12">
					<div class="thumbnail" style="border:none !important;">
					<center>
					<div class="thumbnail-view">
					<a href="<?php echo $fotoavatar;?>" class="thumbnail-view-hover image-zoom"> </a>
					<img alt="<?php echo $nama;?>" src="<?php echo $fotoavatar;?>" style="max-width:150px;">
					</div></center></div>
				</div>
                <div class="col-md-12">
                  <div class="user-identity">
					<center>
						<h4><strong><?php echo $nim; ?></strong><p><?php echo $nama;?></p></h4>
					</center>
                  </div>
                </div>
              </div>
            </div>
            
		<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="table table-hover">
				<!--<tr> 
				  <td align="left"><i class="fa fa-calendar-o"></i>&nbsp;
				  <strong style="font: 12px Georgia; color:#000000; font-weight:bold;">Tanggal</strong> :</td>
				  
				  <td align="left"><i class="fa fa-clock-o" style="display:inline;"></i>&nbsp;<strong style="font: 12px Georgia; color:#000000; font-weight:bold;">Waktu Saat Ini</strong></td>
				  
				</tr> -->
				<tr>
					<td align="left"><div style="font: 12px Georgia; color:#000000;"><?php echo $hari_ini.",  ". $tgl_skrg."-".$bln_sekarang."-".$thn_sekarang; ?></div></td>
					<td align="left"><div  style="font: 12px Georgia; color:#000000;">  <div id="clock" style="display:inline;">&nbsp;</div></div></td>
				</tr>
				<tr>
					<td colspan="6">
						<p style="font: 12px Georgia; color:#000;line-height:2;">
							" Jika sudah masuk jam ujian link ujian belum juga tampil harap refresh browser anda atau tekan tombol F5 " 
	
						</p>
					</td>
				</tr>
		</table> 
           
          </div><!--/block-web--> 
        </div><!--/col-md-4-->
		
	<div class="col-md-9">
	  <div class="block-web">
		<h2>KRS (Ujian yang Diikuti)</h2>
		<table  border="0" cellpadding="0" cellspacing="0" width="100%"  class="table">
			<thead style="background:#363b3f;color:#999;font-weight:bold;" >
				<td>No</td>
				<td>Matakuliah</td>
				<td style="text-align:center;">Tanggal</td>
				<td style="text-align:center;">Jam</td>
				<td>Status Ujian</td>
			</thead>

			<?php 
				$q_krs=mysql_query("SELECT
				  a.testid, a.test_description, a.subjectid, a.test_datestart, a.test_dateend, a.test_type, a.test_attempts,a.jmlsoal,
				  MID(FROM_UNIXTIME(a.test_datestart),9,2) AS tanggal, 
				  MID(FROM_UNIXTIME(a.test_datestart),6,2) AS bulan,
				  LEFT(FROM_UNIXTIME(a.test_datestart),4) AS tahun,
				  MID(FROM_UNIXTIME(a.test_dateend),9,2) AS tanggalend, 
				  MID(FROM_UNIXTIME(a.test_dateend),6,2) AS bulanend,
				  LEFT(FROM_UNIXTIME(a.test_dateend),4) AS tahunend,
				  RIGHT(FROM_UNIXTIME(a.test_datestart),8) AS mulai, 
				  RIGHT(FROM_UNIXTIME(a.test_dateend),8) AS selesai
				FROM ".$db_prefix."tests AS a,
				  ".$db_prefix."groups_tests AS b,
				  ".$db_prefix."groups_users AS c,
				  ".$db_prefix."users AS d
				WHERE a.testid = b.testid
					AND b.groupid = c.groupid
					AND c.userid = d.userid
					AND d.userid='$nim' ORDER BY a.test_datestart, a.testid ASC ");
			$row_krs=mysql_num_rows($q_krs);
			
			if($row_krs>0){
				$no=1;
				while($krs=mysql_fetch_array($q_krs)){
					
					$datestart=$krs['tanggal']."-".$krs['bulan']."-".$krs['tahun'];
					$dateend=$krs['tanggalend']."-".$krs['bulanend']."-".$krs['tahunend'];
						
						$sec = $krs['test_datestart']-$unix_timestamp;
					if($sec>0 and $sec<43200){
			?>
				
				<script>
					window.setTimeout(function() {
					 alert('Ujian <?php echo $krs['test_description'];?> di Mulai');
					 window.location.reload();
					}, <?php echo $sec;?>000);
				</script>
			<?php }  ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $krs['test_description'];?></td>
						<td style="text-align:center;"><?php echo $datestart; if($datestart<>$dateend){ echo " s/d ".$dateend; } ?></td>
						<td style="text-align:center;"><?php echo $krs['mulai']." - ".$krs['selesai'];?></td>
						
						<?php if($krs['test_datestart']>$unix_timestamp){ ?>
							<td>Belum Mulai</td>
						<?php }elseif($krs['test_datestart']<$unix_timestamp){
									
									//Memanggil tabel tests_attemts
									$num_tamp=mysql_fetch_array(mysql_query("select test_attempt_count,waktu_habis  from ".$db_prefix."tests_attempts where testid='$krs[testid]' AND userid='$nim' "));

									//$num_tamp=mysql_num_rows($q_testtamp);
									$q_rsltaswr=mysql_query("select b.questionid from ".$db_prefix."results a, ".$db_prefix."results_answers b where a.resultid=b.resultid AND a.testid='$krs[testid]' AND a.userid='$nim' ");
									$num_rasw=mysql_num_rows($q_rsltaswr);
									if($num_tamp['test_attempt_count'] == $krs['test_attempts'] or $num_tamp['test_attempt_count'] > $krs['test_attempts'] AND $num_rasw > 0){
										/*if($krs['test_type']==1){
											if($krs['test_dateend']>$unix_timestamp){
													?>
													<td>
														<form action="edit-<?php echo base64_encode($id_user); ?>" method="post" style="margin:0;padding:0;" name="edit-<?php echo $krs['testid'];?>">
														<input type="hidden" name="userid" value="<?php echo $nim; ?>">
														<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
														<input type="hidden" name="testname" value="<?php echo $krs['test_description']; ?>">
														<input name="cmdselesai" class="btn btn-primary"  type="submit" value="Edit Jawaban" />
														</form>
													</td>
													<?php
											}else{
											?>
												<td>
													<form action="bukti-ujian-<?php echo base64_encode($id_user); ?>" method="post" style="margin:0;padding:0;" name="bukti-ujian-<?php echo $krs['testid'];?>">
													<input type="hidden" name="userid" value="<?php echo $nim; ?>">
													<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
													<input name="cmdselesai" class="btn btn-primary"  type="submit" value="Sudah Ujian" />
													</form>
												</td>
										<?php }
										}else{ */
											if($num_tamp['waktu_habis'] == '1'){
										?>
										<td>
													<form action="bukti-ujian-<?php echo $s_id; ?>" method="post" style="margin:0;padding:0;" name="bukti-ujian">
													<input type="hidden" name="userid" value="<?php echo $nim; ?>">
													<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
													<input name="cmdselesai" class="btn btn-danger"  type="submit" value="Waktu Habis" />
													</form>
											</td>
										<?php }else{ ?>
											<td>
													<form action="bukti-ujian-<?php echo $s_id; ?>" method="post" style="margin:0;padding:0;" name="bukti-ujian">
													<input type="hidden" name="userid" value="<?php echo $nim; ?>">
													<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
													<input name="cmdselesai" class="btn btn-info"  type="submit" value="Sudah Ujian" />
													</form>
											</td>
									<?php /* } */
									}}elseif($krs['test_dateend']<$unix_timestamp){
										$cekujian=mysql_query("SELECT 
																  a.resultid,
																  b.result_answerid 
																FROM
																  ".$db_prefix."results AS a,
																  ".$db_prefix."results_answers AS b 
																WHERE a.resultid = 
																				  (SELECT 
																					c.resultid 
																				  FROM
																					".$db_prefix."results AS c 
																				  WHERE c.userid = '".$nim."' 
																					AND c.testid = '".$krs['testid']."' 
																				  ORDER BY c.resultid DESC 
																				  LIMIT 1) 
																  AND a.resultid = b.resultid 
																  AND a.userid = '".$nim."' 
																  AND a.testid = '".$krs['testid']."' 
																ORDER BY a.resultid DESC ");
										$num_cekujian=mysql_num_rows($cekujian);
										if($num_cekujian>=$krs['jmlsoal']){
											?>
											<td>
													<form action="bukti-ujian-<?php echo $s_id; ?>" method="post" style="margin:0;padding:0;" name="bukti-ujian">
													<input type="hidden" name="userid" value="<?php echo $nim; ?>">
													<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
													<input name="cmdselesai" class="btn btn-primary"  type="submit" value="Sudah Ujian" />
													</form>
											</td>
											<?php
										}else{
									?>
										<td>
										
										<form action="bukti-ujian-<?php echo $s_id; ?>" method="post" style="margin:0;padding:0;" name="bukti-ujian">
													<input type="hidden" name="userid" value="<?php echo $nim; ?>">
													<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
													<input name="cmdselesai" class="btn btn-light"  type="submit" value="Waktu Lewat" />
													</form>
										</td>
							<?php 		}
									}else{ ?>
						
										<td>
											<form action="ujian-<?php echo $s_id; ?>" method="post" style="margin:0;padding:0;" name="ujian">
											<input type="hidden" name="testid" value="<?php echo $krs['testid']; ?>">
											<input type="hidden" name="testname" value="<?php echo $krs['test_description']; ?>">
											<input type="hidden" name="testname" value="<?php echo $krs['test_description']; ?>">
                                            <input name="cmdmulai" type="submit" class="btn btn-primary" value="Mulai Ujian" />
											</form>
										</td>
								
									<?php 
								
									}
							
								} ?>
					</tr>
					
			<?php
					$no=$no+1;
				}
			}else{
				?>
					<tr>
						<td colspan="5"><center>Tidak ada jadwal ujian di KRS anda</center></td>

					</tr>
				<?php
			}	
			?>
			
		</table>
		</div>
	</div>

<!-- Modal 
<div class="modal fade bs-example-modal-lg" id="myInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:#363b3f;font-weight:bold;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" id="myModalLabel" style="color:#fff;"><strong>Informasi</strong></h3>
      </div>
      <div class="modal-body">
        <strong>Mahasiswa wajib melakukan verifikasi data pribadi di Ruang Mahasiswa pada tanggal 16 s/d 26 Januari 2017<strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->
