<?php // AhWei - fezexp9987@gmail.com - line: fezexp

namespace AhWei\Tracy;

use Tracy\IBarPanel;
use Illuminate\Support\Arr;

class ViewPanel implements IBarPanel
{
    protected $view = [];

    public function setView($view)
    {
        $this->view = array_merge($this->view, $view);
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
        require __DIR__ . '/view/ViewPanel/tab.php';
        return ob_get_clean();
    }

    public function getPanelView()
    {
        $rows = [];

        foreach ($this->view as $key => $value) {
            $rows[$key] = ['name' => $value->getName(), 'data' => Arr::except($value->getData(), ['obLevel', '__env', 'app', '__currentLoopData'])];
        }

        ob_start();
        require __DIR__ . '/view/ViewPanel/panel.php';
        return ob_get_clean();
    }
}