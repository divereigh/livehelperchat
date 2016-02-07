<ul class="list-unstyled">				
      <li ng-repeat="chat in transfer_dep_chats.list track by chat.id" ng-class="{'icon-user-away': chat.user_status_front == 2, 'icon-user-online': chat.user_status_front == 0}">
      	<a class="material-icons" title="ID - {{chat.id}}, {{chat.user_name}}" ng-click="lhc.previewChat(chat.id)" >info_outline</a>
	<a class="right-action-hide material-icons" ng-click="lhc.startChatTransfer(chat.id,chat.nick,chat.transfer_id)" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Add chat');?>">chat</a>
	<a class="material-icons" ng-click="lhc.startChatNewWindowTransfer(chat.id,chat.nick,chat.transfer_id)" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in a new window');?>">open_in_new</a>
	{{chat.nick}}, <small><i>{{chat.time_front}}</i></small>
      </li>					
</ul>
<p ng-show="transfer_dep_chats.list.length == 0"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('pagelayout/pagelayout','Empty...');?></p>

