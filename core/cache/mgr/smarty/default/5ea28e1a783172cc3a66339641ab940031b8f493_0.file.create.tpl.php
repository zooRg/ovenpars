<?php
/* Smarty version 3.1.33, created on 2019-11-20 16:10:25
  from 'F:\OSPanel\OSPanel\domains\ovenpars\manager\templates\default\resource\create.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5dd53b4104ace8_36110270',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ea28e1a783172cc3a66339641ab940031b8f493' => 
    array (
      0 => 'F:\\OSPanel\\OSPanel\\domains\\ovenpars\\manager\\templates\\default\\resource\\create.tpl',
      1 => 1569476294,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd53b4104ace8_36110270 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="modx-panel-resource-div"></div>
<div id="modx-resource-tvs-div" class="modx-resource-tab x-form-label-left x-panel"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['tvOutput']->value)===null||$tmp==='' ? '' : $tmp);?>
</div>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hidden']->value, 'tv', false, NULL, 'tv', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tv']->value) {
?>
    <input type="hidden" id="tvdef<?php echo $_smarty_tpl->tpl_vars['tv']->value->id;?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tv']->value->default_text, ENT_QUOTES, 'UTF-8', true);?>
" />
    <?php echo $_smarty_tpl->tpl_vars['tv']->value->get('formElement');?>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<?php echo $_smarty_tpl->tpl_vars['onDocFormPrerender']->value;?>

<?php if ($_smarty_tpl->tpl_vars['resource']->value->richtext && $_smarty_tpl->tpl_vars['_config']->value['use_editor']) {?>
    <?php echo $_smarty_tpl->tpl_vars['onRichTextEditorInit']->value;?>

<?php }
}
}
