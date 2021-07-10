<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<header>
    <div id="logo"><img src="/logo.png">HTML5&nbsp;Layout</div>
    <nav>  
        <ul>
            <li><a href="/">Home</a>
            <li><a href="https://html-css-js.com/">HTML</a>
            <li><a href="https://html-css-js.com/css/code/">CSS</a>
            <li><a href="https://htmlcheatsheet.com/js/">JS</a>
        </ul>
    </nav>
    <?php
    // Evitar cualquier tipo de cache
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    ?>
</header>
<section>
    <strong>E EEEE E E E E E</strong>
</section>
<section id="pageContent">
    <main role="main">
        <article>
            <h2>Sección uno</h2>
            <p><?php
// Process params

$cmd = 'ssh mpiuser@192.168.0.220 mpirun -np 32 --hostfile /mpishared/hostfile --mca opal_warn_on_missing_libcuda 0 /mpishared/NPB3.4.2/NPB3.4-MPI/bin/is.C.x';
$descriptorspec = array(
    1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
);
$cwd = '/mpishared';

// Process start and loop
$proc = proc_open($cmd, $descriptorspec, $pipes, $cwd);

//echo '<pre>';
while (!feof($pipes[1]))
{
    echo fread($pipes[1], 1);
    ob_flush();
    flush();
}
//echo '</pre>';
?></p>
        </article>
        <article>
            <h2>Section 2</h2>
            <p>Eum facete intellegat ei, ut mazim melius usu. Has elit simul primis ne, regione minimum id cum. Sea deleniti dissentiet ea. Illud mollis moderatius ut per, at qui ubique populo. Eum ad cibo legimus, vim ei quidam fastidii.</p>
        </article>
        <article>
            <h2>Section 3</h2>
            <p>Quo debet vivendo ex. Qui ut admodum senserit partiendo. Id adipiscing disputando eam, sea id magna pertinax concludaturque. Ex ignota epicurei quo, his ex doctus delenit fabellas, erat timeam cotidieque sit in. Vel eu soleat voluptatibus, cum cu exerci mediocritatem. Malis legere at per, has brute putant animal et, in consul utamur usu.</p>
        </article>
        <article>
            <h2>His at autem inani volutpat</h2>
            <p>Te has amet modo perfecto, te eum mucius conclusionemque, mel te erat deterruisset. Duo ceteros phaedrum id, ornatus postulant in sea. His at autem inani volutpat. Tollit possit in pri, platonem persecuti ad vix, vel nisl albucius gloriatur no.</p>
        </article>
    </main>
    <aside>
        <div>Sidebar 1</div>
        <div>Sidebar 2</div>
        <div>Sidebar 3</div>
    </aside>
</section>
    
</body>
</html>