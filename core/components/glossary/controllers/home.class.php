<?php
/**
 * Home Manager Controller class for Glossary CMP.
 *
 * @package glossary
 * @subpackage controller
 */
require_once dirname(dirname(__FILE__)) . '/model/glossary/glossarybase.class.php';

class GlossaryHomeManagerController extends modExtraManagerController
{
    /** @var GlossaryBase $glossary */
    public $glossary;

    public function initialize()
    {
        $path = $this->modx->getOption('glossary.core_path', null, $this->modx->getOption('core_path') . 'components/glossary/');
        $this->glossary = $this->modx->getService('glossary', 'GlossaryBase', $path . '/model/glossary/');
    }

    public function loadCustomCssJs()
    {
        $assetsUrl = $this->glossary->getOption('assetsUrl');
        $jsUrl = $this->glossary->getOption('jsUrl') . 'mgr/';
        $jsSourceUrl = $assetsUrl . '../../../source/js/mgr/';
        $cssUrl = $this->glossary->getOption('cssUrl') . 'mgr/';
        $cssSourceUrl = $assetsUrl . '../../../source/css/mgr/';

        if ($this->glossary->getOption('debug') && ($this->glossary->getOption('assetsUrl') != MODX_ASSETS_URL . 'components/packeteer/')) {
            $this->addJavascript($jsSourceUrl . 'glossary.js');
            $this->addJavascript($jsSourceUrl . 'widgets/home.panel.js');
            $this->addJavascript($jsSourceUrl . 'widgets/terms.grid.js');
            $this->addLastJavascript($jsSourceUrl . 'sections/home.js');
            $this->addCss($cssSourceUrl . 'glossary.css');
        } else {
            $this->addJavascript($jsUrl . 'glossary.min.js');
            $this->addCss($cssUrl . 'glossary.min.css?v=v' . $this->glossary->version);
        }
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Glossary.config = ' . $this->modx->toJSON($this->glossary->config) . ';
            MODx.load({xtype: "glossary-page-home"});
        });
        </script>');
    }

    public function getLanguageTopics()
    {
        return array('glossary:default');
    }

    public function process(array $scriptProperties = array())
    {
    }

    public function getPageTitle()
    {
        return $this->modx->lexicon('glossary');
    }

    public function getTemplateFile()
    {
        return $this->glossary->getOption('templatesPath') . 'home.tpl';
    }
}