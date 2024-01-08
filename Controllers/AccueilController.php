<?php

namespace Controllers;

class AccueilController
{
    public function __construct($action)
    {
        switch ($action) {
            case "index":
                $this->afficherAccueilView();
                break;
        }
    }

    private function afficherAccueilView()
    {
        include "Views/AccueilView.php";
    }
}
