<?php $part = isset($_SERVER['PATH_INFO']) ? explode('/',preg_replace('~^/?(.*?)/?
	$~','$1',$_SERVER['PATH_INFO'])) : array() ;
	$mod_co=count($part);
	$web_file='app_modules/';
	$web_folder='app_modules/';	
		if($mod_co==2){ $menu='menu';$url=$part['1'];
			$sql_menu="select menu_title,menu_file,menu_icon ";
			$sql_menu.=" from menu ";
			$sql_menu.=" where menu_url='$url'";
			}elseif($mod_co==3){
			$menu='menu2';$url=$part['2'];
			$folder=$url;		
			$sql_menu="select menu2.menu2_title,menu2.menu2_file,menu2.menu2_icon ";
			$sql_menu.=" ,menu.menu_title ";
			$sql_menu .=" from menu2 ";
			$sql_menu .=" inner join menu on menu2.menu_id=menu.menu_id ";
			$sql_menu .=" where menu2.menu2_url='$url' ";
			}else{
			//echo $web['domain'];
			//echo '<META http-equiv="refresh" content="0; URL='.$web['domain'].'dashboard/">';
			$web_folder='app_modules/dashboard/';
			//$web_file='app_modules/login/';
		}
		$query=$conn->prepare($sql_menu);
		try{
			$query->execute();
			$data=$query->fetch(PDO::FETCH_ASSOC);
			$web_title=$data['menu_title'];
			$web_title2=$data['menu2_title'];
			$web_icon=$data['menu_icon'];
			$web_icon2=$data['menu2_icon'];
			if($mod_co<3){
				$web_file.=$data['menu_file'].'/index.php';
				$web_folder.=$data['menu_file'].'/';
				}else{
				$web_file.=$data['menu2_file'].'/index.php';
				$web_folder.=$data['menu2_file'].'/';			
			}
			}catch(PDOException $er){
			echo 'Error :'.$er->getMessage();
		}
		$count=count($part);
		$m=$count-1;
		$page=array('login','logout');
?>			