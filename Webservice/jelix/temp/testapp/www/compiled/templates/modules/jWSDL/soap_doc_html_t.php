<?php 
 require_once('C:\Users\www\jelix\lib\jelix/plugins/tpl/html/meta.html.php');
 require_once('C:\Users\www\jelix\lib\jelix/plugins/tpl/common/modifier.replace.php');
 require_once('C:\Users\www\jelix\lib\jelix/plugins/tpl/html/function.jurl.php');
function template_meta_ae02d44f5df26c28fe8467dcc54f3790($t){
jtpl_meta_html_html( $t,'css',$t->_vars['j_jelixwww'].'design/jelix.css');

}
function template_ae02d44f5df26c28fe8467dcc54f3790($t){
?>

<h1 class="apptitle">Web services documentation<br/><span class="welcome"><?php echo jtpl_modifier_common_replace($t->_vars['doc']['class']->name,'Ctrl',''); ?>

        <a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:wsdl', array("service"=>$t->_vars['doc']['service']));?>">[WSDL]</a></span></h1>

<div id="page">
    <!--<div class="logo"><img src="<?php echo $t->_vars['j_jelixwww']; ?>design/images/logo_jelix_moyen.png" alt=""/></div>-->

    <div class="menu">
        <h3>Services</h3>
        <ul>
        <?php foreach($t->_vars['doc']['menu'] as $t->_vars['webservice']):?>
        <li><a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:index', array("service"=>$t->_vars['webservice']['service']));?>"><?php echo $t->_vars['webservice']['class']; ?></a></li>
        <?php endforeach;?>
        </ul>
    </div>

    <div class="monbloc">
        <h2>Full description</h2>
        <div class="blockcontent">
            <p><?php echo $t->_vars['doc']['class']->fullDescription; ?></p>
        </div>
    </div>
    <?php if(sizeof($t->_vars['doc']['class']->properties)):?>

    <div class="monbloc">
        <h2>Properties</h2>
        <div class="blockcontent">
        <dl>
        <?php foreach($t->_vars['doc']['class']->properties as $t->_vars['propertie']):?>
            <dt><?php echo $t->_vars['propertie']->name; ?></dt>
            <dd>
            <?php if($t->_vars['propertie']->type == ''):?>

                <div class='docError'>Missing type info</div>
            <?php else:?>
                <ul>
                <?php $t->_vars['propertieClassName']=str_replace('[]' , '',str_replace('[=>]' , '',$t->_vars['propertie']->type));?>
                <?php if($t->_vars['propertieClassName'] =='int' || $t->_vars['propertieClassName'] =='string' || $t->_vars['propertieClassName'] =='boolean' || $t->_vars['propertieClassName'] =='double' || $t->_vars['propertieClassName'] =='float' ||$t->_vars['propertieClassName'] =='void'):?>
                <li>type <?php echo $t->_vars['propertie']->type; ?></li>
                <?php else:?>

                <li>type <a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:index', array('service'=>$t->_vars['doc']['service'], 'className'=>str_replace('[]' , '',$t->_vars['propertieClassName'])));?>"><?php echo $t->_vars['propertie']->type; ?></a></li>
                <?php endif;?>
                </ul>
            <?php endif;?>
            <?php echo $t->_vars['propertie']->fullDescription; ?>

            </dd>
        <?php endforeach;?>
        </dl>

        </div>
    </div>
    <?php endif;?>

    <?php if(sizeof($t->_vars['doc']['class']->methods)):?>
    <div class="monbloc">
        <h2>Methods</h2>
        <div class="blockcontent">
            <dl>
            <?php foreach($t->_vars['doc']['class']->methods as $t->_vars['method']):?>
            <dt><?php echo $t->_vars['method']->name; ?> (
                    <?php $t->_vars['i']=0;?>

                    <?php foreach($t->_vars['method']->parameters as $t->_vars['param']):?>
                    <?php echo $t->_vars['param']->name; ?><?php $t->_vars['i']=$t->_vars['i']+1;?><?php if($t->_vars['i']!=(sizeof($t->_vars['method']->parameters))):?>,<?php endif;?><?php endforeach;?>

                    )</dt>
            <dd>
                <?php if($t->_vars['method']->return == ''):?>
                    <div class='docError'>Missing return value</div>
                <?php else:?>
                    <ul>
                    <?php $t->_vars['returnClassName']=str_replace('[]' , '',str_replace('[=>]' , '',$t->_vars['method']->return));?>
                    <?php if($t->_vars['returnClassName'] =='int' || $t->_vars['returnClassName'] =='string' || $t->_vars['returnClassName'] =='boolean' || $t->_vars['returnClassName'] =='double' || $t->_vars['returnClassName'] =='float' || $t->_vars['returnClassName'] =='void'):?>
                    <li>return <?php echo $t->_vars['method']->return; ?></li>
                    <?php else:?>

                    <li>return <a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:index', array('service'=>$t->_vars['doc']['service'], 'className'=>$t->_vars['returnClassName']));?>"><?php echo $t->_vars['method']->return; ?></a></li>
                    <?php endif;?>
                    </ul>
                <?php endif;?>
                <?php echo $t->_vars['method']->fullDescription; ?>

            </dd>
            <?php endforeach;?>
            </dl>
        </div>
    </div>
    <?php endif;?>

    <div id="jelixpowered"><img src="<?php echo $t->_vars['j_jelixwww']; ?>design/images/jelix_powered.png" alt="jelix powered" /></div>
</div>
<?php 
}
?>