<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;

class Dijkstra extends Model
{
    public function find($nodeA, $nodeB) {
      $nodes = (new Query())
          ->select(['id', 'x', 'y'])
          ->from('node')
          ->indexBy('id')
          ->all();

      $edges = (new Query())
          ->select(['id', 'a', 'b'])
          ->from('edge')
          ->all();

      $weight = [];
      $max = 0;

      foreach ($edges as $edge) {
          $a = $edge['a'];
          $b = $edge['b'];

          $na = $nodes[$a];
          $nb = $nodes[$b];

          $ax = $na['x'];
          $ay = $na['y'];
          $bx = $nb['x'];
          $by = $nb['y'];

          $distance = sqrt(pow($bx - $ax, 2) + pow($by - $ay, 2));

          if (isset($weight[$a])) {
              $weight[$a][$b] = $distance;
          } else {
              $weight[$a] = [$b => $distance];
          }

          if (isset($weight[$b])) {
              $weight[$b][$a] = $distance;
          } else {
              $weight[$b] = [$a => $distance];
          }

          $max += $distance;
      }

      $graph = [];
      $d = [];
      $p = [];
      $f = [];

      foreach ($nodes as $a => $node) {
          $graph[$a] = [$a => 0];

          foreach ($nodes as $b => $node) {
              if ($a != $b) {
                  $w = $max;

                  if (isset($weight[$a][$b])) {
                    $w = $weight[$a][$b];
                  }

                  $graph[$a][$b] = $w;
              }
          }
      }

      foreach ($nodes as $a => $node) {
          $p[$a] = $nodeA;
          $d[$a] = $graph[$nodeA][$a];
          $f[$a] = false;
      }

      $p[$nodeA] = '0';
      $f[$nodeA] = true;

      $count = count($nodes) - 1;

      for ($i=0; $i < $count; $i++) {
          $m = 0;
          $min = $max;

          foreach ($nodes as $id => $node) {
              if (!$f[$id] && $min > $d[$id]) {
                $min = $d[$id];
                $m = $id;
              }
          }

          $f[$m] = true;
          foreach ($nodes as $id => $node) {
              if (!$f[$id] && $d[$id] > $d[$m] + $graph[$m][$id]) {
                  $d[$id] = $d[$m] + $graph[$m][$id];
                  $p[$id] = $m;
              }
          }
      }

      $way = ['distance' => $d[$nodeB], 'path' => []];

      if ($way['distance'] > 0) {
        $way['path'][] = (integer)$nodes[$nodeB]['id'];
        $n = $p[$nodeB];
        while ($n > 0) {
          $way['path'][] = (integer)$nodes[$n]['id'];
          $n = $p[$n];
        }
      }

      return $way;
    }

    public function rules()
    {
        return [
            [['a', 'b'], 'required'],
            [['a', 'b'], 'integer'],
        ];
    }
}
