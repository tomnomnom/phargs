<?php
namespace Phargs\Formatter;

class Table {
  protected $fields = array(); 
  protected $fieldWidths = array();
  protected $fieldCount = 0;
  protected $rows = array();

  protected $vertChar = '|';
  protected $horizChar = '-';

  public function __construct(Array $fields = array()){
    $this->setFields($fields); 
  }
  
  public function setFields(Array $fields){
    $this->fields = $fields;
    $this->fieldCount = sizeOf($this->fields);
    $this->setFieldWidths($this->fields);
  }

  protected function setFieldWidths(Array $row){
    for ($i = 0; $i < $this->fieldCount; $i++){
      if (!isset($this->fieldWidths[$i])){
        $this->fieldWidths[$i] = 0;
      }

      if (strlen($row[$i]) > $this->fieldWidths[$i]){
        $this->fieldWidths[$i] = strlen($row[$i]);
      }
    }
  }

  protected function getTableWidth(){
    $paddingEtc = (3 * $this->fieldCount) + 1;
    $fields = array_sum($this->fieldWidths);

    return $fields + $paddingEtc;
  }

  public function getFieldCount(){
    return $this->fieldCount;
  }

  public function getRowCount(){
    return sizeOf($this->rows);
  }

  public function addRow(Array $row){
    if (sizeOf($row) != $this->fieldCount){
      return false;
    }
    $this->rows[] = $row;
    $this->setFieldWidths($row);
  }

  protected function getRowString(Array $row){
    for ($i = 0; $i < $this->fieldCount; $i++){
      $finalWidth = $this->fieldWidths[$i];
      $paddingNeeded = $finalWidth - strlen($row[$i]);
      $row[$i] = $row[$i].str_repeat(' ', $paddingNeeded);
    }
    
    $out  = "{$this->vertChar} ";
    $out .= implode(" {$this->vertChar} ", $row);
    $out .= " {$this->vertChar}";

    return $out;
  }

  public function getTableString(){
    $tableWidth = $this->getTableWidth();

    // Top
    $out = str_repeat($this->horizChar, $tableWidth).PHP_EOL;
    
    // Headings
    $out .= $this->getRowString($this->fields).PHP_EOL;

    // Divider
    $out .= str_repeat($this->horizChar, $tableWidth).PHP_EOL;

    // Rows 
    foreach ($this->rows as $row){
      $out .= $this->getRowString($row).PHP_EOL;
    }

    // Bottom
    $out .= str_repeat($this->horizChar, $tableWidth).PHP_EOL;
    
    return $out;
  }

}
