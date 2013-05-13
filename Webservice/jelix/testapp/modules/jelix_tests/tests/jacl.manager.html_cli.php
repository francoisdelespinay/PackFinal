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

class UTjaclmanager extends jUnitTestCaseDb {


    public function setUpRun(){
        $this->dbProfile = 'jacl_profile';
        $this->emptyTable('jacl_user_group');
        $this->emptyTable('jacl_rights');
        $this->emptyTable('jacl_right_values');
        $this->emptyTable('jacl_right_values_group');
        $this->emptyTable('jacl_subject');

        $groups= array(array('id_aclgrp'=>1, 'name'=>'group1', 'grouptype'=>0, 'ownerlogin'=>null));

        $this->insertRecordsIntoTable('jacl_group', array('id_aclgrp','name','grouptype','ownerlogin'), $groups, true);

        $rvg= array(
            array('id_aclvalgrp'=>1, 'label_key'=>'jxacl~db.valgrp.truefalse', 'type_aclvalgrp'=>1),
            array('id_aclvalgrp'=>2, 'label_key'=>'jxacl~db.valgrp.crudl',     'type_aclvalgrp'=>0),
            array('id_aclvalgrp'=>3, 'label_key'=>'jxacl~db.valgrp.groups',    'type_aclvalgrp'=>0),
        );
        $this->insertRecordsIntoTable('jacl_right_values_group', array('id_aclvalgrp','label_key','type_aclvalgrp'), $rvg, true);

        $rv= array(
            array('value'=>'FALSE', 'label_key'=>'jxacl~db.valgrp.truefalse.false',  'id_aclvalgrp'=>1),
            array('value'=>'TRUE',  'label_key'=>'jxacl~db.valgrp.truefalse.true',   'id_aclvalgrp'=>1),

            array('value'=>'LIST',  'label_key'=>'jxacl~db.valgrp.crudl.list',       'id_aclvalgrp'=>2),
            array('value'=>'CREATE','label_key'=>'jxacl~db.valgrp.crudl.create',     'id_aclvalgrp'=>2),
            array('value'=>'READ',  'label_key'=>'jxacl~db.valgrp.crudl.read',       'id_aclvalgrp'=>2),
            array('value'=>'UPDATE','label_key'=>'jxacl~db.valgrp.crudl.update',     'id_aclvalgrp'=>2),
            array('value'=>'DELETE','label_key'=>'jxacl~db.valgrp.crudl.delete',     'id_aclvalgrp'=>2),

            array('value'=>'LIST',   'label_key'=>'jxacl~db.valgrp.groups.list',   'id_aclvalgrp'=>3),
            array('value'=>'CREATE', 'label_key'=>'jxacl~db.valgrp.groups.create', 'id_aclvalgrp'=>3),
            array('value'=>'RENAME', 'label_key'=>'jxacl~db.valgrp.groups.rename', 'id_aclvalgrp'=>3),
            array('value'=>'DELETE', 'label_key'=>'jxacl~db.valgrp.groups.delete', 'id_aclvalgrp'=>3),
        );

        $this->insertRecordsIntoTable('jacl_right_values', array('value','label_key','id_aclvalgrp'), $rv, true);
    }

    protected $subjects;

    public function testAddSubject(){
        jAclDbManager::addSubject('super.cms',2 , 'cms~rights.super.cms');
        $this->subjects = array(
            array('id_aclsbj'=>'super.cms', 'id_aclvalgrp'=>2, 'label_key'=>'cms~rights.super.cms'),
        );
        $this->assertTableContainsRecords('jacl_subject', $this->subjects);

        jAclDbManager::addSubject('jxacl.groups.management',3 , 'jxacl~db.sbj.groups.management');
        jAclDbManager::addSubject('admin.access',1 , 'admin~rights.access');
        jAclDbManager::addSubject('admin.foo',1 , 'admin~rights.foo');

        $this->subjects[] = array('id_aclsbj'=>'jxacl.groups.management', 'id_aclvalgrp'=>3, 'label_key'=>'jxacl~db.sbj.groups.management');
        $this->subjects[] = array('id_aclsbj'=>'admin.access', 'id_aclvalgrp'=>1, 'label_key'=>'admin~rights.access');
        $this->subjects[] = array('id_aclsbj'=>'admin.foo', 'id_aclvalgrp'=>1, 'label_key'=>'admin~rights.foo');

        $this->assertTableContainsRecords('jacl_subject', $this->subjects);
    }

    public function testRemoveSubject(){
        jAclDbManager::removeSubject('admin.foo');
        array_pop($this->subjects);
        $this->assertTableContainsRecords('jacl_subject', $this->subjects);
    }

    protected $rights;
    public function testAddRight(){
        $this->assertTrue(jAclDbManager::addRight(1, 'super.cms', 'LIST' ));
        $this->rights = array(array('id_aclsbj'=>'super.cms' ,'id_aclgrp'=>1, 'id_aclres'=> null, 'value'=>'LIST'));
        $this->assertTableContainsRecords('jacl_rights', $this->rights);

        $this->assertTrue(jAclDbManager::addRight(1, 'admin.access', 'TRUE' ));
        $this->rights[] = array('id_aclsbj'=>'admin.access' ,'id_aclgrp'=>1, 'id_aclres'=> null, 'value'=>'TRUE');
        $this->assertTableContainsRecords('jacl_rights', $this->rights);

        $this->assertFalse(jAclDbManager::addRight(1, 'admin.access', 'bla'));
        $this->assertFalse(jAclDbManager::addRight(1, 'admin.dont.exist', 'TRUE'));
        $this->assertTrue(jAclDbManager::addRight(1, 'super.cms', 'LIST' )); // on tente d'inserer le meme droit
        $this->assertTableContainsRecords('jacl_rights', $this->rights);
    }

    public function testRemoveRight(){
        jAclDbManager::removeRight(1, 'admin.access', 'TRUE' );
        $r = $this->rights;
        array_pop($r);
        $this->assertTableContainsRecords('jacl_rights', $r);
        $this->assertTrue(jAclDbManager::addRight(1, 'admin.access', 'TRUE' ));
    }

    public function testAddResourceRight(){
        $this->assertTrue(jAclDbManager::addRight(1, 'super.cms', 'UPDATE' , 154));
        $this->assertTrue(jAclDbManager::addRight(1, 'super.cms', 'UPDATE' , 92));
        $this->rights[] = array('id_aclsbj'=>'super.cms' ,'id_aclgrp'=>1, 'id_aclres'=> '154', 'value'=>'UPDATE');
        $this->rights[] = array('id_aclsbj'=>'super.cms' ,'id_aclgrp'=>1, 'id_aclres'=> '92', 'value'=>'UPDATE');
        $this->assertTableContainsRecords('jacl_rights', $this->rights);
    }
    public function testRemoveResourceRight(){
        jAclDbManager::removeResourceRight('super.cms', 92);
        array_pop($this->rights);
        $this->assertTableContainsRecords('jacl_rights', $this->rights);
    }

    public function testRemoveSubject2(){
        // remove a subject when rights exists on it
        jAclDbManager::removeSubject('super.cms');
        array_shift($this->subjects);
        $this->assertTableContainsRecords('jacl_subject', $this->subjects);

        $this->rights=  array( array('id_aclsbj'=>'admin.access' ,'id_aclgrp'=>1, 'id_aclres'=> null, 'value'=>'TRUE'));
        $this->assertTableContainsRecords('jacl_rights', $this->rights);
    }
}

?>