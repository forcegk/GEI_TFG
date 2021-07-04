<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
</head>
<body>

<?php

    // Evitar cualquier tipo de cache
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    // Process params

    $cmd = 'ssh mpiuser@192.168.0.220 mpirun -np 32 --hostfile /mpishared/hostfile --mca opal_warn_on_missing_libcuda 0 /mpishared/NPB3.4.2/NPB3.4-MPI/bin/is.C.x';
    $descriptorspec = array(
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
    );
    $cwd = '/mpishared';

    // Process start and loop
    $proc = proc_open($cmd, $descriptorspec, $pipes, $cwd);

    echo '<pre>';
    while (!feof($pipes[1]))
    {
        echo fread($pipes[1], 1);
        ob_flush();
        flush();
    }
    echo '</pre>';
?>
    
</body>
</html>