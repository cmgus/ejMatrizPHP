<?php

class Leontief
{
  private $insu_prod;
  public function __construct(Matriz $insu_prod)
  {
    $this->insu_prod = $insu_prod;
  }
  public function resolver(Matriz $demanda): Matriz
  {
    // X = (I - A)^-1*C
    $I = $this->insu_prod->matrizIdentidad();
    $I_A = $I->restar($this->insu_prod);
    $inv = $I_A->inversa();
    return $inv->multiplicar($demanda);
  }
}
