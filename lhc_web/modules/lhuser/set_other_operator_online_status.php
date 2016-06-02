
<?php

	$currentUser = erLhcoreClassUser::instance();
	//must be logged in
	if (!$currentUser->isLogged()) die(json_encode(array('error' => 'true')));

	//only an admin user can do this
	if (!$currentUser->hasAccessTo('lhsystem','use')) die(json_encode(array('error' => 'true')));
	
	$hide_online = 0;
	if ($Params['user_parameters']['online_status']=='true') {
		$hide_online = 1;
	} else {
		$hide_online = 0;
	}
	
	//Adapted and simplified from modules\lhuser\setoffline.php
	$db = ezcDbInstance::get();
	#erLhcoreClassUser::getSession()->update($UserData);
	$stmt = $db->prepare('UPDATE lh_users SET hide_online = :hide_online WHERE id = :user_id');
    $stmt->bindValue( ':hide_online',$hide_online);
    $stmt->bindValue( ':user_id',$Params['user_parameters']['user_id']);
    $stmt->execute();
	
	#erLhcoreClassUserDep::setHideOnlineStatus($UserData);
    $stmt = $db->prepare('UPDATE lh_userdep SET hide_online = :hide_online WHERE user_id = :user_id');
    $stmt->bindValue( ':hide_online',$hide_online);
    $stmt->bindValue( ':user_id',$Params['user_parameters']['user_id']);
    $stmt->execute();
	
	echo json_encode(array('error' => 'false'));
	exit;