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
            'search' => '<button type="submit" class="btn btn-primary"',
            'replace' => <<<HTML
                <script src="https://www.google.com/recaptcha/api.js?render={{ site_key }}&badge=bottomleft" async defer></script>
                <script>
                    var form = document.currentScript ? document.currentScript.closest('form') : null;

                    function onFormSubmit{{ widget_counter }}(token) {
                        if (form) {
                            var submitEvent = new Event('submit', { bubbles: true, cancelable: true });

                            if (form.dispatchEvent(submitEvent)) {
                                form.submit();
                            }
                        } else {
                            console.error("No form element found for the current script.");
                        }
                    }
                </script>
                <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="{{ site_key }}" data-callback="onFormSubmit{{ widget_counter }}" data-action="submit"
            HTML
        ];

        return $views;
    }
}
