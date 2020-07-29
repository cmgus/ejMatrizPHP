<?php
class Matriz
{
  public $_datos;
  public $_m;    //Filas
  public $_n;    //Columnas
  public function __construct($datos)
  {
    $this->_datos = $datos;
    $this->_m = count($datos);
    $this->_n = count($datos[0]);
  }
  public function sumar(Matriz $B)
  {
    $c = [];
    if ($this->_m == $B->_m && $this->_n == $B->_n) {
      for ($i = 0; $i < $this->_m; $i++) {
        for ($j = 0; $j < $this->_n; $j++) {
          $c[$i][$j] = $this->_datos[$i][$j] + $B->_datos[$i][$j];
        }
      }
    }
    return new Matriz($c);
  }
  public function multiplicar(Matriz $B)
  {
    $p = ($this->_n == $B->_m) ? $this->_n : null;
    $c = [];
    if ($p != null) {
      for ($i = 0; $i < $this->_m; $i++) {
        $c[] = [];
        for ($j = 0; $j < $B->_n; $j++) {
          $c[$i][] = 0.0;
          for ($k = 0; $k < $p; $k++) {
            $c[$i][$j] += $this->_datos[$i][$k] * $B->_datos[$k][$j];
          }
        }
      }
    }
    return new Matriz($c);
  }
  public function determinante(): float
  {
    if ($this->_n === 1) {
      return $this->_datos[0][0];
    }
    $determinante = 0.0;
    for ($col = 0; $col < $this->_n; $col++) {
      $determinante += $this->_datos[0][$col] * $this->cofactor(0, $col);
    }
    return $determinante;
  }
  private function cofactor(int $fila, int $columna)
  {
    $menor = $this->matrizMenor($fila, $columna);
    $detM = $menor->determinante();
    return pow(-1, $fila + $columna) * $detM;
  }
  public function matrizMenor(int $f, int $c): Matriz
  {
    $menor = [];
    for ($k = 0; $k < $this->_m; $k++) {
      $filaMenor = [];
      if ($f !== $k) {
        for ($l = 0; $l < $this->_n; $l++) {
          if ($c !== $l) {
            $filaMenor[] = $this->_datos[$k][$l];
          }
        }
        $menor[] = $filaMenor;
      }
    }
    return new Matriz($menor);
  }
  public function transpuesta(): Matriz
  {
    $c = [];
    for ($j = 0; $j < $this->_n; $j++) {
      for ($i = 0; $i < $this->_m; $i++) {
        $c[$j][] = $this->_datos[$i][$j];
      }
    }
    return new Matriz($c);
  }
  public function adjunta(): Matriz
  {
    $cofactores = [];
    for ($i = 0; $i < $this->_m; $i++) {
      for ($j = 0; $j < $this->_n; $j++) {
        $cofactores[$i][$j] = $this->cofactor($i, $j);
      }
    }
    $cof = new Matriz($cofactores);
    return $cof->transpuesta();
  }
  public function inversa(): Matriz
  {
    $inv = [];
    $det = $this->determinante();
    $adj = $this->adjunta();
    if ($det !== 0) {
      $inv = $adj->productoEscalar(1 / $det)->_datos;
    }
    return new Matriz($inv);
  }
  public function imprimir(bool $break)
  {
    $table = '<table border="1" align="center" style="display: inline-block; border-collapse: collapse;">';
    foreach ($this->_datos as $filas) {
      $table .= '<tr>';
      foreach ($filas as $columnas) {
        $table .= '<td style="text-align: center; padding: 0.5em 0.8em;">' . $columnas . '</td> ';
      }
      $table .= '</tr>';
    }
    $table .= '</table>';
    $table .= ($break) ? '<br>' : '';
    echo $table;
  }
  public function __toString()
  {
    return "Matriz de orden: " . $this->_m . " x " . $this->_n;
  }
  public function rango(): int
  {
    $rango = $this->_m;
    $det = $this->determinante();
    if ($det !== 0.0) return $rango;
    /* while ($det !== 0.0) {
      for ($i = 0; $i < $this->_m; $i++) {
        for ($j = 0; $j < $this->_n; $j++) {
          $detM = $this->matrizMenor($i, $j)->determinante();
          if ($detM !== 0.0) return $rango--;
        }
      }
    } */
    return $det;
  }
  public function esIgual(Matriz $x): bool
  {
    if ($this->_m !== $x->_m || $this->_n !== $x->_n) return false;
    for ($i = 0; $i < $this->_m; $i++) {
      for ($j = 0; $j < $this->_n; $j++) {
        if ((string) $this->_datos[$i][$j] !== (string) $x->_datos[$i][$j]) return false;
      }
    }
    return true;
  }
  public function matrizIdentidad(): Matriz
  {
    $x = [];
    for ($i = 0; $i < $this->_m; $i++) {
      $x[] = [];
      for ($j = 0; $j < $this->_n; $j++) {
        $x[$i][$j] = ($i === $j) ? 1 : 0;
      }
    }
    return new Matriz($x);
  }
  public function esOrtogonal(): bool
  {
    $o = $this->multiplicar($this->transpuesta());
    $i = $this->matrizIdentidad();
    return $o->esIgual($i);
  }
  public function esOrtogonal2(): bool
  {
    $transpuesta = $this->transpuesta();
    $inversa = $this->inversa();
    return $transpuesta->esIgual($inversa);
  }
  public function productoEscalar(float $escalar): Matriz
  {
    $x = [];
    for ($i = 0; $i < $this->_m; $i++) {
      for ($j = 0; $j < $this->_n; $j++) {
        $x[$i][$j] = $escalar * $this->_datos[$i][$j];
      }
    }
    return new Matriz($x);
  }
  public function restar(Matriz $x): Matriz
  {
    $z = $this->sumar($x->productoEscalar(-1));
    return $z;
  }
}
