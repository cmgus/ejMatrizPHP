<?php

class CPM_PERT
{
    private $d; // Matriz del diagrama de red
    // 1
    private $tpi; // Tiempo próximo i
    private $tpj; // Timpo próximo j
    private $tti; // Tiempo tardío i
    private $ttj; // Tiempo tardío j
    // 2
    private $tpi_dij; // TPi + Dij
    private $ttj_dij; // TTJ - Dij
    private $tablero;
    // 3
    // private $it; // Inicio más tardío
    // private $fp; // Finalización más próximo
    public function __construct(Matriz $d, Matriz $tpi, Matriz $ttj)
    {
        $this->d = $d;
        $this->tpi = $tpi;
        $this->ttj = $ttj;
    }
    public function ruta_critica()
    {
        // Determinacion de la ruta critica
        $this->tpi_mas_dij();
        $this->tp_j();
        $this->ttj_menos_dij();
        $this->tt_i();

        // Identificaión de las actividades de la ruta crítica
        $this->identificacion();
        // TT¡ (2) = TP¡ (0)
        // TTj (3) = TPj (1)
        // TTj (3) - TT¡ (2) = TPj (1) - TP¡ (0) = d¡j
        $ruta_critica = [[]];
        $num_act = -1;
        $this->tablero->imprimir(false);
        for ($m = 0; $m < $this->d->_m; $m++) {
            for ($n = 0; $n < $this->d->_n; $n++) {
                if ($this->d->_datos[$m][$n] >= 0 && $n < $this->d->_n) {
                    $num_act++;
                    $ruta_critica[$num_act][0] = 0;
                    if ($this->tablero->_datos[$num_act][3] !== $this->tablero->_datos[$num_act][1]) continue;
                    if ($this->tablero->_datos[$num_act][4] !== $this->tablero->_datos[$num_act][2]) continue;
                    if ($this->tablero->_datos[$num_act][4] - $this->tablero->_datos[$num_act][3] !== $this->d->_datos[$m][$n]) continue;
                    if ($this->tablero->_datos[$num_act][2] - $this->tablero->_datos[$num_act][1] !== $this->d->_datos[$m][$n]) continue;
                    //echo "num: $num_act: " . $this->tablero->_datos[$num_act][0] . ' ' . $this->tablero->_datos[$num_act][1] . ' '. $this->tablero->_datos[$num_act][2] . ' ' . $this->tablero->_datos[$num_act][3] . '<br>';
                    //echo "num: $num_act<br>" ;
                    $ruta_critica[$num_act][0] = 1;
                }
            }
        }
        $tablero_index = new Matriz([
            ['ACT','TPi', 'TPj', 'TTi', 'TTj', 'dij', 'ITij', 'FPij', 'HTij', 'HLij']
        ]);
        $RC = new Matriz($ruta_critica);
        $RC->imprimir(true);
        $tablero_index->imprimir(true);

    }
    public function identificacion()
    {
        $tab = [[]];
        $num_act = 0;
        //
        for ($i = 0; $i < $this->d->_m; $i++) {
            for ($j = 0; $j < $this->d->_n; $j++) {
                if ($this->d->_datos[$i][$j] <= -1) continue;
                // echo "[" . ($i + 1) . "][" . ($j + 1) ."] @@ ";
                $tab[$num_act][0] = ($i + 1) . '->' . ($j + 1);
                $tab[$num_act][1] = $this->tpi->_datos[$i][0]; // TPi
                $tab[$num_act][2] = $this->tpj->_datos[0][$j]; // TPj
                $tab[$num_act][3] = $this->tti->_datos[$i][0]; // TTi
                $tab[$num_act][4] = $this->ttj->_datos[0][$j]; // TTj
                $tab[$num_act][5] = $this->d->_datos[$i][$j]; // dij
                //
                $tab[$num_act][6] = $tab[$num_act][4] - $tab[$num_act][5]; // ITij
                $tab[$num_act][7] = $tab[$num_act][1] + $tab[$num_act][5]; // FPij
                //
                $tab[$num_act][8] = $tab[$num_act][6] - $tab[$num_act][1]; // HTij
                $tab[$num_act][9] = $tab[$num_act][2] - $tab[$num_act][1] - $tab[$num_act][5]; // HLij
                $num_act++;
            }
            // echo '<br>';
        }
        $this->tablero = new Matriz($tab);
        // $this->tablero->imprimir(true);
    }
    private function tpi_mas_dij()
    {
        $tp = [];
        $m = $this->d->_m;
        $n = $this->d->_n;
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $dij = $this->d->_datos[$i][$j];
                $tp[$i][$j] = $dij >= 0 ? $this->tpi->_datos[$i][0] + $dij : $dij;
            }
        }
        $this->tpi_dij = new Matriz($tp);
    }
    private function ttj_menos_dij()
    {
        $tt = [];
        $m = $this->d->_m;
        $n = $this->d->_n;
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $dij = $this->d->_datos[$i][$j];
                $tt[$i][$j] = $dij >= 0 ? $this->ttj->_datos[0][$j] - $dij : $dij;
            }
        }
        $this->ttj_dij = new Matriz($tt);
        // $this->ttj_dij->imprimir(true);
    }
    private function tp_j()
    {
        $tpj = [[]];
        // $m = $this->d->_m;
        $n = $this->d->_n;
        $transpuesta = $this->tpi_dij->transpuesta();
        //$transpuesta->imprimir(true);
        for ($j = 0; $j < $n; $j++) {
            if ($j === 0) {
                $tpj[0][$j] = 0;
                continue;
            }
            $vec_matriz_tpi_dij = new Matriz([$transpuesta->_datos[$j]]);
            $tpj[0][$j] = $vec_matriz_tpi_dij->_datos[0][$this->mayorEleVec($vec_matriz_tpi_dij)];
        }
        $this->tpj = new Matriz($tpj);
        //$this->tpj->imprimir(true);
    }
    private function tt_i()
    {
        $tti = [[]];
        $m = $this->d->_m;
        $n = $this->d->_n;
        //$tti[$m-1][0] = $this->ttj->_datos[0][$m-1];
        for ($i = 0; $i < $m; $i++) {
            if ($i === $m - 1) {
                $tti[$i][0] = $this->ttj->_datos[0][$n - 1];
                continue;
            }
            $vec_matriz_ttj_dij = new Matriz([$this->ttj_dij->_datos[$i]]);
            //$vec_matriz_ttj_dij->imprimir(true);
            $tti[$i][0] = 0;
            //$vec_matriz_ttj_dij = new Matriz([$this->ttj_dij->_datos[$i]]);
            $tti[$i][0] = $vec_matriz_ttj_dij->_datos[0][$this->menorEleVec($vec_matriz_ttj_dij)];
        }
        $this->tti = new Matriz($tti);
    }
    private function it_ij()
    {
        $it_ij = [[]];
        $num_act = -1;
        $this->tablero->imprimir(false);
        for ($m = 0; $m < $this->d->_m; $m++) {
            for ($n = 0; $n < $this->d->_n; $n++) {
                if ($this->d->_datos[$m][$n] >= 0 && $n < $this->d->_n) {
                    $num_act++;
                    $ruta_critica[$num_act][0] = 0;
                    if ($this->tablero->_datos[$num_act][2] !== $this->tablero->_datos[$num_act][0]) continue;
                    if ($this->tablero->_datos[$num_act][3] !== $this->tablero->_datos[$num_act][1]) continue;
                    if ($this->tablero->_datos[$num_act][3] - $this->tablero->_datos[$num_act][2] !== $this->d->_datos[$m][$n]) continue;
                    if ($this->tablero->_datos[$num_act][1] - $this->tablero->_datos[$num_act][0] !== $this->d->_datos[$m][$n]) continue;
                    //echo "num: $num_act: " . $this->tablero->_datos[$num_act][0] . ' ' . $this->tablero->_datos[$num_act][1] . ' '. $this->tablero->_datos[$num_act][2] . ' ' . $this->tablero->_datos[$num_act][3] . '<br>';
                    //echo "num: $num_act<br>" ;
                    $ruta_critica[$num_act][0] = 1;
                }
            }
        }
    }
    private function mayorEleVec(Matriz $vector): int
    {
        $x = 0;
        $menor = $vector->_datos[0][0];
        for ($i = 0; $i < $vector->_n; $i++) {
            // echo $vector->_datos[0][$i] . " < $menor; ";
            if ($vector->_datos[0][$i] > $menor) {
                $menor = $vector->_datos[0][$i];
                $x = $i;
            }
            //echo 'Menor: ' . $menor;
        }
        //echo "Menor: $menor";
        return $x;
    }
    private function menorEleVec(Matriz $vector): int
    {
        $x = 0;
        $menor = 999999;
        // $vector->imprimir(true);
        for ($i = 0; $i < $vector->_n; $i++) {
            if ($vector->_datos[0][$i] < $menor && $vector->_datos[0][$i] >= 0 && $menor >= 0) {
                $menor = $vector->_datos[0][$i];
                $x = $i;
            }
            //echo $vector->_datos[0][$i] . " < $menor; <br>";
            //echo 'Menor: ' . $menor;
        }
        // echo "Menor: $menor [$x]<br>";
        return $x;
    }
}
