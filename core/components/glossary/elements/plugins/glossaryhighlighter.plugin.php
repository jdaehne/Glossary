<?php
/**
 * Glossary Term Highlighter Plugin
 *
 * @package glossary
 * @subpackage plugin
 *
 * @event OnLoadWebDocument
 *
 * @var modX $modx
 */

switch ($modx->event->name) {
    case 'OnLoadWebDocument':
        $corePath = $modx->getOption('glossary.core_path', null, $modx->getOption('core_path') . 'components/glossary/');
        $glossary = $modx->getService('glossary', 'GlossaryBase', $corePath . 'model/glossary/', array(
            'core_path' => $corePath
        ));

        $targetResId = $glossary->getOption('resid');
        $chunkName = $glossary->getOption('tpl');

        if ($modx->getCount('modResource', $targetResId)) {
            if ($modx->resource->get('id') != $targetResId) {
                $content = $modx->resource->get('content');
                $content = $glossary->highlightTerms($content, $targetResId, $chunkName);
                $modx->resource->set('content', $content);
            };
        } else {
            if ($glossary->getOption('debug')) {
                $modx->log(xPDO::LOG_LEVEL_ERROR, 'The MODX System Setting "glossary.resid" does not point to a published and undeleted resource.');
            }
        }
        break;
}