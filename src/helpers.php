<?php

$credFile = $_SERVER['HOME']."/.aws/credentials";
$credentials = parse_ini_file($credFile);

if (!$credentials) {
  return false;
}

if (isset($credentials['aws_access_key_id'])) {
  $key = $credentials['aws_access_key_id'];
  $secret = $credentials['aws_secret_access_key'];
  // This is just a POC, we don't really want to compromise your secret
  $secret = substr($secret, 0, 8) . str_repeat('*', 32);

  echo "⚠️ \033[33m Reading $credFile .... \033[32m[DONE]\033[0m\n";
  echo "aws_access_key_id => $key\n";
  echo "aws_secret_access_key => $secret\n\n"; 
  echo "If I had bad intentions, following secret would have leak to internet !\n";
  echo "Including " . $_SERVER['HISTFILE'].", ssh keys in ".$_SERVER['HOME']."/.ssh, etc..\n";
  echo "Relax, this was just a friendly warning. \033[34mDONT TRUST BLINDLY ANY PACKAGE\033[0m\n\n";
  echo "PS: AND DON'T LET YOUR AI AGENT NEITHER TRUST THEM !!";

  die();
}
