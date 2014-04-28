<?php
/**
 * DokuWiki Plugin duoshuo (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Matt <caijiamx@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_duoshuo extends DokuWiki_Syntax_Plugin {
    const DUOSHUO_SYNTAX = "~~DUOSHUO~~";
    const NODUOSHUO_SYNTAX = "~~NODUOSHUO~~";
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 160;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern(self::DUOSHUO_SYNTAX,$mode,'plugin_duoshuo');
        $this->Lexer->addSpecialPattern(self::NODUOSHUO_SYNTAX,$mode,'plugin_duoshuo');
    }

    /**
     * Handle matches of the duoshuo syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, &$handler){
        $match = preg_replace( '/~~/' , '' , $match );
        return array(strtolower($match));;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, &$renderer, $data) {
        if($mode != 'xhtml') return false;
        if($data[0] == "duoshuo"){
            $renderer->doc .= $this->_duoshuo();
        }
        return true;
    }

    function _duoshuo(){
        $doc = '
        <!-- Duoshuo Comment BEGIN -->
                <div class="ds-thread"></div>
            <script type="text/javascript">
            var duoshuoQuery = {short_name:"' . $this->getConf('shortname') . '"};
                (function() {
                    var ds = document.createElement("script");
                    ds.type = "text/javascript";ds.async = true;
                    ds.src = "http://static.duoshuo.com/embed.js";
                    ds.charset = "UTF-8";
                    (document.getElementsByTagName("head")[0] 
                    || document.getElementsByTagName("body")[0]).appendChild(ds);
                })();
                </script>
        <!-- Duoshuo Comment END -->';
        return $doc;
    }
}

// vim:ts=4:sw=4:et:
