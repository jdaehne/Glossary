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
        $this->glossary = new GlossaryBase($this->modx);
    }

    public function loadCustomCssJs()
    {
        if ($this->glossary->getOption('debug') && ($this->glossary->getOption('assetsUrl') != MODX_ASSETS_URL . 'components/packeteer/')) {
            $this->addJavascript($this->glossary->getOption('jsUrl') . 'mgr/glossary.js');
            $this->addJavascript($this->glossary->getOption('jsUrl') . 'mgr/widgets/home.panel.js');
            $this->addJavascript($this->glossary->getOption('jsUrl') . 'mgr/widgets/terms.grid.js');
            $this->addLastJavascript($this->glossary->getOption('jsUrl') . 'mgr/sections/home.js');
            $this->addCss($this->glossary->getOption('cssUrl') . 'mgr/glossary.css');
        } else {
            $this->addJavascript($this->glossary->getOption('jsUrl') . 'mgr/glossary.min.js');
            $this->addCss($this->glossary->getOption('cssUrl') . 'mgr/glossary.min.css?v=v' . $this->glossary->version);
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