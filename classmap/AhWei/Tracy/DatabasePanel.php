<?php // AhWei - fezexp9987@gmail.com - line: fezexp

namespace AhWei\Tracy;

use Tracy\IBarPanel;

class DatabasePanel implements IBarPanel
{

    protected $queries = [];

    public function setQueries($queries)
    {
        $this->queries[] = $queries;
    }

    public function getTab()
    {
        return $this->getTabView();
    }

    public function getPanel()
    {
        return $this->getPanelView();
    }

    public function getTabView()
    {
        ob_start();
        require __DIR__ . '/view/DataBasePanel/tab.php';
        return ob_get_clean();
    }

    public function getPanelView()
    {
        $rows = [];

        foreach ($this->queries as $key => $value) {
            $sql = str_replace("?", "'%s'", $value->sql);
            $log = vsprintf($sql, $value->bindings);

            $rows[$key . '. ' . $value->time] = ['sql' => $log];
        }

        ob_start();
        require __DIR__ . '/view/DataBasePanel/panel.php';
        return ob_get_clean();
    }
}