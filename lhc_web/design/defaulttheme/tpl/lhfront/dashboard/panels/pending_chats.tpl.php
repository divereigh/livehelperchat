<script> $(function() { $( "#pending_chats" ).resizable({ 
                stop        : onDashWidgetResize, 
                containment : 'parent', 
                handles     : "all", 
                autoHide    : true, 
                knobHandles : true,
				resize        : onTest				
});});</script>
    
<div id="pending_chats" class="panel panel-default panel-dashboard" data-panel-id="pending_chats" ng-init="lhc.getToggleWidget('pchats_widget_exp');lhc.getToggleWidget('pending_chats_sort')">
	<div class="panel-heading">
		<a href="<?php echo erLhcoreClassDesign::baseurl('chat/list')?>/(chat_status)/0"><i class="material-icons chat-pending">chat</i> <?php include(erLhcoreClassDesign::designtpl('lhfront/dashboard/panels/titles/pending_chats.tpl.php'));?> ({{pending_chats.list.length}}{{pending_chats.list.length == lhc.limitp ? '+' : ''}})</a>
		<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('pagelayout/pagelayout','collapse/expand')?>" ng-click="lhc.toggleWidget('pchats_widget_exp')" class="fs24 pull-right material-icons exp-cntr">{{lhc.toggleWidgetData['pchats_widget_exp'] == false ? 'expand_less' : 'expand_more'}}</a>
	</div>
	<div ng-if="lhc.toggleWidgetData['pchats_widget_exp'] !== true">  
         
          <?php $optinsPanel = array('panelid' => 'pendingd','limitid' => 'limitp'); ?>
	      <?php include(erLhcoreClassDesign::designtpl('lhfront/dashboard/panels/parts/options.tpl.php'));?>
			
          <div class="panel-list" ng-if="pending_chats.list.length > 0">
			<table class="table table-condensed mb0 table-small table-fixed">
				<thead>
					<tr>
						<th width="60%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Visitor')?>" class="material-icons">face</i><a ng-click="lhc.toggleWidget('pending_chats_sort',true)"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Sort')?>" class="material-icons">{{lhc.toggleWidgetData['pending_chats_sort'] == false ? 'trending_up' : 'trending_down'}}</i></a></th>
						<th width="20%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Wait time')?>" class="material-icons">access_time</i></th>
						<th width="20%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Department');?>" class="material-icons">home</i></th>
					</tr>
				</thead>
				<tr ng-repeat="chat in pending_chats.list track by chat.id" ng-class="{'user-away-row': chat.user_status_front == 2, 'user-online-row': chat.user_status_front == 0, 'priority-dept': chat.additional_data_array[4].value == true}">
					<td>
						<div data-chat-id="{{chat.id}}" data-toggle="popover" data-placement="top" class="abbr-list" >
							<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhchat','deleteglobalchat') || (erLhcoreClassUser::instance()->hasAccessTo('lhchat','deletechat') && $chat->user_id == erLhcoreClassUser::instance()->getUserID())) : ?>
							<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Delete chat')?>" class="material-icons pull-right" ng-click="lhc.deleteChat(chat.id)">delete</a>
							<?php endif; ?>
							<span ng-if="chat.country_code != undefined">
								<img ng-src="<?php echo erLhcoreClassDesign::design('images/flags');?>/{{chat.country_code}}.png" alt="{{chat.country_name}}" title="{{chat.country_name}}" />&nbsp;
							</span>
							<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhchat','singlechatwindow')) : ?>
							<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Open in a new window');?>" class="material-icons" ng-click="lhc.startChatNewWindow(chat.id,chat.nick)">open_in_new</a>
							<?php endif; ?>
<?php if ((int)erLhcoreClassModelChatConfig::fetch('simplified_layout')->current_value == 0) : ?>
							<a class="material-icons" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Redirect user to contact form.');?>" ng-click="lhc.redirectContact(chat.id,'<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Are you sure?');?>')">reply</a>
<?php endif;?>
							<a ng-click="lhc.previewChat(chat.id)" class="material-icons">info_outline</a>
							<a ng-click="lhc.startChat(chat.id,chat.nick)" title="{{chat.nick}}">{{chat.nick}}</a>
							<span ng-if="chat.additional_data_array[4].value == true">ABA Member</span>
						</div>

						<div id="popover-title-{{chat.id}}" class="hide">
						  {{chat.nick}} [{{chat.id}}]
						</div>

						<div id="popover-content-{{chat.id}}" class="hide">
						    <i class="material-icons">access_time</i>{{chat.time_created_front}}<br/>
							<i class="material-icons">account_box</i>{{chat.plain_user_name ? chat.plain_user_name : '-'}}<br />
							<i class="material-icons">home</i>{{chat.department_name}}<br />
							<span ng-if="chat.additional_data_array[4].value == true"><i class="material-icons">done</i>ABA Member</span>
							<span ng-show="chat.product_name"><i class="material-icons">&#xE8CC;</i>{{chat.product_name}}</span>
						</div>

					</td>
					<td>
						<div class="abbr-list" title="{{chat.wait_time_pending}}">{{chat.wait_time_pending}}</div>
					</td>
					<td>
						<div class="abbr-list" title="{{chat.department_name}}{{chat.product_name ? ' | '+chat.product_name : ''}}">{{chat.department_name}}{{chat.product_name ? ' | '+chat.product_name : ''}}</div>
					</td>
				</tr>
			</table>
		</div>
		
		<div ng-if="pending_chats.list.length == 0" class="m10 alert alert-info">
<?php if ((int)erLhcoreClassModelChatConfig::fetch('simplified_layout')->current_value == 0) : ?>
			<i class="material-icons">search</i><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Nothing found')?>...
<?php endif; ?>
			&nbsp;
		</div>
		
	</div>
</div>
