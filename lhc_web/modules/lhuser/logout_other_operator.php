<?php
	$currentUser = erLhcoreClassUser::instance();
	//only an admin user can do this
	if (!$currentUser->hasAccessTo('lhsystem','use')) die(json_encode(array('error' => 'true')));

	//Get session id of remote user (operator) we wish to logout					
	$q = ezcDbInstance::get()->createSelectQuery();
	$q->select('session_id')->from( 'lh_users' )->where($q->expr->eq( 'id', $q->bindValue( $Params['user_parameters']['user_id'])));
	$stmt = $q->prepare();
	$stmt->execute();
	$result = $stmt->fetchAll();
	$target_operator_session_id = $result[0]['session_id'];
	
	error_log("TARGET SESSION = ".$target_operator_session_id);
	//store current session id before we load remote users session
	$current_user_session_id=session_id();
	//close current session before we switch to the new one
	error_log("CURRENT SESSION = ".$current_user_session_id);
	session_write_close();
	//open the target session
	session_id($target_operator_session_id);
	session_start();

	//below has been adaped from lhUser->logout() (lhc_web\lib\core\lhuser\lhuser.php)
	if (isset($_SESSION['lhc_access_array'])){ unset($_SESSION['lhc_access_array']); }
	if (isset($_SESSION['lhc_access_timestamp'])){ unset($_SESSION['lhc_access_timestamp']); }
	if (isset($_SESSION['lhc_user_id'])){ unset($_SESSION['lhc_user_id']); }
	if (isset($_SESSION['lhc_csfr_token'])){ unset($_SESSION['lhc_csfr_token']); }
	if (isset($_SESSION['lhc_user_timezone'])){ unset($_SESSION['lhc_user_timezone']); }
	if (isset($_SESSION['lhc_chat_config'])){ unset($_SESSION['lhc_chat_config']); }
	 
	error_log("COOKIE = ".$_COOKIE['lhc_rm_u']); 
	if ( isset($_COOKIE['lhc_rm_u']) ) {
		unset($_COOKIE['lhc_rm_u']);
		setcookie('lhc_rm_u','',time()-31*24*3600,'/');
	};
	error_log("User_ID = ".$Params['user_parameters']['user_id']); 
	if (is_numeric($Params['user_parameters']['user_id'])) {
		
		$q = ezcDbInstance::get()->createDeleteQuery();
		
		// User remember
		$q->deleteFrom( 'lh_users_remember' )->where( $q->expr->eq( 'user_id', $q->bindValue($Params['user_parameters']['user_id']) ) );
		$stmt = $q->prepare();
		$stmt->execute();
			   
		$db = ezcDbInstance::get();
		$db->query('UPDATE lh_userdep SET last_activity = 0 WHERE user_id = '.$Params['user_parameters']['user_id']);
	}
		   
	//$this->session->destroy();
	unset( $_SESSION['lhc_ezcAuth_id'] );
	unset( $_SESSION['lhc_ezcAuth_timestamp'] );
		   
	session_regenerate_id(true);

	//close target session
	session_write_close();


	//reopen the "real" session
	session_id($current_user_session_id);
	session_start();

	echo json_encode(array('error' => 'false'));
	//erLhcoreClassModule::redirect('user/login');
	exit;
