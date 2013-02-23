<?php
namespace Phargs\Formatter;

class Tsv {
  protected $fields = array(); 
  protected $fieldCount = 0;
  protected $rows = array();

  public function __construct(Array $fields = array()){
    $this->setFields($fields); 
  }
  
  public function setFields(Array $fields){
    $this->fields = $fields;
    $this->fieldCount = sizeOf($this->fields);
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
  }

  public function addRows(Array $rows){
    foreach ($rows as $row){
      if (!is_array($row)) continue;
      $this->addRow($row);
    }
  }

  protected function getRowString(Array $row){
    return implode("\t", $row);
  }

  public function getTsvString(){
    $out = $this->getRowString($this->fields).PHP_EOL;

    // Rows 
    foreach ($this->rows as $row){
      $out .= $this->getRowString($row).PHP_EOL;
    }
    
    return $out;
  }

  public function __toString(){
    return $this->getTsvString();
  }

}
