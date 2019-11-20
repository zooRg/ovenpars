<?php
/* Smarty version 3.1.33, created on 2019-11-20 09:59:47
  from 'F:\OSPanel\OSPanel\domains\ovenpars\manager\templates\default\element\tv\renders\input\richtext.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd4e4636a2539_97495870',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60b0f26b96f97d3142ecb0c3f7649c47b6c5ce28' => 
    array (
      0 => 'F:\\OSPanel\\OSPanel\\domains\\ovenpars\\manager\\templates\\default\\element\\tv\\renders\\input\\richtext.tpl',
      1 => 1569476292,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd4e4636a2539_97495870 (Smarty_Internal_Template $_smarty_tpl) {
?><textarea id="tv<?php echo $_smarty_tpl->tpl_vars['tv']->value->id;?>
" name="tv<?php echo $_smarty_tpl->tpl_vars['tv']->value->id;?>
" class="modx-richtext" onchange="MODx.fireResourceFormChange();"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tv']->value->get('value'), ENT_QUOTES, 'UTF-8', true);?>
</textarea>

<?php echo '<script'; ?>
 type="text/javascript">

Ext.onReady(function() {
    
    MODx.makeDroppable(Ext.get('tv<?php echo $_smarty_tpl->tpl_vars['tv']->value->id;?>
'));
    
});
<?php echo '</script'; ?>
><?php }
}
