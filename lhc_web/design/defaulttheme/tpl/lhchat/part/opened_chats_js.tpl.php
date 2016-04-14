<?php
$chatsOpen = CSCacheAPC::getMem()->getArray('lhc_open_chats');
if (!empty($chatsOpen)){
	$chats = erLhcoreClassChat::getList(array('filterin' => array('id' => $chatsOpen)));

	// Delete any old chat if it exists
	$deleteKeys = array_diff($chatsOpen, array_keys($chats));
	foreach ($deleteKeys as $chat_id) {
		CSCacheAPC::getMem()->removeFromArray('lhc_open_chats', $chat_id);
	}

	foreach ($chats as $chat ){
		if (erLhcoreClassChat::hasAccessToRead($chat)){
			$name = $chat->nick;
			//get correct name to show in tab for operator to operator chats
			if ($chat->status == erLhcoreClassModelChat::STATUS_OPERATORS_CHAT) {
				$currentUser = erLhcoreClassUser::instance();
				
				//Gets other user/operators id, if chat user id is the current user
				//Only works if chat has at least one message from the other user in it
				/*$db = ezcDbInstance::get();
				$stmt = $db->prepare("SELECT * FROM lh_msg WHERE chat_id='".$chat->id."' AND user_id!='".$chat->user_id."' AND user_id>'0' LIMIT 1");//		
				$stmt->execute();

				$rows = $stmt->fetchAll();
				$msg = $rows[0];
				$otherUser = erLhcoreClassUser::getUserUsingID($msg['user_id']);*/
					
				//is current user the caller (chat initiator)
				if ($currentUser->getUserID() != $chat->user_id) {
					//set tab name to callee (chat reciever) of the chat
					$otherUser = erLhcoreClassUser::getUserUsingID($chat->user_id);
					
					if ($otherUser!=null) {
						$name = $otherUser['name'].' '.$otherUser['surname'];
					}
				}
							
			}
			echo "lhinst.startChat('$chat->id',$('#tabs'),'".erLhcoreClassDesign::shrt($name,15,'...',30,ENT_QUOTES)."',false);";
		} else {
			CSCacheAPC::getMem()->removeFromArray('lhc_open_chats', $chat->id);
		}
	}
}
?>