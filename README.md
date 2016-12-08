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