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
    public function replaceGoogleRecaptchaV3AndV2InivisibleButton(array $args): array
    {
        $views = [];

        $button_tpl = <<<HTML
 {% if key_type == 'v3' or key_type == 'v2_invisible' %}data-sitekey="{{ site_key }}" data-theme="{{ badge_theme }}" data-callback="onFormSubmit{{ widget_counter }}" data-badge="{{ badge_position }}"{% if key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %} data-action="submit{% endif %}"
HTML;

        $views[] = [
            'search' => '<button type="submit" class="btn btn-primary">{{ button_continue }}</button>',
            'replace' => '<button type="submit" class="btn btn-primary g-recaptcha"' . $button_tpl . '>{{ button_continue }}</button>'
        ];

        $views[] = [
            'search' => '<button type="submit" class="btn btn-primary">{{ button_submit }}</button>',
            'replace' => '<button type="submit" class="btn btn-primary g-recaptcha"' . $button_tpl . '>{{ button_submit }}</button>'
        ];

        $views[] = [
            'search' => '<button type="submit" id="button-register" class="btn btn-primary mt-2">{{ button_continue }}</button>',
            'replace' => '<button type="submit" id="button-register" class="btn btn-primary g-recaptcha mt-2"' . $button_tpl . '>{{ button_continue }}</button>'
        ];

        $views[] = [
            'search' => '<button type="submit" id="button-comment" class="btn btn-primary">{{ button_continue }}</button>',
            'replace' => '<button type="submit" id="button-comment" class="btn btn-primary g-recaptcha"' . $button_tpl . '>{{ button_continue }}</button>'
        ];

        $views[] = [
            'search' => '<button type="submit" id="button-review" class="btn btn-primary">{{ button_continue }}</button>',
            'replace' => '<button type="submit" id="button-review" class="btn btn-primary g-recaptcha"' . $button_tpl . '>{{ button_continue }}</button>'
        ];

        return $views;
    }

    public function replaceCatalogViewCheckoutRegisterBefore(array $args): array
    {
        $views = [];

        $views[] = [ // OpenCart 4 does not reset button state because of Google reCAPTCHA script!
            'search' => "$('#button-register').button('reset');",
            'replace' => "$('#button-register').button('reset');
                $('#button-register').prop('disabled', false);"
        ];

        return $views;
    }
}
