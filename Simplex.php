<?php

class Simplex
{
  private $fo;
  private $restric;
  private $tablero;
  private $sol;
  public function __construct(Matriz $fo, Matriz $restric)
  {
    $this->fo = $fo;
    $this->restric = $restric;
    $this->tablero = $this->armarTablero();
    for ($i = 1; $i <= $this->restric->_m; $i++) {
      $this->sol[] = $i;
    }
  }
  public function resolver(): Matriz
  {
    $cj = new Matriz([$this->tablero->_datos[$this->tablero->_m - 1]]);
    // Vector que entra a la base
    $cj_ok = $this->elePositivosVec($cj);
    if ($cj_ok) return $this->tablero;
    // vector que sale de la base (columna)
    $xSale = $this->menorEleVec($cj); // indice del vetor que entra a la base
    $cocientes = [];
    for ($i = 0; $i < ($this->tablero->_m - 1); $i++) {
      if ($this->tablero->_datos[$i][$this->tablero->_n - 1] < 0 || $this->tablero->_datos[$i][$xSale] <= 0) {
        $cocientes[] = 9999999;
        continue;
      }
      $cocientes[] = $this->tablero->_datos[$i][$this->tablero->_n - 1] / $this->tablero->_datos[$i][$xSale];
    }
    if ($cocientes[0] <= 0) {
      echo 'Solucion basica degenerada';
      return $this->tablero;
    }
    $c = new Matriz([$cocientes]);
    // vector que entra en la base (fila)
    $xEntra = $this->menorEleVec($c);
    // Elemento pivote
    $elePiv = $this->tablero->_datos[$xEntra][$xSale];
    // Fila pivote
    //echo $elePiv;
    if ($elePiv === 0.0) {
      echo 'Solucion basica degenerada';
      return $this->tablero;
    }
    $filaPiv = new Matriz([$this->tablero->_datos[$xEntra]]);
    // Nueva fila pivote
    $filaPiv = $filaPiv->productoEscalar(1 / $elePiv);
    // $filaPiv->imprimir(true);
    $this->tablero->_datos[$xEntra] = $filaPiv->_datos[0];
    for ($i = 0; $i < $this->tablero->_m; $i++) {
      if ($i === $xEntra) continue;
      $tableroFila = new Matriz([$this->tablero->_datos[$i]]);
      $filaPivTemp = $filaPiv->productoEscalar(-1 * $tableroFila->_datos[0][$xSale]);
      $this->tablero->_datos[$i] = $tableroFila->sumar($filaPivTemp)->_datos[0];
    }
    $this->sol[$xSale] = $xEntra + 1;
    return $this->resolver();
  }
  private function armarTablero(): Matriz
  {
    // m x n del tablero
    $m_t = $this->restric->_m + 1;
    $n_t = ($this->fo->_n + $this->restric->_m) + 2;
    $tablero = [];
    $aux = ($this->restric->_n - 1); // Para los unos
    for ($i = 0; $i < $m_t; $i++) {
      $fila_t = [];
      for ($j = 0; $j < $n_t; $j++) {

        if ($i < ($this->restric->_m) && ($j < $this->restric->_n - 1)) {
          $fila_t[] = $this->restric->_datos[$i][$j];
          continue;
        }
        if ($j === ($n_t - 1) && $i < ($m_t - 1)) {
          // echo $this->restric->_datos[$i][$this->restric->_n - 1];
          $fila_t[] = $this->restric->_datos[$i][$this->restric->_n - 1];
          continue;
        }
        if ($i === ($m_t - 1) && $j < $this->fo->_n) {
          // echo "[0][$j]" . $this->fo->_datos[0][$j] . "; ";
          $fila_t[] = $this->fo->_datos[0][$j] * -1;
          continue;
        }
        if ($i === ($j - $aux)) {
          $fila_t[] = 1;
          continue;
        }
        $fila_t[] = 0;
      }
      $tablero[] = $fila_t;
    }

    return new Matriz($tablero);
  }
  private function menorEleVec(Matriz $vector): int
  {
    $x = 0;
    $menor = $vector->_datos[0][0];
    for ($i = 0; $i < $vector->_n; $i++) {
      // echo $vector->_datos[0][$i] . " < $menor; ";
      if ($vector->_datos[0][$i] < $menor) {
        $menor = $vector->_datos[0][$i];
        $x = $i;
      }
      //echo 'Menor: ' . $menor;
    }
    //echo "Menor: $menor";
    return $x;
  }
  private function elePositivosVec(Matriz $vector): bool
  {
    for ($i = 0; $i < $vector->_n; $i++) {
      if ($vector->_datos[0][$i] < 0) return false;
    }
    return true;
  }
  public function soluciones(): array
  {
    return $this->sol;
  }
}
