<div class="panel panel-default panel-dashboard" data-panel-id="transfered_dep_chats" ng-init="lhc.getToggleWidget('trdchats_widget_exp')">
	<div class="panel-heading">
		<i class="material-icons chat-pending">chat</i> <?php include(erLhcoreClassDesign::designtpl('lhfront/dashboard/panels/titles/transfered_dep_chats.tpl.php'));?> ({{transfer_dep_chats.list.length}})
		<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('pagelayout/pagelayout','collapse/expand')?>" ng-click="lhc.toggleWidget('trdchats_widget_exp')" class="fs24 pull-right material-icons exp-cntr">{{lhc.toggleWidgetData['trdchats_widget_exp'] == false ? 'expand_less' : 'expand_more'}}</a>
	</div>
	<div ng-if="lhc.toggleWidgetData['trdchats_widget_exp'] !== true">
	    	<div ng-if="transfer_dep_chats.list.length > 0" class="panel-list">
       	 	<table class="table table-condensed mb0 table-small table-fixed">
       	         	<thead>
       	                		<tr>
       	                			<th width="60%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Visitor');?>" class="material-icons">face</i></th>
       	                			<th width="40%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Created');?>" class="material-icons">access_time</i></th>
       	                		</tr>
       	                	</thead>
       	                	<tr ng-repeat="chat in transfer_dep_chats.list">
       	                		<td>
       	                			<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in a new window');?>" class="material-icons" ng-click="lhc.startChatNewWindowTransfer(chat.id,chat.nick,chat.transfer_id)">open_in_new</a>
						<span ng-if="chat.country_code != ''"><img ng-src="<?php echo erLhcoreClassDesign::design('images/flags');?>/{{chat.country_code}}.png" alt="{{chat.country_name}}" title="{{chat.country_name}}" />
						</span>
						<a ng-click="lhc.previewChat(chat.id)" class="material-icons">info_outline</a>
						<a ng-click="lhc.startChatTransfer(chat.id,chat.nick,chat.transfer_id)" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Accept chat');?>">{{chat.nick}}</a>
       	                 	</td>
       	                 	<td nowrap="nowrap">
						<div class="abbr-list">{{chat.time_front}}</div>
       	                 	</td>			
       	                 </tr>
			</table>
       	        	<div ng-if="transfer_dep_chats.list.length == 0" class="m10 alert alert-info"><i class="material-icons">search</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Nothing found')?>...</div>
    		</div>
	</div>
</div>


