<?php 
 require_once('C:\Users\www\jelix\lib\jelix/plugins/tpl/html/function.jurl.php');
function template_meta_97d51088ab89f937e06e7781e5656130($t){

}
function template_97d51088ab89f937e06e7781e5656130($t){
?><h2>Contents</h2>

<h3>Simple tests</h3>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:hello');?>">Hello world in html</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:hello', array('output'=>'text'));?>">Hello world in text</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:hello2');?>">Overloaded "Hello world" template</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:testdao');?>">Dao test</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:generateerror');?>">error on a page</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:generatewarning');?>">warning on a page</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:testminify');?>">page using minify</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'main:sitemap');?>">sitemap</a></li>
</ul>

<h3>Unit tests</h3>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'junittests~default:index');?>">PHP Unit tests</a></li>
   <li> JS unit tests :
      <ul>
        <li><a href="<?php jtpl_function_html_jurl( $t,'jelix_tests~jstests:jforms');?>">jforms</a></li>
        <li><a href="<?php jtpl_function_html_jurl( $t,'jelix_tests~jstests:jsonrpc');?>">jsonrpc</a></li>
        <li><a href="<?php jtpl_function_html_jurl( $t,'jelix_tests~jstests:jsonrpc2');?>">jsonrpc (with json2.js)</a></li>
        <li><a href="<?php jtpl_function_html_jurl( $t,'jelix_tests~jstests:testinclude');?>">include</a></li>
      </ul>
   </li>
</ul>

<h3>Forms</h3>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'sampleform:status');?>">Session data</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'samplecrud:index');?>">Crud form</a></li>
</ul>
<p>Simple form (singleton)</p>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'sampleform:newform');?>">New form</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'sampleform:show');?>">See the form</a> (<a href="<?php jtpl_function_html_jurl( $t,'sampleform:show', array('full'=>1));?>">full</a>)</li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'sampleform:ok');?>">Results</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'sampleform:destroy');?>">Destroy the form</a></li>
</ul>

<p>Multiple instance of a form</p>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'forms:newform');?>">New form</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'forms:listform');?>">Instance list</a></li>
</ul>



<h3>Syndication examples</h3>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'syndication:rss');?>">Rss 2.0</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'syndication:atom');?>">Atom 1.0</a></li>
</ul>

<h3>Soap tests</h3>
<ul>
   <li><a href="<?php jtpl_function_html_jurl( $t,'clientSoap:soapExtension');?>">client (soap extension)</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:index');?>">Web services documentation</a></li>
   <li><a href="<?php jtpl_function_html_jurl( $t,'jWSDL~WSDL:wsdl', array('service'=>'testapp~soap'));?>">WSDL</a></li>
</ul>
<?php 
}
?>