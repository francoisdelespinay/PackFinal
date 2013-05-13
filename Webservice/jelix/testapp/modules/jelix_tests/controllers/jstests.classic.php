<?php
/**
* @package     testapp
* @subpackage  testapp module
* @author      Laurent Jouanneau
* @contributor Julien Issler
* @copyright   2005-2006 Laurent Jouanneau
* @copyright   2009 Julien Issler
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

class jstestsCtrl extends jController {


  function jforms() {
      $rep = $this->getResponse('html', true);
      $rep->setXhtmlOutput(false);
      $rep->title = 'Unit tests on jforms';
      $rep->bodyTpl = 'jstest_jforms';
      $rep->addCssLink(jApp::config()->urlengine['basePath'].'qunit/testsuite.css');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/jquery.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/include/jquery.include.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'js/jforms_jquery.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'wymeditor/jquery.wymeditor.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'wymeditor/config/default.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'js/jforms/datepickers/default/init.js');

      $rep->addJsLink(jApp::config()->urlengine['basePath'].'qunit/testrunner.js');

      return $rep;
  }

  function jsonrpc() {
      $rep = $this->getResponse('html', true);
      $rep->setXhtmlOutput(false);
      $rep->title = 'Unit tests for jsonrpc';
      $rep->bodyTpl = 'jstest_jsonrpc';
      $rep->addCssLink(jApp::config()->urlengine['basePath'].'qunit/testsuite.css');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/jquery.js');
      $rep->addJsLink(jApp::config()->urlengine['basePath'].'qunit/testrunner.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'js/json.js');
      return $rep;
  }

  function jsonrpc2() {
      $rep = $this->getResponse('html', true);
      $rep->setXhtmlOutput(false);
      $rep->title = 'Unit tests for jsonrpc';
      $rep->bodyTpl = 'jstest_jsonrpc2';
      $rep->addCssLink(jApp::config()->urlengine['basePath'].'qunit/testsuite.css');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/jquery.js');
      $rep->addJsLink(jApp::config()->urlengine['basePath'].'qunit/testrunner.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'js/json2.js');
      return $rep;
  }

  function testinclude() {
      $rep = $this->getResponse('html', true);
      $rep->setXhtmlOutput(false);
      $rep->title = 'Unit tests for jquery include plugin';
      $rep->bodyTpl = 'jstest_include';
      $rep->addCssLink(jApp::config()->urlengine['basePath'].'qunit/testsuite.css');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/jquery.js');
      $rep->addJsLink(jApp::config()->urlengine['basePath'].'qunit/testrunner.js');
      $rep->addJsLink(jApp::config()->urlengine['jelixWWWPath'].'jquery/include/jquery.include.js');
      return $rep;
  }

  function testincludejsinc3() {
    $rep = $this->getResponse('text', true);
    $rep->addHttpHeader('Content-Type','application/javascript',true);
    $rep->content= '$("#includeresult").text($("#includeresult").text()+"INC3");';
    sleep(1);
    return $rep;
  }
}
