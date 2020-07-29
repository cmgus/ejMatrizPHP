<?php

require_once 'Matriz.php';
require_once 'Simplex.php';
require_once 'Leontief.php';
require_once 'Transporte.php';
abstract class Index
{
  public static function main()
  {
    echo '<div style="text-align: center;">';
   // LEONTIEF
    /* $a = new Matriz([
      [1 / 5, 1 / 3],
      [3 / 10, 2 / 15]
    ]);
    $demanda = new Matriz([
      [500],
      [1200]
    ]); */
    /* $a = new Matriz([
      [2 / 5, 1 / 2, 3 / 10],
      [1 / 5, 1 / 10, 1 / 10],
      [1 / 5, 1 / 5, 1 / 10]
    ]);
    $demanda = new Matriz([
      [77],
      [154],
      [231]
    ]);
    $leon = new Leontief($a);
    $x = $leon->resolver($demanda);
    $x->imprimir(true); */


    //// SIMPLEX
    $fo = new Matriz([
      [5, 4]
    ]);
    $res = new Matriz([
      [1, 1, 20],
      [2, 1, 35],
      [-3, 1, 12]
    ]);
    /* $fo = new Matriz([
      [3, 4, 3 / 2]
    ]);
    $res = new Matriz([
      [1, 2, 0, 10],
      [2, 2, 1, 10]
    ]); */
    /* $simplex = new Simplex($fo, $res);
    $x = $simplex->resolver();
    $x->imprimir(true);
    echo var_dump($simplex->soluciones()); */

    /// TRANSPORTE
    // https://www.gestiondeoperaciones.net/programacion_lineal/metodo-del-costo-minimo-algoritmo-de-transporte-en-programacion-lineal/
    $fo = new Matriz([
      [10, 2, 20, 11, 12, 7, 9, 20, 4, 14, 16, 18]
    ]);
    $oferta = new Matriz([
      [15],
      [25],
      [10]
    ]);
    $demanda = new Matriz([
      [5, 15, 15, 15]
    ]);
    /// https://www.ingenieriaindustrialonline.com/investigacion-de-operaciones/metodo-del-costo-minimo/#:~:text=El%20m%C3%A9todo%20del%20costo%20m%C3%ADnimo,rutas%20que%20presentan%20menores%20costos.
    /* $fo = new Matriz([
      [5, 2, 7, 3, 3, 6, 6, 1, 6, 1, 2, 4, 4, 3, 6, 6]
    ]);
    $oferta = new Matriz([
      [80],
      [30],
      [60],
      [45]
    ]);
    $demanda = new Matriz([
      [70, 40, 70, 35]
    ]); */
    $tra = new Transporte($fo, $demanda, $oferta);
    $tab = $tra->resolver($demanda);
    $tab->imprimir(true);
    echo '</div>';
  }
}

Index::main();
