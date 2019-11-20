<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/ovenpars/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/ovenpars')) {
            $cache->deleteTree(
                $dev . 'assets/components/ovenpars/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/ovenpars/', $dev . 'assets/components/ovenpars');
        }
        if (!is_link($dev . 'core/components/ovenpars')) {
            $cache->deleteTree(
                $dev . 'core/components/ovenpars/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/ovenpars/', $dev . 'core/components/ovenpars');
        }
    }
}

return true;