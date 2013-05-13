<?php
/**
* @package     testapp
* @subpackage  unittest module
* @author      Bastien Jaillot
* @contributor Laurent Jouanneau, Steven Jehannet
* @copyright   2008 Bastien Jaillot, 2009 Laurent Jouanneau, 2010 Steven Jehannet
* @link        http://jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

require_once(JELIX_LIB_PATH.'forms/jFormsBase.class.php');
require_once(JELIX_LIB_PATH.'forms/jFormsControl.class.php');
require_once(JELIX_LIB_PATH.'forms/jFormsDatasource.class.php');
require_once(JELIX_LIB_UTILS_PATH.'jDatatype.class.php');
require_once(JELIX_LIB_PATH.'forms/jFormsDataContainer.class.php');

class tesMForm extends jFormsBase {
    function addCtrl($control, $reset=true){
        if($reset){
            $this->controls = array();
            $this->container->data = array();
        }
        $this->addControl($control);
    }
}

class UTjformsGetModifiedControls extends jUnitTestCaseDb {
    protected $form;
    protected $container;
    function setUp() {
        $this->container = new jFormsDataContainer('','');
        $this->form = new tesMForm('foo',$this->container);

        $ctrl = new jFormsControlInput('inputctrl');
        $ctrl->setData('toto');
        $this->form->addCtrl($ctrl);
        $this->form->setData('inputctrl', 'toto');

        $ctrl = new jFormsControlCheckbox('chckbxctrl');
        $ctrl->datatype=new jDatatypeBoolean();
        $this->form->addCtrl($ctrl, false);
        $this->form->setData('chckbxctrl', '1');
        $ctrl= new jFormsControlcheckbox('chckbxctrl1');
        $ctrl->defaultValue='0';
        $ctrl->valueOnCheck='1';
        $ctrl->valueOnUncheck='0';
        $this->form->addControl($ctrl);
        $ctrl= new jFormsControlcheckbox('chckbxctrl2');
        $ctrl->defaultValue='1';
        $ctrl->valueOnCheck='1';
        $ctrl->valueOnUncheck='0';
        $this->form->addControl($ctrl);
        
        $ctrl= new jFormsControlListbox('list');
        $ctrl->multiple=true;
        $ctrl->datasource = new jFormsStaticDatasource();
        $ctrl->datasource->data = array('a'=>'aaa', 'b'=>'bbb', 'c'=>'123', 'd'=>'456');
        $this->form->addCtrl($ctrl, false);
        $this->form->setData('list', array('bbb','123'));
    }
    
    function testinitModifiedControlsList() {
        $this->form->initModifiedControlsList();

        $this->assertIdentical($this->form->getContainer()->data, $this->form->getContainer()->originalData);

        $initForm = array (
          'inputctrl' => 'toto',
          'chckbxctrl' => '1',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array('bbb','123'),
          );
        $this->assertIdentical($initForm, $this->form->getContainer()->originalData);
    }
    
    function testModifiedControls1() {
        $this->form->initModifiedControlsList();
        
        $this->form->setData('chckbxctrl', '0');
        $newForm = array (
          'inputctrl' => 'toto',
          'chckbxctrl' => '0',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array('bbb','123'),);
        $this->assertIdentical($newForm, $this->form->getContainer()->data);
        $modifiedControls = array (
            'chckbxctrl' => '1');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());
        $this->form->setData('inputctrl', 'tata');
        $newForm = array (
          'inputctrl' => 'tata',
          'chckbxctrl' => '0',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array('bbb','123'),);
        $this->assertIdentical($newForm, $this->form->getContainer()->data);
        $modifiedControls = array (
           'inputctrl' => 'toto' ,
            'chckbxctrl' => '1');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());


        $this->form->setData('list', array('123'));
        $newForm = array (
          'inputctrl' => 'tata',
          'chckbxctrl' => '0',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array('123'),);
        $this->assertIdentical($newForm, $this->form->getContainer()->data);
        $modifiedControls = array (
           'inputctrl' => 'toto' ,
            'chckbxctrl' => '1',
            'list'=>array('bbb','123'));
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('list', array());
        $newForm = array (
          'inputctrl' => 'tata',
          'chckbxctrl' => '0',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array(),);
        $this->assertIdentical($newForm, $this->form->getContainer()->data);
        $modifiedControls = array (
           'inputctrl' => 'toto' ,
            'chckbxctrl' => '1',
            'list'=>array('bbb','123'));
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        // despite all changes : originalData hasn't changed
        $initForm = array (
          'inputctrl' => 'toto',
          'chckbxctrl' => '1',
          'chckbxctrl1'=>'0',
          'chckbxctrl2'=>'1',
          'list'=>array('bbb','123'),);
        $this->assertIdentical($initForm, $this->form->getContainer()->originalData);
    }


    function testModifiedInput() {
        $this->form->setData('inputctrl', null);
        $this->form->initModifiedControlsList();

        $this->form->setData('inputctrl', '');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('inputctrl', 'hey');
        $modifiedControls = array (
           'inputctrl' => null);
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());
    }


    function testModifiedNumericalValue() {
        $this->form->setData('chckbxctrl', 0);
        $this->form->initModifiedControlsList();

        $this->form->setData('chckbxctrl', '0');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', 'on');
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', '');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', null);
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', '1');
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', true);
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());


        $this->form->setData('chckbxctrl', null);
        $this->form->initModifiedControlsList();

        $this->form->setData('chckbxctrl', '0');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', 'on');
        $modifiedControls = array ('chckbxctrl'=>'0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());


        $c = $this->form->getControl('chckbxctrl');
        $c->valueOnCheck='0';
        $c->valueOnUncheck='1';

        $this->form->setData('chckbxctrl', 0);
        $this->form->initModifiedControlsList();

        $this->form->setData('chckbxctrl', '0');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', 0);
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', 'on');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', '');
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', null);
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', '1');
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('chckbxctrl', true);
        $modifiedControls = array ('chckbxctrl'=> '0');
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

    }

    function testModifiedList() {
        $this->form->setData('list', array());
        $this->form->initModifiedControlsList();

        $this->form->setData('list', '');
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());

        $this->form->setData('list', array('123'));
        $modifiedControls = array (
           'list' => array());
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());
        
        $this->form->setData('list', array('123','aaa'));
        $this->form->initModifiedControlsList();
        $this->form->setData('list', array('aaa', '123'));
        $modifiedControls = array ();
        $this->assertIdentical($modifiedControls, $this->form->getModifiedControls());
    }

}
