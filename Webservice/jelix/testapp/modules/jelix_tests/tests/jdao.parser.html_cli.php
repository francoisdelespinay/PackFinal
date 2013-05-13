<?php
/**
* @package     testapp
* @subpackage  jelix_tests module
* @author      Laurent Jouanneau
* @contributor
* @copyright   2006-2007 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

require_once(dirname(__FILE__).'/daotests.lib.php');

class UTDao_parser extends jUnitTestCase {

    protected $_selector;
    protected $_tools;
    function setUpRun() {
        $this->_selector = new fakejSelectorDao("foo", "bar", "mysql");
        $this->_tools= new mysqlDbTools(null);
    }

    protected $dsTest=array(
        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
     <primarytable name="news" primarykey="news_id" />
  </datasources>
</dao>',

'<?xml version="1.0"?>
<object class="jDaoParser">
    <array method="getProperties()">array()</array>
    <array method="getTables()">
        <array key="news">
            <string key="name" value="news" />
            <string key="realname" value="news" />
            <array key="pk" value="">array(\'news_id\')</array>
            <array key="fields">array()</array>
        </array>
    </array>
    <string method="getPrimaryTable()" value="news"/>
    <array method="getMethods()">array()</array>
    <array method="getOuterJoins()">array()</array>
    <array method="getInnerJoins()">array()</array>
</object>'
),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
     <primarytable name="news" realname="foo_news" primarykey="news_id" />
  </datasources>
</dao>',

'<?xml version="1.0"?>
<object class="jDaoParser">
    <array method="getProperties()">array()</array>
    <array method="getTables()">
        <array key="news">
            <string key="name" value="news" />
            <string key="realname" value="foo_news" />
            <array key="pk" value="">array(\'news_id\')</array>
            <array key="fields">array()</array>
        </array>
    </array>
    <string method="getPrimaryTable()" value="news"/>
    <array method="getMethods()">array()</array>
    <array method="getOuterJoins()">array()</array>
    <array method="getInnerJoins()">array()</array>
</object>'
),



        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
     <primarytable name="news"           primarykey="news_id" />
     <foreigntable name="news_rubriques" primarykey="news_rubriques_id" onforeignkey="news_rubrique" />
  </datasources>
</dao>',

'<?xml version="1.0"?>
<object class="jDaoParser">
    <array method="getProperties()">array()</array>
    <array method="getTables()">
        <array key="news">
            <string key="name" value="news" />
            <string key="realname" value="news" />
            <array key="pk" value="">array(\'news_id\')</array>
            <array key="fields">array()</array>
        </array>
        <array key="news_rubriques">
            <string key="name" value="news_rubriques" />
            <string key="realname" value="news_rubriques" />
            <array key="pk" value="">array(\'news_rubriques_id\')</array>
            <array key="fk" value="">array(\'news_rubrique\')</array>
            <array key="fields">array()</array>
        </array>
    </array>
    <string method="getPrimaryTable()" value="news"/>
    <array method="getMethods()">array()</array>
    <array method="getOuterJoins()">array()</array>
    <array method="getInnerJoins()">array(\'news_rubriques\')</array>
</object>'
),


 array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
     <primarytable name="news"           primarykey="news_id" />
     <optionalforeigntable name="news_rubriques" primarykey="news_rubriques_id" onforeignkey="news_rubrique" />
  </datasources>
</dao>',

'<?xml version="1.0"?>
<object class="jDaoParser">
    <array method="getProperties()">array()</array>
    <array method="getTables()">
        <array key="news">
            <string key="name" value="news" />
            <string key="realname" value="news" />
            <array key="pk" value="">array(\'news_id\')</array>
            <!-- <array key="fk" value="">array()</array>-->
            <array key="fields">array()</array>
        </array>
        <array key="news_rubriques">
            <string key="name" value="news_rubriques" />
            <string key="realname" value="news_rubriques" />
            <array key="pk" value="">array(\'news_rubriques_id\')</array>
            <array key="fk" value="">array(\'news_rubrique\')</array>
            <array key="fields">array()</array>
        </array>
    </array>
    <string method="getPrimaryTable()" value="news"/>
    <array method="getMethods()">array()</array>
    <array method="getOuterJoins()">array(array(\'news_rubriques\',0))</array>
    <array method="getInnerJoins()">array()</array>
</object>'
),


 array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
     <primarytable name="news"           primarykey="news_id" />
     <optionalforeigntable name="news_rubriques" primarykey="news_rubriques_id" onforeignkey="news_rubrique" />
     <foreigntable name="news_author" realname="jx_authors_news" primarykey="author_id" onforeignkey="author_id" />
  </datasources>
</dao>',

'<?xml version="1.0"?>
<object class="jDaoParser">
    <array method="getProperties()">array()</array>
    <array method="getTables()">
        <array key="news">
            <string key="name" value="news" />
            <string key="realname" value="news" />
            <array key="pk" value="">array(\'news_id\')</array>
            <!-- <array key="fk" value="">array()</array>-->
            <array key="fields">array()</array>
        </array>
        <array key="news_rubriques">
            <string key="name" value="news_rubriques" />
            <string key="realname" value="news_rubriques" />
            <array key="pk" value="">array(\'news_rubriques_id\')</array>
            <array key="fk" value="">array(\'news_rubrique\')</array>
            <array key="fields">array()</array>
        </array>
        <array key="news_author">
            <string key="name" value="news_author" />
            <string key="realname" value="jx_authors_news" />
            <array key="pk" value="">array(\'author_id\')</array>
            <array key="fk" value="">array(\'author_id\')</array>
            <array key="fields">array()</array>
        </array>
    </array>
    <string method="getPrimaryTable()" value="news"/>
    <array method="getMethods()">array()</array>
    <array method="getOuterJoins()">array(array(\'news_rubriques\',0))</array>
    <array method="getInnerJoins()">array(\'news_author\')</array>
</object>'
),

      );

    function testGoodDatasources() {

        foreach($this->dsTest as $k=>$t){
            //$this->sendMessage("test good datasource ".$k);
            $xml= simplexml_load_string($t[0]);
            $p = new testjDaoParser($this->_selector);
            try{
                $p->testParseDatasource($xml);
                $this->assertComplexIdenticalStr($p, $t[1]);
            }catch(jDaoXmlException $e){
                $this->fail("Exception sur le contenu xml inattendue : ".$e->getMessage().' ('.$e->getLocaleKey().')');
            }catch(Exception $e){
                $this->fail("Exception inconnue : ".$e->getMessage());
            }
        }
    }




    protected $dsTestbad=array(
        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
  </datasources>
</dao>',
'jelix~daoxml.datasource.missing',
array('foo~bar','')
),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable />
  </datasources>
</dao>',
'jelix~daoxml.table.name',
array('foo~bar','')

),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news" />
  </datasources>
</dao>',
'jelix~daoxml.primarykey.missing',
array('foo~bar','')

),
        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news" primarykey=""/>
  </datasources>
</dao>',
'jelix~daoxml.primarykey.missing',
array('foo~bar','')

),
        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news"           primarykey="news_id" />
    <primarytable />
  </datasources>
</dao>',
'jelix~daoxml.table.two.many',
array('foo~bar','')

),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news"           primarykey="news_id" />
    <foreigntable name="news_author" realname="jx_authors_news" primarykey="author_id" />

  </datasources>
</dao>',
'jelix~daoxml.foreignkey.missing',
array('foo~bar','')

),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news"           primarykey="news_id" />
    <foreigntable name="news_author" realname="jx_authors_news" primarykey="author_id" onforeignkey="" />

  </datasources>
</dao>',
'jelix~daoxml.foreignkey.missing',
array('foo~bar','')

),

        array('<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news"           primarykey="news_id" />
    <foreigntable name="news_author" realname="jx_authors_news" primarykey="author_id" onforeignkey="author_id,foo_id" />

  </datasources>
</dao>',
'jelix~daoxml.foreignkey.missing',
array('foo~bar','')

),

      );

    function testBadDatasources() {

        foreach($this->dsTestbad as $k=>$t){
            //$this->sendMessage("test bad datasource ".$k);
            $xml= simplexml_load_string($t[0]);
            $p = new testjDaoParser($this->_selector);
            try{
                $p->testParseDatasource($xml);
                $this->fail("Pas d'exception survenue !");
            }catch(jDaoXmlException $e){
                $this->assertEqual($e->getLocaleKey(), $t[1]);
                $this->assertEqualOrDiff($e->getLocaleParameters(), $t[2]);
            }catch(Exception $e){
                $this->fail("Exception inconnue : ".$e->getMessage());
            }
        }
    }


    protected $propDatas=array(
        array(
        '<?xml version="1.0"?>
        <property name="label" datatype="string" />',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="label"/>
            <string p="fieldName" value="label"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="%s" />
            <string p="insertPattern" value="%s" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <null p="defaultValue" />
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),
        array(
        '<?xml version="1.0"?>
        <property name="label" datatype="string" default="no label"/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="label"/>
            <string p="fieldName" value="label"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="%s" />
            <string p="insertPattern" value="%s" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <string p="defaultValue" value="no label" />
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),
        array(
        '<?xml version="1.0"?>
        <property name="author_firstname" fieldname="firstname" datatype="string" table="news_author" />',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="author_firstname"/>
            <string p="fieldName" value="firstname"/>
            <string p="table" value="news_author"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <null p="defaultValue" />
            <boolean p="ofPrimaryTable" value="false" />
        </object>'
        ),

        array(
        '<?xml version="1.0"?>
        <property name="id" fieldname="news_id" datatype="autoincrement" />',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="id"/>
            <string p="fieldName" value="news_id"/>
            <string p="table" value="news"/>
            <string p="datatype" value="autoincrement"/>
            <string p="unifiedType" value="integer"/>
            <boolean p="autoIncrement" value="true" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="true"/>
            <boolean p="isPK" value="true" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="%s" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),
       array( '<?xml version="1.0"?>
        <property name="label" datatype="string" selectpattern="%s" insertpattern="" updatepattern=""/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="label"/>
            <string p="fieldName" value="label"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),

       array( '<?xml version="1.0"?>
        <property name="label" datatype="string" selectpattern="CASE WHEN LENGTH(password) = 0 THEN 1 ELSE 0 END" insertpattern="" updatepattern=""/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="label"/>
            <string p="fieldName" value="label"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="" />
            <string p="selectPattern" value="CASE WHEN LENGTH(password) = 0 THEN 1 ELSE 0 END" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),

        array(
        '<?xml version="1.0"?>
        <property name="id" fieldname="news_id" datatype="string" />',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="id"/>
            <string p="fieldName" value="news_id"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="true"/>
            <boolean p="requiredInConditions" value="true"/>
            <boolean p="isPK" value="true" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="%s" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),

        array(
        '<?xml version="1.0"?>
        <property name="id" fieldname="news_id" datatype="string" insertpattern="now()" updatepattern="concat(\'oups\')" selectpattern="upper(%s)"/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="id"/>
            <string p="fieldName" value="news_id"/>
            <string p="table" value="news"/>
            <string p="datatype" value="string"/>
            <string p="unifiedType" value="varchar"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="true"/>
            <boolean p="requiredInConditions" value="true"/>
            <boolean p="isPK" value="true" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="now()" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),

        array(
        '<?xml version="1.0"?>
        <property name="author_id" fieldname="author_id" datatype="integer" required="true" updatepattern="now()"/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="author_id"/>
            <string p="fieldName" value="author_id"/>
            <string p="table" value="news"/>
            <string p="datatype" value="integer"/>
            <string p="unifiedType" value="integer"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="true"/>
            <boolean p="requiredInConditions" value="true"/>
            <boolean p="isPK" value="false" />
            <boolean p="isFK" value="true" />
            <string p="updatePattern" value="%s" />
            <string p="insertPattern" value="%s" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="true" />
        </object>'
        ),

        array(
        '<?xml version="1.0"?>
        <property name="author_id" fieldname="author_id" datatype="integer" table="news_author" required="true"/>',
        '<?xml version="1.0"?>
        <object>
            <string p="name" value="author_id"/>
            <string p="fieldName" value="author_id"/>
            <string p="table" value="news_author"/>
            <string p="datatype" value="integer"/>
            <string p="unifiedType" value="integer"/>
            <boolean p="autoIncrement" value="false" />
            <null p="regExp"/>
            <boolean p="required" value="false"/>
            <boolean p="requiredInConditions" value="false"/>
            <boolean p="isPK" value="true" />
            <boolean p="isFK" value="false" />
            <string p="updatePattern" value="" />
            <string p="insertPattern" value="" />
            <string p="selectPattern" value="%s" />
            <string p="sequenceName" value="" />
            <null p="maxlength"/>
            <null p="minlength"/>
            <boolean p="ofPrimaryTable" value="false" />
        </object>'
        ),
    );

    function testProperties() {
        $dao ='<?xml version="1.0"?>
<dao xmlns="http://jelix.org/ns/dao/1.0">
  <datasources>
    <primarytable name="news" primarykey="news_id" />
    <foreigntable name="news_author" primarykey="author_id" onforeignkey="author_id" />
  </datasources>
</dao>';

        $parser = new testjDaoParser($this->_selector);
        $parser->testParseDatasource(simplexml_load_string($dao));

        foreach($this->propDatas as $k=>$t){
            //$this->sendMessage("test good property ".$k);
            $xml= simplexml_load_string($t[0]);
            try{
                $p = new jDaoProperty($xml, $parser, $this->_tools);
                $this->assertComplexIdenticalStr($p, $t[1], "test $k");
            }catch(jDaoXmlException $e){
                $this->fail("Exception sur le contenu xml inattendue : ".$e->getMessage().' ('.$e->getLocaleKey().')');
            }catch(Exception $e){
                $this->fail("Exception inconnue : ".$e->getMessage());
            }
        }
    }
}
