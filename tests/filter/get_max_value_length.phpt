--TEST--
suhosin input filter (suhosin.get.max_value_length)
--INI--
suhosin.log.syslog=0
suhosin.log.sapi=0
suhosin.log.script=0
suhosin.log.file=255
suhosin.log.file.time=0
suhosin.log.file.name={PWD}/suhosintest.$$.log.tmp
auto_append_file={PWD}/suhosintest.$$.log.tmp
suhosin.request.max_value_length=0
suhosin.get.max_value_length=3
--SKIPIF--
<?php include('../skipif.inc'); ?>
--COOKIE--
--GET--
var1=1&var2=22&var3=333&var4=4444&var5=55%00555&var6=666666&
--POST--
--FILE--
<?php
var_dump($_GET);
?>
--EXPECTF--
array(3) {
  ["var1"]=>
  string(1) "1"
  ["var2"]=>
  string(2) "22"
  ["var3"]=>
  string(3) "333"
}
ALERT - configured GET variable value length limit exceeded - dropped variable 'var4' (attacker 'REMOTE_ADDR not set', file '%s')
ALERT - configured GET variable value length limit exceeded - dropped variable 'var5' (attacker 'REMOTE_ADDR not set', file '%s')
ALERT - configured GET variable value length limit exceeded - dropped variable 'var6' (attacker 'REMOTE_ADDR not set', file '%s')
ALERT - dropped 3 request variables - (3 in GET, 0 in POST, 0 in COOKIE) (attacker 'REMOTE_ADDR not set', file '%s')

