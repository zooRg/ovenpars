<?php
/* Smarty version 3.1.33, created on 2019-11-21 00:48:16
  from 'D:\OServer\OSPanel\domains\ovenpars\manager\templates\default\element\tv\renders\input\richtext.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd5b4a0e345a0_59960508',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '477de0de7a660c842e3e9e1ec457d0f71f554920' => 
    array (
      0 => 'D:\\OServer\\OSPanel\\domains\\ovenpars\\manager\\templates\\default\\element\\tv\\renders\\input\\richtext.tpl',
      1 => 1574274409,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd5b4a0e345a0_59960508 (Smarty_Internal_Template $_smarty_tpl) {
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
