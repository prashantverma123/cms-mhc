<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$category_id 	= isset($_POST['category_id']) ? $_POST['category_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_cat':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $category_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveCategory':
			if($category_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['category_name'];
				$insertArr['summary'] 			= $_POST['summary'];
				$insertArr['parent_id'] 		= $_POST['parent_id'];
				$insertArr['priority'] 			= $_POST['priority'];
				$insertArr['summary'] 			= $_POST['summary'];
				$insertArr['meta_title'] 		= $_POST['meta_title'];
				$insertArr['meta_keyword'] 		= $_POST['meta_keyword'];
				$insertArr['meta_description'] 	= $_POST['meta_description'];
				$insertArr['image'] 			= $_POST['hid_full_category_logo'];
				$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
				$insertArr['author_name']			= "Prashant";
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				$insertArr['update_date']		= date('Y-m-d H:i:s');
				$insertArr['status']= 0;
				$insertArr['ip']= getIP();
				$returnVal = $modelObj->insertTable($insertArr);
				//die;
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call']   = 'add';
				$arrReturn['category_id'] = encryptdata($returnVal);

			}else if($category_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['category_name'];
				$updateArr['summary'] 		= $_POST['summary'];
				$updateArr['parent_id'] 	= $_POST['parent_id'];
				$updateArr['priority'] 		= $_POST['priority'];
				$updateArr['image'] 		= $_POST['hid_full_category_logo'];
				$updateArr['summary']	 	= $_POST['summary'];
				$updateArr['meta_title'] 	= $_POST['meta_title'];
				$updateArr['meta_keyword'] 	= $_POST['meta_keyword'];
				$updateArr['meta_description'] 	= $_POST['meta_description'];

				$whereArr = array('id' => $category_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['category_id'] = encryptdata($category_id);

			}
			break;
}
echo json_encode($arrReturn);
