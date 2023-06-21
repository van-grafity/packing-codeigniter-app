<?php

namespace App\Controllers;
use CILogViewer\CILogViewer;

class LogViewerController extends BaseController
{
    public function index() {
        $logViewer = new CILogViewer();
        return $logViewer->showLogs();
    }
}