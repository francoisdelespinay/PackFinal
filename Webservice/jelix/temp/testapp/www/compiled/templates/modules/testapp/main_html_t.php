<?php 
function template_meta_fb402e73d5a3f5675274431fce3c28fb($t){

}
function template_fb402e73d5a3f5675274431fce3c28fb($t){
?><div id="header">
<?php echo $t->_vars['page_title']; ?>

</div>

<div id="main">
<?php echo $t->_vars['MAIN']; ?>

</div>

<div id="sidemenu">
   <?php echo $t->_vars['menu']; ?>

</div>

<div id="footer">
HTML page generated at <?php echo $t->_vars['j_datenow']; ?> - <?php echo $t->_vars['j_timenow']; ?> by <?php echo jLocale::get('jelix~jelix.framework.name'); ?>

</div><?php 
}
?>