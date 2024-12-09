<?php
namespace Opencart\Catalog\Model\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package Opencart\Catalog\Model\Extension\PsGoogleReCaptcha\Captcha
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Model
{
    /**
     * @param array $args
     *
     * @return array
     */
    public function replaceCatalogViewCommonHeaderBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '</head>',
            'replace' => '
            <link rel="preconnect" href="https://www.google.com">
            <link rel="preconnect" href="https://www.gstatic.com" crossorigin>
            </head>'
        ];

        return $views;
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function replaceCatalogViewAccountRegisterBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '<body>',
            'replace' => '<body>'
        ];

        return $views;
    }
}
