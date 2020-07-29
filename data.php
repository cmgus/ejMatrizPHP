<?php

// Matriz ortogonal
$g = new Matriz([
  [1 / 3, -2 / 3, 2 / 3],
  [2 / 3, 2 / 3, 1 / 3],
  [-2 / 3, 1 / 3, 2 / 3]
]);

$j = new Matriz([
  [1 / 3, -2 / 3, 2 / 3],
  [2 / 3, 2 / 3, 1 / 3],
  [-2 / 3, 1 / 3, 2 / 3]
]);

// MEOTDO SIMPLEX
// Ejemplo1
    // (FO) Z = 5x + 4x
    /* $fo = new Matriz([
      [5, 4]
    ]);
    $res = new Matriz([
      [1, 1, 20],
      [2, 1, 35],
      [-3, 1, 12]
    ]); */
    /* $fo = new Matriz([
      [3, 4, 3 / 2]
    ]);
    $res = new Matriz([
      [1, 2, 0, 10],
      [2, 2, 1, 10]
    ]); */
    /* $fo = new Matriz([
      [1, 2]
    ]);
    $res = new Matriz([
      [2, 1, 8],
      [2, 3, 12]
    ]); */
    /* $simplex = new Simplex($fo, $res);
    $solBasica = $simplex->resolver();
    $solBasica->imprimir();
    print_r($simplex->soluciones()); */
/* $insu_prod = new Matriz([
      [0.2, 0.1, 0.2],
      [0.5, 0.2, 0.1],
      [0.1, 0.45, 0.3286]
    ]);
    $demanda = new Matriz([
      [1200],
      [2000],
      [5200]
    ]); */
    /* $insu_prod = new Matriz([
      [2 / 5, 1 / 2, 3 / 10],
      [1 / 5, 1 / 10, 1 / 10],
      [1 / 5, 1 / 5, 1 / 10]
    ]);
    $demanda = new Matriz([
      [77],
      [154],
      [231]
    ]); */
    /* $leontief = new Leontief($insu_prod);
    $x = $leontief->resolver($demanda);
    $x->imprimir(true); */
