<h4><span class="label label-success"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Online');?></span></h4>
<?php 
    $departments = erLhcoreClassModelDepartament::getList(array_merge($departments_filter['filter'],array('sort' => 'sort_priority ASC, name ASC')));      		
    $onlineDepartments = erLhcoreClassChat::getLoggedDepartmentsIds(array_keys($departments), $departments_filter['explicit']);
    foreach ($departments as $departament) : if ($departament->id !== $departments_filter['dep_id'] && in_array($departament->id, $onlineDepartments)) : ?>
   <div class="checkbox"><label><input type="radio" name="DepartamentID<?php echo $departments_filter['chat_id']?>" value="<?php echo $departament->id?>"/> <?php echo htmlspecialchars($departament->name)?></label></div>
<?php endif; endforeach; ?>

<?php if ((int)erLhcoreClassModelChatConfig::fetch('simplified_layout')->current_value == 0) : ?>
<h4><span class="label label-default"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Offline');?></span></h4>
<?php foreach ($departments as $departament) : if ($departament->id !== $departments_filter['dep_id'] && !in_array($departament->id, $onlineDepartments)) : ?>
   <div class="checkbox"><label><input type="radio" name="DepartamentID<?php echo $departments_filter['chat_id']?>" value="<?php echo $departament->id?>"/> <?php echo htmlspecialchars($departament->name)?></label></div>
<?php endif; endforeach; ?>
<?php endif; ?>
