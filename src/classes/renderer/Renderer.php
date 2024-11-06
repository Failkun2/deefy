<?php

namespace iutnc\deefy\renderer;

require_once 'vendor/autoload.php';


interface Renderer{

    public function render(int $selector);
    
}