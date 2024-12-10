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
            'search' => '<button type="submit" class="btn btn-primary',
            'replace' => '
            <script src="https://www.google.com/recaptcha/api.js?render={{ site_key }}&badge=bottomleft"></script>
            <script>
            //
            function onFormRegisterSubmit(token) {
                var form = document.querySelector(\'#form-register\');
                var event = new Event(\'submit\', { bubbles: true, cancelable: true });
                if (form.dispatchEvent(event)) { form.submit(); }
            }
            </script>
            <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="{{ site_key }}" data-callback="onFormRegisterSubmit" data-action="submit'
        ];

        return $views;
    }
}
