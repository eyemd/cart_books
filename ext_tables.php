<?php

defined('TYPO3_MODE') or die();

$iconPath = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/';

$_LLL = 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'Shopping Cart - Cart Books'
);

/**
 * Register Frontend Plugins
 */
$pluginNames = [
    'Books',
];

foreach ($pluginNames as $pluginName) {
    $pluginSignature = strtolower(str_replace('_', '', $_EXTKEY)) . '_' . strtolower($pluginName);
    $pluginNameSC = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Extcode.' . $_EXTKEY,
        $pluginName,
        $_LLL . ':tx_cartbooks.plugin.' . $pluginNameSC . '.title'
    );
    $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';

    $flexFormPath = 'EXT:' . $_EXTKEY . '/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
    if (file_exists(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($flexFormPath))) {
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:' . $flexFormPath
        );
    }
}

$TCA['pages']['ctrl']['typeicon_classes']['contains-cartbooks'] = 'icon-apps-pagetree-cartbooks-folder';

$TCA['pages']['columns']['module']['config']['items'][] = [
    'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf:tcarecords-pages-contains.cart_books',
    'cartbooks',
    'EXT:cart_books/Resources/Public/Icons/pagetree_cartbooks_folder.svg',
];

$GLOBALS['TYPO3_CONF_VARS']['EXT'][$_EXTKEY]['templateLayouts'][] = ['LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:flexforms_template.templateLayout.table','table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT'][$_EXTKEY]['templateLayouts'][] = ['LLL:EXT:cart_books/Resources/Private/Language/locallang_be.xlf:flexforms_template.templateLayout.grid','grid'];