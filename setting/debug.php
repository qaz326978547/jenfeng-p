<?php isset($check_system_key) or exit('No direct script access allowed'); // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

use Tracy\Debugger;
use Tracy\Helpers;
use AhWei\Tracy\DatabasePanel;
use AhWei\Tracy\ViewPanel;
use AhWei\Tracy\SessionPanel;
use AhWei\Tracy\RequestPanel;
use Illuminate\Database\Events\QueryExecuted;

$environment = Debugger::DEVELOPMENT;
Debugger::enable($environment);

$database_panel = new DatabasePanel;
$view_panel = new ViewPanel;

Event::listen(QueryExecuted::class, function ($event) use ($database_panel) {
	$database_panel->setQueries($event);
});

Event::listen('composing:*', function ($key, $payload) use ($view_panel) {
	$view_panel->setView($payload);
});

Debugger::getBar()->addPanel($database_panel);
Debugger::getBar()->addPanel($view_panel);
Debugger::getBar()->addPanel(new SessionPanel);
Debugger::getBar()->addPanel(new RequestPanel);
error_reporting(E_ERROR | E_WARNING);
Debugger::$strictMode = true;
Debugger::$showBar = true;
Debugger::$productionMode = false;
Debugger::$maxDepth = 7;
Debugger::$maxLength = 1000;
Debugger::$showLocation = Tracy\Dumper::LOCATION_CLASS | Tracy\Dumper::LOCATION_LINK;
Debugger::$showLocation = true;
Debugger::$editor = 'subl://open?url=file://%file&line=%line';