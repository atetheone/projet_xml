<?php

class Liste extends DescriptionElement {
  public $items = [];

  public function __construct($items) {
    $this->items = $items;
  }
}
