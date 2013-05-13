<?php

class jLocaleTest extends PHPUnit_Framework_TestCase {

    public static function setUpBeforeClass() {
        jelix_init_test_env();
    }

    protected $backupAvailableLocale;
    protected $backupAcceptedLanguage;
    protected $backupLangToLocale;

    public function setUp() {
        $this->backupLangToLocale = jApp::config()->langToLocale ;
        $this->backupAcceptedLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:'';
        $this->backupAvailableLocale = jApp::config()->availableLocales ;
    }

    public function tearDown() {
        jApp::config()->langToLocale = $this->backupLangToLocale;
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $this->backupAcceptedLanguage;
        jApp::config()->availableLocales = $this->backupAvailableLocale;
    }

    function testLangToLocale() {
        jApp::config()->langToLocale = array();
        
        $this->assertEquals('en_US', jLocale::langToLocale('en'));
        $this->assertEquals('', jLocale::langToLocale('en_GB'));
        $this->assertEquals('fr_FR', jLocale::langToLocale('fr'));
        $this->assertEquals('be_BY', jLocale::langToLocale('be'));
        
        jApp::config()->langToLocale = array('fr'=>'fr_CA');
        $this->assertEquals('fr_CA', jLocale::langToLocale('fr'));
    }

    function testGetCorrespondingLocale() {
        jApp::config()->availableLocales = array('en_US');

        $this->assertEquals(array('en'=>'en_EN'), jApp::config()->langToLocale);
        $this->assertEquals('', jLocale::getCorrespondingLocale('en'));

        jApp::config()->langToLocale = array('en'=>'en_US');
        $this->assertEquals('en_US', jLocale::getCorrespondingLocale('en'));
        jApp::config()->langToLocale = array();
        $this->assertEquals('en_US', jLocale::getCorrespondingLocale('en'));
        $this->assertEquals('en_US', jLocale::getCorrespondingLocale('en_US'));
        $this->assertEquals('en_US', jLocale::getCorrespondingLocale('en_GB'));
        jApp::config()->availableLocales = array('en_US', 'fr_CA');
        jApp::config()->langToLocale = array('fr'=>'fr_CA'); // simulate jConfigCompiler
        $this->assertEquals('en_US', jLocale::getCorrespondingLocale('en'));
        $this->assertEquals('fr_CA', jLocale::getCorrespondingLocale('fr'));
        $this->assertEquals('fr_CA', jLocale::getCorrespondingLocale('fr_FR'));
    }

    function testGetPreferedLocaleFromRequest() {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en_US,fr_CA,en_GB';
        jApp::config()->availableLocales = array('en_US');
        $this->assertEquals('en_US', jLocale::getPreferedLocaleFromRequest());
        
        jApp::config()->availableLocales = array('en_US', 'fr_CA');
        jApp::config()->langToLocale = array('fr'=>'fr_CA'); // simulate jConfigCompiler
        $this->assertEquals('en_US', jLocale::getPreferedLocaleFromRequest());

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'fr_CA,en_GB';
        jApp::config()->availableLocales = array('en_US', 'fr_CA');
        $this->assertEquals('fr_CA', jLocale::getPreferedLocaleFromRequest());

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'fr_FR,en_US';
        jApp::config()->availableLocales = array('en_US', 'fr_CA');
        $this->assertEquals('fr_CA', jLocale::getPreferedLocaleFromRequest());
    }
}
