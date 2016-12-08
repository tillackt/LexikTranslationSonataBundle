Sonata extension for https://github.com/lexik/LexikTranslationBundle

Install with composer:

    # Latest stable
    composer require pix-art/lexik-translation-sonata-bundle 1.0
    
    # For latest unstable version
    composer require pix-art/lexik-translation-sonata-bundle dev-master

Register the bundle with your kernel:

    // in AppKernel::registerBundles()
    $bundles = array(
        // ...
        new Lexik\Bundle\TranslationBundle\LexikTranslationBundle(),
        new LexikTranslationSonataBundle\LexikTranslationSonataBundle(),
        // ...
    );

Then install the required assets:

    php app/console assets:install
    
Routing:
    
    lexik_translation_edition:
        resource: "@LexikTranslationSonataBundle/Resources/config/routing.yml"
        prefix:   /admin
        
Config:

    lexik_translation:
        fallback_locale: [nl]
        managed_locales: [nl,fr,en]
        base_layout: "LexikTranslationSonataBundle::translations_layout.html.twig"
        
Auto Discovery:
    
This will transform you |trans function, to auto discover this translation if it's not found.
Make sure the domain is declared if you want it auto discovered

    lexik_translation_sonata:
        auto_discover: true
        auto_discover_domains: [messages]