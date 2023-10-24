<?php

namespace App\Classes;

class Month {
  public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

  private $months = ['Janvier', 'Février', 'Mars', 'Avri', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octbre' ,'Novembre', 'Décembre'];
  public $month;
  public $year;

  public function __construct(?int $month = null, ?int $year = null) {
    if ($month === null || $month <1 || $month >12){
      $month = intval(date('m'));
    }
    if ($year === null){
      $year = intval(date('Y'));
    }
    $this->month = $month;
    $this->year = $year;
    
  }

  public function getStartingDay(): \DateTime {
    return new \DateTime("{$this->year} - {$this->month} - 01");
  }

  public function toString(): string {
    return $this->months[$this->month - 1] . ' ' . $this->year; 
  }

  public function getWeeks(): int {
    $start = $this->getStartingDay();
    $end = (clone $start)->modify('+1 month -1 days');
    $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
    if ($weeks < 0) {
      $weeks = intval($end->format('W'));
    }
    return $weeks;
  }
  
  
}