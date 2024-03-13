<?php session_start();
	include('../../includes/connect.php');	
	//print_r($_POST);
	$sql="select teacher.teacher_id,teacher.FirstName,teacher.LastName,prefix.prefix_name ";
	$sql .=" ,teacher.teacher_mail,teacher.teacher_sid ";
	$sql.=" ,user_type.user_type_name, teacher.teacher_type_id2 as app_posit_id";
	$sql .=" from teacher ";
	$sql .=" left JOIN prefix ON teacher.prefix_id = prefix.prefix_id ";
	$sql .=" left JOIN user_type ON teacher.teacher_type_id = user_type.user_type_id ";
	$sql .=" where 1=1 ";
	if(!($_POST['s_teacher_sid']>1)){
	$sql .=" and teacher.schoolid='$_SESSION[sschoolid]' ";
	}
	$sql .="and teacher_type_id<'3' and teacher.teacher_mail not like '$_SESSION[teacher_mail]'";
	//$sql .=" order by teacher.teacher_type_id desc,teacher.teacher_id ";	
	//$sql .=" limit 0,$_POST[qpage] ";
	//echo $sql;
	

//แบ่งหน้าแสดงข้อมูล
	$no_field=array('page','qpage');
	foreach($_POST as $key=>$value){
		if(!in_array($key,$no_field)){
			if($value<>''){
				$field=str_replace('s_','',$key,$x);
				if(strpos($key,'title')<>''){
					$param[$field]="%$value%";				
					$sql.=" and $field like '%$value%' ";
					}else{
					$param[$field]=$value;				
					$sql.=" and $field like '%$value%' ";
				}
			}
		}
	}
	
	$query = $conn->prepare($sql);
	try{
		$query->execute($da);
		$count = $query->rowCount();
		}catch(PDOException $er){
		echo 'Error :'.$er->getMessage();
	}
	$json_data['pagination']['max_data']=$count;
	//คำนวณ record เริ่มต้น
	if($_POST['page']==1){
		$stat2=$_POST['qpage'];
		if($stat2>$count){ $stat2=$count;}
		$json_data['pagination']['state']='แสดง 1 - '.number_format($stat2). ' จาก '.number_format($count).' รายการ';
		$start=0;
		}else{
		$start=($_POST['page']-1)*$_POST['qpage'];
		$stat2=$start+$_POST['qpage'];
		if($stat2>$count){ $stat2=$count;}
		$json_data['pagination']['state']='แสดง '.($start+1).' - '.number_format($stat2). ' จาก '.number_format($count).' รายการ';
	}
	$json_data['pagination']['max_loop']=ceil(($count/$_POST['qpage']));
	
	$sql .=" group by teacher.teacher_id ";
	$sql .=" order by teacher.teacher_type_id desc,teacher.teacher_id ";
	//$sql.=" ORDER BY hospital_id ASC  ";
	$sql .=" limit $start,$_POST[qpage] ";
//แบ่งหน้าแสดงข้อมูล
//echo $sql;
	$query=$conn->prepare($sql);
	try{
		$query->execute();
		$count = $query->rowCount();
		$i=1;
		while($data=$query->fetch(PDO::FETCH_ASSOC)){
			foreach($data as $key=>$value){
				if($key=='teacher_performance'){
					switch($value){
						case '1': $value='ครูนิเทศก์และครูผู้สอน';break;
						case '2': $value='ครูประจำบ้าน(ครูผู้สอน)';break;
					}
				}
				if($key=='app_posit_id'){
				if($value==''){
					$value='<font color="#ff0000">ยังไม่ได้อัพเดทข้อมูล</font>';
				}else if($value=='1'){
					$value='จ้างเหมาบริการ';
				}else if($value=='3'){
					$value='พนักงานราชการ';
				}else if($value=='2'){
					$value='ข้าราชการครู';
				}
			}
				$json_data[$i][$key]=$value;
			}
			++$i;
		}
		}catch(PDOException $er){
		echo 'Error :'.$er->getMessage();
	}
	$json=json_encode($json_data);
	echo $json;
	
?>
