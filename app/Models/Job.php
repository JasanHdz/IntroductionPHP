<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Job extends Model {
  protected $table = 'jobs';
  protected $months = 14;
  public function getDescription() {
    return '<strong style="color:blue;">Implementando Interface:</strong> ' . $this->description;
  }
  public function getDurationAsString() {
    $years = floor($this->months / 12);
    $meses =  $this->months % 12;
  
    if($years > 0) {
      if ($years == 1) {
        return "Total de Job: $years Year, $meses Months";
      } else {
        return "Total de Job: $years Years, $meses Months";
      }
    } else {
      return "Total de Job: $meses Months";
    }
  }
}