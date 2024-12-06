<?php
  function flipDate($date){

    $dateSub = substr($date, 8, 2).substr($date, 4, 4).substr($date, 0, 4);
    return $dateSub;
    
  }
?>