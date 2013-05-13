<?php
/**
* @package     testapp
* @subpackage  jelix_tests module
* @author      Tahina Ramaroson
* @contributor Sylvain de Vathaire
* @contributor Laurent Jouanneau
* @copyright   NEOV 2009
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

require_once(dirname(__FILE__).'/jcache.lib.php');

/**
* Tests API jCache
* @package     testapp
* @subpackage  jelix_tests module
*/

class UTjCacheDb extends UTjCacheAPI {

    protected $profile = 'usingdb';

    public function setUp (){
        $this->emptyTable('jlx_cache');
    }

    public function testGet (){
        parent::testGet();

        $this->insertRecordsIntoTable('jlx_cache', array('cache_key','cache_data','cache_date'),array(array('cache_key'=>'phpIncompleteClassKey','cache_data'=>'O:9:"dummyData":2:{s:5:"label";s:23:"test unserializing data";s:11:"description";s:26:"for expecting an exception";}','cache_date'=>null)));
        $data=jCache::get('phpIncompleteClassKey',$this->profile);
        if(!is_object($data)){
            $this->pass();
        }else{
            $this->fail();
        }
    }

    public function testGarbage (){
        parent::testGarbage();
        $this->assertFalse(jCache::garbage());

        $this->assertTableContainsRecords('jlx_cache',array(
            array('cache_key'=>'remainingDataKey','cache_data'=>serialize('remaining data'),'cache_date'=>null)
        ));
    }

    public function testFlush (){
        parent::testFlush();

        $this->assertTableHasNRecords('jlx_cache', 3);
        $this->assertTrue(jCache::flush($this->profile));
        $this->assertTableIsEmpty('jlx_cache');

    }

}

?>