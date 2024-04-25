<?php

include "lib/library.php";

		if ($_GET['page']=='login'){
			include "page/pg_login.php";
		}elseif ($_GET['page']=='home'){
			include "page/pg_home.php";
		}elseif ($_GET['page']=='ujian'){
			include "page/pg_ujian.php";
		}elseif ($_GET['page']=='ujian_simpan'){
			include "page/pg_ujian_simpan.php";
		}elseif ($_GET['page']=='ujian_bukti'){
			include "page/pg_bukti.php";
		}elseif ($_GET['page']=='ujian_bukti_pdf'){
			include "page/pg_bukti_pdf.php";
		}elseif ($_GET['page']=='edit'){
			include "page/pg_edit.php";
		}elseif ($_GET['page']=='ujian_edit'){
			include "page/pg_edit_ujian.php";
		}elseif ($_GET['page']=='ujian_edit_simpan'){
			include "page/pg_edit_ujian_simpan.php";
		}elseif ($_GET['page']=='logout'){
			include "page/pg_logout.php";
		}
?>