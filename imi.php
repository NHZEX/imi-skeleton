#!/usr/bin/env php
<?php

putenv('IMI_MACRO_LOCK_FILE_DIR=/dev/shm');
putenv('IMI_MACRO_OUTPUT_DIR=/dev/shm');

$main = require __DIR__ . '/vendor/imiphp/imi-swoole/bootstrap.php';
$main();