<?php

namespace kivweb\Views;

/**
 * Rozhrani pro vsechny sablony (views).
 * @package kivweb\Views
 */
interface IView {

    /**
     * Zajisti vypsani HTML sablony prislusne stranky.
     * @param array $tplData Data stranky.
     * @param string $pageInfo Ovladace Stranky
     */
    public function printOutput(array $tplData, string $pageInfo);

}
