<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LexikTranslationSonataBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Admin definition for the Translations class.
 */
class TranslationAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'lexik_translation_overview';
    protected $baseRoutePattern = 'translations';

    /**
     * {@inheritdoc}
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('list', 'list', [
            '_controller' => 'LexikTranslationBundle:Translation:overview',
        ]);

        $collection->add('grid', 'grid', [
            '_controller' => 'LexikTranslationBundle:Translation:grid',
        ]);

        $collection->add('new', 'new', [
            '_controller' => 'LexikTranslationBundle:Translation:new',
        ]);
    }
}
