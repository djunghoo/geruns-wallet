<?php session_start();
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
include('includes/connect.php');
include('main.php');
if (in_array($part[1], $page)) {
	include($web_file);
} elseif ($_SESSION['user_type_id'] == '') {
	echo '<META http-equiv="refresh" content="0; URL=' . $web['domain'] . 'login/">';
} else {
	include('header.php');
	//include('menu_horizontal.php');
	/*if(isset($_SESSION['username'])){
			$_SESSION['user_type_id']=1;
			//session_destroy();
		}*/
?>
	<div class="main-container container-plus bgc-white">

		<?php if ($_SESSION['user_type_id'] == 1) {
			include('menu_left.php');
		} ?>

		<div role="main" class="main-content">

			<?php
			//print_r($part);
			//print_r($_SESSION);
			//echo $mod_co;
			//echo $web_file;
			include($web_file);
			include('footer_page.php');
			//include('web_control.php');
			?>
		</div>
	</div>

	<!-- include common vendor scripts used in demo pages -->
	<script src="node_modules/jquery/dist/jquery.js"></script>
	<script src="node_modules/popper.js/dist/umd/popper.js"></script>
	<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
	<script src="includes/function.js"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="ckfinder/ckfinder.js"></script>
	<script src="node_modules/select2/dist/js/select2.js"></script>

	<script src="node_modules/summernote/dist/summernote-lite.js"></script>


	<!-- include vendor scripts used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-scripts.hbs" -->

	<script src="node_modules/jquery-validation/dist/jquery.validate.js"></script>
	<script src="node_modules/bootbox/bootbox.all.js"></script>
	<script src="node_modules/fullcalendar/main.js"></script>
	<script src="jquery-ui/jquery-ui.min.js"></script>
	<script src="node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.js"></script>


	<!-- include ace.js -->
	<script src="dist/js/ace.js"></script>
	<!-- "Calendar" page script to enable its demo functionality -->


	<script>
		var folder = "/ndec3/<?php echo $web_folder; ?>";
		//ฟังก์ชั่นตั้งค่าเพื่อให้คำสั่ง $.post รับค่าจาก new FormData(document.getel) โดยเอา
		$.ajaxSetup({
			cache: false,
			contentType: false,
			processData: false
		});
	</script>
	<script src="/ndec3/<?php echo $web_folder; ?>function.js"></script>
	</body>

	</html>
<?php } ?>