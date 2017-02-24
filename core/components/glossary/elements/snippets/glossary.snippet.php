<?php
/**
 * Glossary Snippet
 *
 * @package glossary
 * @subpackage snippet
 *
 * @var modX $modx
 * @var array $scriptProperties
 */

$corePath = $modx->getOption('glossary.core_path', null, $modx->getOption('core_path') . 'components/glossary/');
$glossary = $modx->getService('glossary', 'GlossaryBase', $corePath . 'model/glossary/', array(
    'core_path' => $corePath
));

// Get options
$outerTpl = $modx->getOption('outerTpl', $scriptProperties, 'Glossary.listOuterTpl', true);
$groupTpl = $modx->getOption('groupTpl', $scriptProperties, 'Glossary.listGroupTpl', true);
$termTpl = $modx->getOption('termTpl', $scriptProperties, 'Glossary.listItemTpl', true);
$navOuterTpl = $modx->getOption('navOuterTpl', $scriptProperties, 'Glossary.navOuterTpl', true);
$navItemTpl = $modx->getOption('navItemTpl', $scriptProperties, 'Glossary.navItemTpl', true);
$showNav = (bool)$modx->getOption('showNav', $scriptProperties, true, true);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties);
$navLetters = $modx->getOption('navLetters', $scriptProperties);

// Outputness
$output = '';
$outputNav = '';
$outputItems = '';

// Grab all terms grouped by first letter
$letters = $glossary->getGroupedTerms();

// add letters to array
if (!empty($navLetters)) {
    $navLetters = explode(',', $navLetters);
    if (is_array($navLetters)) {
        $navLetters = array_fill_keys($navLetters, array());
        $navLetters = array_change_key_case($navLetters, CASE_UPPER);
        $letters = array_merge($navLetters, $letters); 
    }
    ksort($letters);
}

// Show navigation list (if on)
if ($showNav) {
    // Prepare letter chunks
    $tplLetters = '';
    foreach ($letters as $letter => $terms) {
        $tplLetters .= $modx->getChunk($navItemTpl, array(
            'letter' => $letter,
            'disabled' => count($terms) > 0 ? 0 : 1,
        ));
    };
    // Wrap letters in outer tpl
    $output .= $outputNav = $modx->getChunk($navOuterTpl, array('letters' => $tplLetters));
};

// Output all terms (grouped)
$groupsHTML = '';
foreach ($letters as $letter => $terms) {
    if (count($terms)) {
        // Prepare Terms HTML
        $termsHTML = '';
        foreach ($terms as $term) {
            $params = array_merge($term, array(
                'anchor' => strtolower(str_replace(' ', '-', $term['term'])),
                'letter' => $letter
            ));
            $termsHTML .= $modx->getChunk($termTpl, $params);
            $outputItems .= $modx->getChunk($termTpl, $params);
        };
        // Prepare letter wrapper HTML
        $groupsHTML .= $modx->getChunk($groupTpl, array(
            'items' => $termsHTML,
            'letter' => $letter
        ));
    };
};

// Add groups to outer wrapper
$output .= $modx->getChunk($outerTpl, array('groups' => $groupsHTML));


if (!empty($toPlaceholder)) {
    $modx->setPlaceholders(array(
       '.nav' => $outputNav,
       '.items' => $outputItems,
       '' => $output,
    ), $toPlaceholder);
}else {
    return $output;
}
