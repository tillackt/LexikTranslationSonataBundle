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

    public function trans($message, array $arguments = array(), $domain = null, $locale = null)
    {
        $this->validateTranslation($message, $domain, $locale);

        return $this->getTranslator()->trans($message, $arguments, $domain, $locale);
    }

    public function transchoice($message, $count, array $arguments = array(), $domain = null, $locale = null)
    {
        $this->validateTranslation($message, $domain, $locale);

        return $this->getTranslator()->transChoice($message, $count, array_merge(array('%count%' => $count), $arguments), $domain, $locale);
    }

    protected function validateTranslation($message, $domain = null, $locale = null)
    {
        if (null === $locale) {
            $locale = $this->getTranslator()->getLocale();
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        if ($this->autoDiscover &&
            in_array($domain, $this->autoDomains) &&
            !$this->translationExists($message, $domain, $locale) &&
            !is_null($message)) {

            $transUnit = $this->storage->getTransUnitByKeyAndDomain($message, $domain);
            if (!$transUnit) {
                $transUnit = $this->transUnitManager->create($message, $domain);
            }

            $this->transUnitManager->addTranslation($transUnit, $locale, $message, null, true);
        }
    }


    protected function translationExists($id, $domain, $locale)
    {
        return $this->getTranslator()->getCatalogue($locale)->has((string) $id, $domain);
    }
}
