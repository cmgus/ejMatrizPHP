<?php
require_once '../Matriz.php';
require_once '../CPM_PERT.php';
abstract class Index
{
    public static function main()
    {
        echo "<div align='center'>";
        $tpi = new Matriz([
            [0],
            [8],
            [5],
            [8],
            [12],
            [10],
            [10],
            [20],
            [23]
        ]);
        $ttj = new Matriz([
            [0, 8, 5, 8, 12, 16, 16, 20, 23]
        ]);
        $d = new Matriz([
            [-99, 3, 5, -1, -1, -1, -1, -1, -1],
            [-1, -99, -1, -1, 4, -1, -1, -1, -1],
            [-1, -1, -99, 3, -1, -1, -1, -1, 5],
            [-1, 0, -1, -99, -1, 2, -1, -1, -1],
            [-1, -1, -1, -1, -99, -1, -1, 8, -1],
            [-1, -1, -1, -1, -1, -99, 0, 2, -1],
            [-1, -1, -1, -1, -1, -1, -99, 4, -1],
            [-1, -1, -1, -1, -1, -1, -1, -99, 3],
            [-1, -1, -1, -1, -1, -1, -1, -1, -99]
        ]);
        $cp = new CPM_PERT($d, $tpi, $ttj);
        $cp->ruta_critica();
        echo "</div>";
    }
}

Index::main();
