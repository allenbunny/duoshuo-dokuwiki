<?php
/**
 * DokuWiki Plugin duoshuo (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Matt <caijiamx@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_duoshuo extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler &$controller) {

       $controller->register_hook('PARSER_WIKITEXT_PREPROCESS', 'BEFORE', $this, 'handle_parser_wikitext_perprocess');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_parser_wikitext_perprocess(Doku_Event &$event, $param) {
        if($this->_canShowDuoshuo($event->data)){
            $event->data .= "\n ~~DUOSHUO~~";
        }
        return true;
    }
    /**
     * check canshow duoshuo
     *
     * @param string $data  wikitest
     * @return bool 
     */
    private function _canShowDuoshuo($data){
        $flag =false;
        $auto = $this->getConf('auto');
        $not_added = (strpos($data , '~~DUOSHUO~~') === false);
        if(isset($_REQUEST['do'])){
            $not_do = false;
        }else{
            $not_do = true;
        }
        if($auto && $not_added && $not_do){
            $flag =true;
        }
        return $flag;
    }
}

// vim:ts=4:sw=4:et:
