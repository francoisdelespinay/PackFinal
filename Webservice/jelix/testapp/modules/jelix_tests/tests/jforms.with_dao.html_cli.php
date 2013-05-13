<?php
/**
* @package     testapp
* @subpackage  jelix_tests module
* @author      Laurent Jouanneau
* @contributor
* @copyright   2007 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

require_once(JELIX_LIB_PATH.'forms/jForms.class.php');

class UTjformsWithDao extends jUnitTestCaseDb {

    function setUpRun(){
        $_SESSION['JFORMS'] = array();
        $form = jForms::create('product');
        $form = jForms::create('label', array(1,'fr'));
        $form = jForms::create('label', array(1,'en'));
        $this->emptyTable('product_test');
        $this->emptyTable('product_tags_test');
        $this->emptyTable('labels_test');
        $this->savedParams = jApp::coord()->request->params;
    }

    function testInsertDao(){
        $req = jApp::coord()->request;

        $req->params['name'] = 'phone';
        $req->params['price'] = '45';
        $req->params['tag'] = array('professionnal','book');
        $form = jForms::fill('product');

        // save main data
        $this->id = $form->saveToDao('products');
        $this->assertTrue(preg_match("/^[0-9]+$/",$this->id));
        $records = array(
            array('id'=>$this->id, 'name'=>'phone', 'price'=>45),
        );
        $this->assertTableContainsRecords('product_test', $records);

        // save data of the tags control which is a container
        $form->saveControlToDao('tag','product_tags',$this->id);
        $records = array(
            array('product_id'=>$this->id, 'tag'=>'professionnal'),
            array('product_id'=>$this->id, 'tag'=>'book'),
        );
        $this->assertTableContainsRecords('product_tags_test', $records);

        //insert a second product
        $req->params['name'] = 'computer';
        $req->params['price'] = '590';
        $req->params['tag'] = array('professionnal','promotion');
        $form = jForms::fill('product');

        $this->id2 = $form->saveToDao('products');
        $this->assertTrue(preg_match("/^[0-9]+$/",$this->id2));
        $this->assertNotEqual($this->id, $this->id2);
        $records = array(
            array('id'=>$this->id, 'name'=>'phone', 'price'=>45),
            array('id'=>$this->id2, 'name'=>'computer', 'price'=>590),
        );
        $this->assertTableContainsRecords('product_test', $records);

        // save data of the tags control which is a container
        $form->saveControlToDao('tag','product_tags',$this->id2);
        $records = array(
            array('product_id'=>$this->id, 'tag'=>'professionnal'),
            array('product_id'=>$this->id, 'tag'=>'book'),
            array('product_id'=>$this->id2,'tag'=>'professionnal'),
            array('product_id'=>$this->id2,'tag'=>'promotion'),
        );
        $this->assertTableContainsRecords('product_tags_test', $records);
    }

    function testInsertDao2(){
        $req = jApp::coord()->request;

        $req->params['label'] = 'bonjour';
        $form = jForms::fill('label', array(1,'fr'));

        // save main data
        $id = $form->saveToDao('labels');
        $this->assertEqual($id, array(1,'fr'));
        $records = array(
            array('key'=>1, 'lang'=>'fr', 'label'=>'bonjour'),
        );
        $this->assertTableContainsRecords('labels_test', $records);

        //insert a second label
        $req->params['label'] = 'Hello';
        $form = jForms::fill('label', array(1,'en'));

        $id2 = $form->saveToDao('labels');
        $this->assertEqual($id2, array(1,'en'));
        $records = array(
            array('key'=>1, 'lang'=>'fr', 'label'=>'bonjour'),
            array('key'=>1, 'lang'=>'en', 'label'=>'Hello'),
        );
        $this->assertTableContainsRecords('labels_test', $records);
    }

    function testUpdateDao(){

        $req = jApp::coord()->request;

        $form = jForms::create('product',$this->id); // "fill" need an existing form

        $req->params['name'] = 'other phone';
        $req->params['price'] = '68';
        $req->params['tag'] = array('high tech','best seller');

        $form = jForms::fill('product',$this->id);
        $id = $form->saveToDao('products');

        $this->assertEqual($id, $this->id);

        $form->saveToDao('products'); // try to update an unchanged record 

        $records = array(
            array('id'=>$this->id, 'name'=>'other phone', 'price'=>68),
            array('id'=>$this->id2,'name'=>'computer',    'price'=>590),
        );
        $this->assertTableContainsRecords('product_test', $records);

        // save data of the tags control which is a container
        $form->saveControlToDao('tag','product_tags',$this->id);
        $records = array(
            array('product_id'=>$this->id2, 'tag'=>'professionnal'),
            array('product_id'=>$this->id2, 'tag'=>'promotion'),
            array('product_id'=>$this->id,  'tag'=>'high tech'),
            array('product_id'=>$this->id,  'tag'=>'best seller'),
        );
        $this->assertTableContainsRecords('product_tags_test', $records);

    }

    function testLoadDao(){
        jForms::destroy('product');
        jForms::destroy('product', $this->id);
        $verif='
<array>
     <array key="jelix_tests~product">array()</array>
</array>';
        $this->assertComplexIdenticalStr($_SESSION['JFORMS'], $verif);

        $form = jForms::create('product', $this->id);

$verif='
<array>
     <array key="jelix_tests~product">
        <object key="'.$this->id.'" class="jFormsDataContainer">
            <integer property="formId" value="'.$this->id.'" />
            <string property="formSelector" value="jelix_tests~product" />
            <array property="data">
                <string key="name" value="" />
                <string key="price" value="" />
                <array key="tag">array()</array>
            </array>
            <array property="errors">array()</array>
        </object>
     </array>
</array>';
        $this->assertComplexIdenticalStr($_SESSION['JFORMS'], $verif);

        $form->initFromDao('products');

$verif='
<array>
     <array key="jelix_tests~product">
        <object key="'.$this->id.'" class="jFormsDataContainer">
            <integer property="formId" value="'.$this->id.'" />
            <string property="formSelector" value="jelix_tests~product" />
            <array property="data">
                <string key="name" value="other phone" />
                <string key="price" value="68" />
                <array key="tag">array()</array>
            </array>
            <array property="errors">array()</array>
        </object>
     </array>
</array>';


        $this->assertComplexIdenticalStr($_SESSION['JFORMS'], $verif);


        $form->initControlFromDao('tag', 'product_tags');
$verif='
<array>
     <array key="jelix_tests~product">
        <object key="'.$this->id.'" class="jFormsDataContainer">
            <integer property="formId" value="'.$this->id.'" />
            <string property="formSelector" value="jelix_tests~product" />
            <array property="data">
                <string key="name" value="other phone" />
                <string key="price" value="68" />
                <array key="tag">array(\'best seller\', \'high tech\')</array>
            </array>
            <array property="errors">array()</array>
        </object>
     </array>
</array>';
        $this->assertComplexIdenticalStr($_SESSION['JFORMS'], $verif);
    }




    function testGetValue() {
        
        $this->emptyTable('labels1_test');
        
        
        
        
    }

    function testEnd(){
        jApp::coord()->request->params = $this->savedParams;
        jForms::destroy('product');
        jForms::destroy('label', array(1,'fr'));
        jForms::destroy('label', array(1,'en'));
    }
}
?>