<?php
//echo "Hola Mundo";
echo '<div style="text-align: center;">';
/* $ejer = $_GET['ejer'];
echo $ejer; */
$datosEje = [
  [7, 6, 3, 7, 5],
  [7, 2, 5, 0, 5],
  [3, 3, 4, 6, 0],
  [9, 0, 6, 7, 7],
  [8, 2, 0, 1, 2]
];
$datosEjer1 = [[]];
$datosEjer2 = [[]];
$datosEjer3 = [[]];
$datosEjer4 = [[]];
$A = new Matriz([
  [0.4, 0.5, 0.3],
  [0.2, 0.1, 0.1],
  [0.2, 0.2, 0.1]
]);
$C = new Matriz([
  [77],
  [154],
  [231]
]);
$I = new Matriz([
  [1, 0, 0],
  [0, 1, 0],
  [0, 0, 1]
]);
/* $dd = new Matriz($datosEje);
echo $dd->determinante(); */
/* echo 'A = ';
$A->imprimir();
echo ' C = ';
$C->imprimir();
echo '<br>';
echo 'I - A = ';
$I_A = $I->restar($A);
$I_A->imprimir();
echo '<br><br>';
echo '|I - A| = ';
echo $I_A->determinante();
echo '<br><br>';
echo '(I-A)<sup>-1</sup> = ';
$invIA = $I_A->inversa();
$invIA->imprimir();
echo '<br>';
echo 'X = (I - A)<sup>-1</sup>C = ';
$X = $invIA->multiplicar($C);
$X->imprimir();
echo '</div>'; */
