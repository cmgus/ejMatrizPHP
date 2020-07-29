<?php

class Transporte
{
  private $fo;
  private $oferta;
  private $demanda;
  private $costos;
  private $tablero;
  public function __construct(Matriz $fo, Matriz $demanda, Matriz $oferta)
  {
    $this->fo = $fo;
    $this->oferta = $oferta;
    $this->demanda = $demanda;
    $this->armarTablero();
  }
  public function resolver(): Matriz
  {
      $menor = 99999;
      $k = [];
      for ($i = 0; $i < $this->costos->_m; $i++) {
        for ($j = 0; $j < $this->costos->_n; $j++) {
          if ($this->oferta->_datos[$i][0] <= 0) continue;
          if ($this->demanda->_datos[0][$j] <= 0) continue;
          if ($this->costos->_datos[$i][$j] < $menor && $this->tablero->_datos[$i][$j] === 0) {
            $menor = $this->costos->_datos[$i][$j];
            $k = [$i, $j];
          }
        }
      }
      if (!isset($k[0])) return $this->resolver();
      if (!isset($k[1])) return $this->resolver();
      $oferta = $this->oferta->_datos[$k[0]][0];
      $demanda = $this->demanda->_datos[0][$k[1]];
      $this->tablero->_datos[$k[0]][$k[1]] = $oferta;
      if ($oferta === $demanda) {
        $this->tablero->_datos[$k[0]][$k[1]] = $oferta;
        $this->oferta->_datos[$k[0]][0] = 0;
        $this->demanda->_datos[0][$k[1]] = 0;
      }
      if ($oferta < $demanda) {
        $this->tablero->_datos[$k[0]][$k[1]] = $oferta;
        $this->demanda->_datos[0][$k[1]] -= $oferta;
        $this->oferta->_datos[$k[0]][0] = 0;
      }
      if ($oferta > $demanda) {
        $this->tablero->_datos[$k[0]][$k[1]] = $demanda;
        $this->oferta->_datos[$k[0]][0] -= $demanda;
        $this->demanda->_datos[0][$k[1]] = 0;
      }
      if ($this->satisfecho()) return $this->tablero;
      
    return $this->resolver();
  }
  private function satisfecho(): bool
  {
    for ($j = 0; $j < $this->demanda->_n; $j++) {
      if ($this->demanda->_datos[0][$j] !== 0) return false;
    }
    for ($i = 0; $i < $this->oferta->_m; $i++) {
      if ($this->oferta->_datos[$i][0] !== 0) return false;
    }
    return true;
  }
  public function armarTablero(): void
  {
    $m_t = $this->oferta->_m;
    $n_t = $this->demanda->_n;
    $costos = [];
    $tablero = [];
    $c = 0;
    for ($i = 0; $i < $m_t; $i++) {
      for ($j = 0; $j < $n_t; $j++) {
        $costos[$i][] = $this->fo->_datos[0][$c];
        $tablero[$i][] = 0;
        $c++;
      }
    }
    $this->tablero = new Matriz($tablero);
    $this->costos = new Matriz($costos);
  }
}
