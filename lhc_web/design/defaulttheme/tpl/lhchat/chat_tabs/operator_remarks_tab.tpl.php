<?php include(erLhcoreClassDesign::designtpl('lhchat/chat_tabs/operator_remarks_tab_pre.tpl.php'));?>
<?php if ($operator_remarks_tab_enabled == true) : ?>
<li role="presentation"><a href="#main-user-info-remarks-<?php echo $chat->id?>" aria-controls="main-user-info-remarks-<?php echo $chat->id?>" role="tab" data-toggle="tab" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','Remarks')?>"><i class="icon-pencil"></i></a></li>
<?php endif;?>