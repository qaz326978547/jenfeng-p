<?php // AhWei - fezexp9987@gmail.com - line: fezexp

namespace AhWei\Tracy;

use Tracy\IBarPanel;
use Illuminate\Http\Request;

class RequestPanel implements IBarPanel
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
        require __DIR__ . '/view/RequestPanel/tab.php';
        return ob_get_clean();
    }

    public function getPanelView()
    {
        $rows = [];
        $request = Request::capture();

        $rows = [
            'ip'      => $request->ip(),
            'ips'     => $request->ips(),
            'query'   => $request->query(),
            'request' => $request->all(),
            'file'    => $request->file(),
            'cookies' => $request->cookie(),
            'format'  => $request->format(),
            'path'    => $request->path(),
            'server'  => $request->server(),
            'headers' => $request->header(),
        ];

        ob_start();
        require __DIR__ . '/view/RequestPanel/panel.php';
        return ob_get_clean();
    }
}