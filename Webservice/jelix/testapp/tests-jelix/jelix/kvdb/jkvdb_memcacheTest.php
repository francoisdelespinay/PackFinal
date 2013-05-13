<?php
/**
* @package     testapp
* @subpackage  jelix_tests module
* @author      Laurent Jouanneau
* @copyright   2010 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

require_once(dirname(__FILE__).'/jkvdb.lib.php');

/**
* Tests API jKVDb
* @package     testapp
* @subpackage  jelix_tests module
*/

class jkvdb_memcacheTest extends UTjKVDb {

    protected $profile = 'usingmemcache';

    public function setUp (){
        if (!$this->_kvdbSetUp())
            return;
        if (!extension_loaded('memcache'))
            $this->markTestSkipped('jkvdb_memcacheTest cannot be run because memcache is not installed');
        else {
            list($host, $port) = explode(':', $this->profileData['host']);
            $this->mmc = memcache_connect($host, intval($port));
            memcache_flush($this->mmc);
        }
    }

    public function tearDown() {
        if ($this->mmc) {
            memcache_close($this->mmc);
            $this->mmc = null;
        }
    }
    
    public function testGarbage () {

        $kv = jKVDb::getConnection($this->profile);

        $kv->set('remainingDataKey','remaining data');
        $kv->setWithTtl('garbage1DataKey','data send to the garbage',1);
        $kv->setWithTtl('garbage2DataKey','other data send to the garbage',strtotime("-1 day"));

        sleep(2);

        $this->assertTrue($kv->garbage());

        $this->assertEquals('remaining data', memcache_get($this->mmc,'remainingDataKey'));
        $this->assertFalse(memcache_get($this->mmc,'garbage1DataKey'));
        $this->assertFalse(memcache_get($this->mmc,'garbage2DataKey'));
    }

    public function testFlush (){

        $kv = jKVDb::getConnection($this->profile);

        $kv->set('flush1DataKey','some data');
        $kv->setWithTtl('flush2DataKey','data to remove',strtotime("+1 day"));
        $kv->setWithTtl('flush3DataKey','other data to remove',time()+30);

        $this->assertEquals('some data', memcache_get($this->mmc,'flush1DataKey'));
        $this->assertEquals('data to remove', memcache_get($this->mmc,'flush2DataKey'));
        $this->assertEquals('other data to remove', memcache_get($this->mmc,'flush3DataKey'));
        $this->assertTrue($kv->flush());
        $this->assertFalse(memcache_get($this->mmc,'flush1DataKey'));
        $this->assertFalse(memcache_get($this->mmc,'flush2DataKey'));
        $this->assertFalse(memcache_get($this->mmc,'flush3DataKey'));
    }
    
    
}

?>