<?php // AhWei - fezexp9987@gmail.com - line: fezexp

namespace AhWei\Tracy;

use Tracy\IBarPanel;

class SessionPanel implements IBarPanel
{
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
        require __DIR__ . '/view/SessionPanel/tab.php';
        return ob_get_clean();
    }

    public function getPanelView()
    {
        $rows = [];

        $rows = [
            'sessionId'      => \Session::getId(),
            'sessionConfig'  => \Session::getSessionConfig(),
            'laravelSession' => \Session::all(),
        ];

        $rows['nativeSessionId'] = session_id();
        $rows['nativeSession'] = $_SESSION;

        ob_start();
        require __DIR__ . '/view/SessionPanel/panel.php';
        return ob_get_clean();
    }
}