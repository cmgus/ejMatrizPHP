<?php

class CaminoCorto
{
    private $V;
    public function __construct(int $nVertices)
    {
        $this->V = $nVertices;
    }
    public function distanciaMinima(Matriz $dist, Matriz $ruta_corta): int
    {
        $min = PHP_INT_MAX;
        $min_index = -1;
        for ($v = 0; $v < $this->V; $v++) {
            if ($ruta_corta->_datos[0][$v] == false && $dist->_datos[0][$v] <= $min) {
                $min = $dist->_datos[0][$v];
                $min_index = $v;
            }
        }
        return $min_index;
    }
    public function dijkstra(Matriz $grafo, int $src): void
    {
        $dist = new Matriz([[]]);
        $ruta_corta = new Matriz([[]]);
        for ($i = 0; $i < $this->V; $i++) {
            $dist->_datos[0][$i] = PHP_INT_MAX;
            $ruta_corta->_datos[0][$i] = false;
        }
        $dist->_datos[0][$src] = 0;
        for ($count = 0; $count < $this->V - 1; $count++) {
            $u = $this->distanciaMinima($dist, $ruta_corta);
            $ruta_corta->_datos[0][$u] = true;
            for ($v = 0; $v < $this->V; $v++) {
                if (!$ruta_corta->_datos[0][$v] && $grafo->_datos[$u][$v] != 0 && $dist->_datos[0][$u] != PHP_INT_MAX && $dist->_datos[0][$u] + $grafo->_datos[$u][$v] < $dist->_datos[0][$v])
                    $dist->_datos[0][$v] = $dist->_datos[0][$u] + $grafo->_datos[$u][$v];
            }
        }
        $dist->imprimir(true);
    }
}
