<script> $(function() { $( "#online_operators" ).resizable({ 
                stop        : onDashWidgetResize, 
                containment : 'parent', 
                handles     : "all", 
                autoHide    : true, 
                knobHandles : true,
				resize        : onTest				
});});</script>

<div id="online_operators" class="panel panel-default panel-dashboard" data-panel-id="online_operators" ng-init="lhc.getToggleWidget('ooperators_widget_exp')">
	<div class="panel-heading">
		<i class="material-icons chat-active">account_box</i><?php include(erLhcoreClassDesign::designtpl('lhfront/dashboard/panels/titles/online_operators.tpl.php'));?> ({{online_op.list.length}}{{online_op.list.length == lhc.limito ? '+' : ''}})</a>
		<a title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('pagelayout/pagelayout','collapse/expand')?>" ng-click="lhc.toggleWidget('ooperators_widget_exp')" class="fs24 pull-right material-icons exp-cntr">{{lhc.toggleWidgetData['ooperators_widget_exp'] == false ? 'expand_less' : 'expand_more'}}</a>
	</div>
	<div ng-if="lhc.toggleWidgetData['ooperators_widget_exp'] !== true">  
  
        <?php $optinsPanel = array('panelid' => 'operatord', 'limitid' => 'limito', 'disable_product' => true); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhfront/dashboard/panels/parts/options.tpl.php'));?>
 
        <div class="panel-list">
			<table class="table table-condensed mb0 table-small table-fixed">
				<thead>
					<tr>
						<th width="35%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Operator');?>" class="material-icons">account_box</i></th>
						<th width="15%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Last activity ago');?>" class="material-icons">access_time</i></th>
						<th width="15%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Active chats');?>" class="material-icons chat-active">chat</i></th>
						<?php if ($currentUser->hasAccessTo('lhsystem','use')) : ?>
							<th width="15%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Department');?>" class="material-icons">home</i></th>
							<th width="10%"></th>
							<th width="10%"></th>
						<?php else: ?>
							<th width="30%"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Department');?>" class="material-icons">home</i></th>
						<?php endif; ?> 
					</tr>
				</thead>
				<tr ng-repeat="operator in online_op.list track by operator.id">
					<td><a ng-show="operator.user_id != <?php echo erLhcoreClassUser::instance()->getUserID();?>" href="#" ng-click="lhc.startChatOperator(operator.user_id)" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/syncadmininterface','Start chat');?>"><i class="material-icons">chat</i></a> {{operator.name_support}}</td>
					<td>
						<div class="abbr-list" title="{{operator.lastactivity_ago}}">{{operator.lastactivity_ago}}</div>
					</td>
					<td>{{operator.active_chats}}</td>
					<td><div class="abbr-list" title="{{operator.departments_names.join(', ')}}">{{operator.departments_names.join(", ")}}</div></td>
					<?php if ($currentUser->hasAccessTo('lhsystem','use')) : ?>
						<td><a ng-show="operator.user_id != <?php echo erLhcoreClassUser::instance()->getUserID();?>" href="#" ng-click="lhc.logoutOtherOperator(operator.user_id)" title="Logout {{operator.name_support}}"><i class="material-icons">input</i></a></td>
						<td><a ng-show="operator.user_id != <?php echo erLhcoreClassUser::instance()->getUserID();?>" href="#" ng-click="lhc.setOtherOperatorOnlineStatus(operator.user_id,!operator.hide_online)" title="Set {{operator.name_support}} {{operator.hide_online ? 'Online' : 'Offline'}}"><i class="material-icons pull-right">{{operator.hide_online ? 'flash_off' : 'flash_on'}}</i></a></td>
					<?php endif; ?> 
				</tr>
			</table>
		</div>
		
	</div>
</div>
