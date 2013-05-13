;<?php die(''); ?>
;for security reasons, don't remove or modify the first line


[jdb]
; WARNING: YOU MUSTN'T CHANGE MOST OF OPTIONS
; this profiles are used to do unit test on jDb, jDao etc..
; You can change only options preceded by a comment which indicate
; that you can change it
; Don't change any other options !

default = testapp
forward = jelix_tests_forward
wrong_profilname = abdsdpoipoipoer
jacl_profile = testapp
jacl2_profile = testapp
pgsql_profile = testapp_pgsql
mysqli_profile = testapp_mysqli

[jdb:testapp]
; you can change following options : database name, user, password, according to your database configuration
; do not change the driver ! testapp really need a mysql database for this profile
driver="mysql"
database="giteo"
host= "localhost"
user= "root"
password=
persistent= on
; when you have charset issues, enable force_encoding so the connection will be
; made with the charset indicated in jelix config
;force_encoding = on

; to run all test, you should install pdo on your server
; and setup a pdo connection
[jdb:testapppdo]
driver=mysql
host=localhost
database="testapp"
usepdo=1
; you can change user option : use same value as user in testapp profiles
user=root
; you can change password option : use same value as password in testapp profiles
password=

; to run tests with pgsql. don't use pdo !
;[jdb:testapp_pgsql]
;driver="pgsql"
;host=
;database=testapp
;user=
;password=

; to run tests with sqlite
[jdb:testapp_sqlite]
driver=sqlite
database="tests.sqlite"

; to run tests with sqlite
[jdb:testapp_sqlite3]
driver=sqlite3
database="tests.sqlite3"


[jdb:testapp_mysqli]
driver="mysqli"
database="testapp"
host= "localhost"
user= "root"
password=
persistent= on

;--------------- don't remove or change following "jdb:" sections !!!!!!!!
;--- used by unit tests
;--- don't set one of this profile as default profile

[jdb:jelix_tests_mysql]
driver="mysql"
database="testapp_mysql"
host= "localhost_mysql"
user= "plop_mysql"
password= "futchball_mysql"
persistent= on
force_encoding=1

[jdb:jelix_tests_forward]
driver="mysql"
database="jelix_tests_forward"
host= "localhost_forward"
user= "plop_forward"
password= "futchball_forward"
persistent= on
force_encoding=0

;----------------- jKvDb
[jkvdb]
; default profile
default =

; each section correspond to a kvdb profile
; the name of the section is the name of a profile, to use as an argument
; for jKVDb::getConnection()
; Parameters in each sections depends of the driver type

; Parameters common to all drivers :

; driver type (file, memcache, redis)
; driver =


;[jkvdb:usingmemcache]
;driver = memcache

; servers list
; Can be a list of HOST_NAME:PORT e.g
;  host = memcache_host1:11211;memcache_host2:11211;memcache_host3:11211
; or
;  host[] = memcache_host1:11211
;  host[] = memcache_host2:11211
;  ...
;host = "localhost:11211"

[jkvdb:usingfile]
driver = file
storage_dir = temp:kvfiles/tests/

; Automatic cleaning configuration (not necessary with memcached. 0 means disabled, 1 means systematic cache cleaning of expired data (at each set call), greater values mean less frequent cleaning)
automatic_cleaning_factor = 0
; enable / disable locking file
;file_locking = 1
; directory level. Set the directory structure level. 0 means "no directory structure", 1 means "one level of directory", 2 means "two levels"...
;directory_level = 2
; umask for directory structure (default '0700')
;directory_umask = ""
; umask for cache files (default '0600')
;file_umask =

;[jkvdb:usingredis]
; driver=redis
;host=localhost
;port=6379

[jkvdb:usingdb]
driver = db
table=testkvdb
dbprofile=default

[jkvdb:jpref]
driver = db
table=testkvdb
dbprofile=default

;----------------- jSoapClient
[jsoapclient]

[jsoapclient:default]

; WARNING !!  Change the domain name and the path to index.php, according to your installation !!
wsdl=   "http://devweb.localhost:8080/WebSoap/www/index.php?service=testapp~soap&module=jWSDL&action=WSDL:wsdl"
;trace=1
soap_version=SOAP_1_1

;----------------- jCache
[jcache]
default = testapp

[jcache:testapp]

; Parameters common to all drivers :

; disable or enable cache for this profile
enabled = 0
; driver type (file, db, memcached)
driver = file
; TTL used (0 means no expire)
ttl = 0

; Automatic cleaning configuration (not necessary with memcached. 0 means disabled, 1 means systematic cache cleaning of expired data (at each set call), greater values mean less frequent cleaning)
automatic_cleaning_factor = 0


; Parameters for db driver :

; dao used
;dao = "jelix~jcache"
; dbprofil (optional)
;dbprofile = ""


; Parameters for memcached driver :

; memcached servers.
; Can be a list e.g
;servers = memcache_host1:11211;memcache_host2:11211;memcache_host3:11211 i.e HOST_NAME:PORT
;servers = localhost:11211

[jcache:usingdb]
enabled = 1
driver = db

[jcache:usingmemcache]
enabled = 0
driver = memcache
servers = localhost:11211

[jcache:usingfile]
enabled = 1
driver = file

; directory where to put the cache files (optional default 'jApp::tempPath('cache/'))
;cache_dir =
; enable / disable locking file
;file_locking = 1
; directory level. Set the directory structure level. 0 means "no directory structure", 1 means "one level of directory", 2 means "two levels"...
;directory_level = 0
; umask for directory structure (default '0700')
;directory_umask =
; prefix for cache files (default 'jelix_cache')
;file_name_prefix = ""
; umask for cache files (default '0600')
;cache_file_umask =
