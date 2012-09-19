#! /usr/bin/env php
<?php

require_once(dirname($argv[0]) . "/../config.php");
require_once(IA_ROOT_DIR . 'eval/config.php');
require_once(IA_ROOT_DIR . 'common/log.php');

// Config options.
$jail_dir = "jail";
$exe_name = "prog";
$extra_args = "--block-syscalls-file=bad_syscalls --verbose";
//$extra_args = "--nice -5 --block-syscalls-file=bad_syscalls --verbose";
//$extra_args = "--uid 65534 --gid 65534 --block-syscalls-file=bad_syscalls --chroot";
//$extra_args = "--uid 65534 --gid 65534 --block-syscalls-file=bad_syscalls";

// In order to run python tests, download a python distribution, configure,
// make, make install, then specify the top level directory here.
$py_compiler = IA_ROOT_DIR."scripts/pybin.sh ".IA_JUDGE_PY_DISTRO
        ." {$jail_dir}";

// Parse a source file
// Returns the arguments to run the jail with and the expected response.
// test_exp_res is a posix regex that should match the jail run response.
function parse_source($filename, &$test_args, &$test_exp_res)
{
    $test_args = $test_exp_res = null;
    foreach (file("$filename") as $line) {
        if (preg_match("/(?:\/\/|#) JRUN_ARGS =(.*)$/", $line, $matches)) {
            $test_args = trim($matches[1]);
        }
        if (preg_match("/(?:\/\/|#) JRUN_RES =(.*)$/", $line, $matches)) {
            $test_exp_res = trim($matches[1]);
        }
    }
    if ($test_args === null || $test_exp_res === null) {
        log_error("$filename doesn't mention JRUN_ARGS and JRUN_RES\n");
    }
}

function compile_source($source, $exe)
{
    global $py_compiler;
    if (strpos($source, ".cpp") === strlen($source) - 4) {
        system("g++ -Wall -lm -O2 $source --static -o $exe", $ret);
    } else if (strpos($source, ".c") === strlen($source) - 2) {
        system("gcc -Wall -lm -O2 $source --static -o $exe", $ret);
    } else if (strpos($source, ".py") === strlen($source) - 3) {
        system("{$py_compiler} $source $exe", $ret);
    } else {
        log_error("Can't compile $source, unknown file extension\n");
    }
    if ($ret) {
        log_error("Compilation error on $source\n");
    }
}

// Do a jail run.
// This will compile $filename in $jail_dir and jrun with the
// specified args. Returns jail output.
function jail_run($filename, $args)
{
    global $jail_dir, $exe_name;

    system("rm -rf $jail_dir");
    system("mkdir -p $jail_dir");
    system("chmod 777 $jail_dir");
    compile_source($filename, "$jail_dir/$exe_name");
    $cmd = "./jrun --dir=$jail_dir --prog=$exe_name $args";

    log_print("Running $cmd");
    $res = shell_exec($cmd);
    system("rm -rf $jail_dir");
    return trim($res);
}

// Run one test.
// Returns true/false on success/failure.
function run_test($filename)
{
    global $extra_args;

    if (!file_exists($filename)) {
        log_error("$filename doesn't exists.\n");
    }

    parse_source($filename, &$test_args, &$test_exp_res);
    $test_res = jail_run($filename, "$test_args $extra_args");

    if (!preg_match("/^$test_exp_res$/", $test_res)) {
        $result = false;
        print("FAIL: $filename\n");
        print("wanted: $test_exp_res\n");
        print("got: $test_res\n");
    } else {
        $result = true;
        print("OK: $filename\n");
        print("got: $test_res\n");
    }

    return $result;
}

// Main function.
function run_all()
{
    $tests_total = $tests_failed = 0;
    $failed_names = array();

    foreach (glob("tests/*") as $filename) {
        ++$tests_total;
        if (run_test($filename) == false) {
            ++$tests_failed;
            $failed_names[] = $filename;
        }
    }
    if ($tests_failed) {
        printf("Failed $tests_failed out of $tests_total (%.2lf%%)\n",
                100.0 * $tests_failed / $tests_total);
        printf("Tests that failed: ".implode(', ', $failed_names).".\n");
    } else {
        print("All $tests_total tests OK.\n");
    }
}

// Compile jail.
system("make", $ret);
if ($ret) {
    print("Jailer compilation failed, aborting\n");
    exit(-1);
}

do {
    if ($argc == 1) {
        run_all();
    } else if ($argc == 2) {
        run_test($argv[1]);
    } else {
        print("Invalid arguments\n");
    }
} while (false);

?>
