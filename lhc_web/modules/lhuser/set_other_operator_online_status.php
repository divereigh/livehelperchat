
<?php
	//echo $Params['user_parameters']['user_id'];
	//echo $Params['user_parameters']['online_status'];
	$currentUser = erLhcoreClassUser::instance();
	//must be logged in
	if (!$currentUser->isLogged()) die(json_encode(array('error' => 'true')));

	//only an admin user can do this
	if (!$currentUser->hasAccessTo('lhsystem','use')) die(json_encode(array('error' => 'true')));
	
	//Get session id of remote user (operator) we wish to logout					
	$q = ezcDbInstance::get()->createSelectQuery();
	$q->select('session_id')->from( 'lh_users' )->where($q->expr->eq( 'id', $q->bindValue( $Params['user_parameters']['user_id'])));
	$stmt = $q->prepare();
	$stmt->execute();
	$result = $stmt->fetchAll();
	$target_operator_session_id = $result[0]['session_id'];
	
	//store current session id before we load remote users session
	$current_user_session_id=session_id();
	//close current session before we switch to the new one
	session_write_close();
	//open the target session
	session_id($target_operator_session_id);
	session_start();

	
	$UserData = $currentUser->getUserData(true);

	if ($Params['user_parameters']['online_status'] == '0') {
		$UserData->hide_online = 0;
	} else {
		$UserData->hide_online = 1;
	}

	erLhcoreClassUser::getSession()->update($UserData);
	erLhcoreClassUserDep::setHideOnlineStatus($UserData);
	
	//close target session
	session_write_close();

	//reopen the "real" session
	session_id($current_user_session_id);
	session_start();

	echo json_encode(array('error' => 'false'));
	exit;