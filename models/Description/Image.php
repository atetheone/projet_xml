<?php

class Image extends DescriptionElement {
  public $url;
  public $position;

  public function __construct($url, $position = null) {
    $this->url = $url;
    $this->position = $position;
  }
}
