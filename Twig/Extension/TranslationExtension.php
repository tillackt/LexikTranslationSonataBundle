<?php

namespace LexikTranslationSonataBundle\Twig\Extension;

use Lexik\Bundle\TranslationBundle\Manager\TransUnitManager;
use Lexik\Bundle\TranslationBundle\Storage\StorageInterface;
use Symfony\Bridge\Twig\Extension\TranslationExtension as BaseTranslationExtension;
use Symfony\Component\Translation\TranslatorInterface;

class TranslationExtension extends BaseTranslationExtension
{
    /** @var TransUnitManager */
    private $transUnitManager;

    /** @var StorageInterface */
    private $storage;

    /** @var boolean */
    private $autoDiscover;

    /** @var array */
    private $autoDomains;

    public function __construct(
        TranslatorInterface $translator,
        TransUnitManager $transUnitManager,
        StorageInterface $storage,
        $autoDiscover,
        $autoDomains,
        \Twig_NodeVisitorInterface $translationNodeVisitor = null)
    {
        parent::__construct($translator, $translationNodeVisitor);
        $this->transUnitManager = $transUnitManager;
        $this->storage = $storage;
        $this->autoDiscover = $autoDiscover;
        $this->autoDomains = $autoDomains;
    }

    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        if (null === $locale) {
            $locale = $this->getTranslator()->getLocale();
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        if ($this->autoDiscover &&
            in_array($domain, $this->autoDomains) &&
            !$this->translationExists($id, $domain, $locale)) {

            $transUnit = $this->storage->getTransUnitByKeyAndDomain($id, $domain);
            if (!$transUnit) {
                $transUnit = $this->transUnitManager->create($id, $domain);
            }

            $this->transUnitManager->addTranslation($transUnit, $locale, $id, null, true);
        }

        $translation = $this->getTranslator()->trans($id, $parameters, $domain, $locale);

        return $translation;
    }


    protected function translationExists($id, $domain, $locale)
    {
        return $this->getTranslator()->getCatalogue($locale)->has((string) $id, $domain);
    }
}
