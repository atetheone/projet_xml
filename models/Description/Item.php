<?php

class Item extends DescriptionElement {
  public $content;

  public function __construct($content) {
    $this->content = $content;
  }
}
