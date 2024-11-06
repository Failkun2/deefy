<?php

namespace iutnc\deefy\renderer;
require_once 'vendor/autoload.php';
use \iutnc\deefy\audio\tracks\AudioTrack as AudioTrack;
use \iutnc\deefy\renderer\Renderer as Renderer;


abstract class AudioTrackRenderer implements Renderer{

    protected AudioTrack $at;
    public const COMPACT = 1;
    public const LONG = 2;

    public function __construct(AudioTrack $at){
        $this->at = $at;
    }

    public function render(int $selector){
        switch($selector){
            case self::COMPACT :
                return $this->renderCompact();
                break;
            case self::LONG :
                return $this->renderLong();
                break;
            default:
                return "";
                break;
        }
    }

    public abstract function renderCompact();

    public abstract function renderLong();
}