<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/top_menu_extension_multiinclude.tpl.php.tpl.php'));?>	

<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/modules_permissions.tpl.php'));?>	

<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/top_menu_extension_module_multiinclude.tpl.php'));?>
		
<?php if ($useFm || $useBo || $useChatbox || $useFaq || $useQuestionary || $hasExtensionModule) : ?>
     <li>
           <a href="#"><i class="icon-info"></i><?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/extra_modules_title.tpl.php'));?><span class="glyphicon arrow"></span></a>
           <ul class="nav nav-second-level">
                <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/questionary.tpl.php'));?>
  			  
			    <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/faq.tpl.php'));?>
			  
			    <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/chatbox.tpl.php'));?>
			  	
			    <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/browseoffer.tpl.php'));?>
              
                <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/form.tpl.php'));?>
              
                <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/modules_menu/extension_module_multiinclude.tpl.php'));?>
          </ul>
    </li>
<?php endif; ?> 