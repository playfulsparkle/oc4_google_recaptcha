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
 data-sitekey="{{ site_key }}" data-theme="{{ badge_theme }}" data-callback="onFormSubmit{{ widget_counter }}" data-badge="{{ badge_position }}"{% if key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %} data-action="submit"
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

    /**
     * @param array $args
     *
     * @return array
     */
    public function replaceGoogleRecaptchaV3AndV2InivisibleScript(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '<div id="error-captcha" class="invalid-feedback"></div>',
            'replace' => <<<HTML
<script src="https://www.google.com/recaptcha/api.js?render={{ site_key }}{% if badge_position == 'inline' %}&onload=repositionCaptchaBadge{{ widget_counter }}{% else %}&badge={{ badge_position }}{% endif %}" async defer></script>
<script data-widget-id="{{ widget_counter }}">
    var recaptcha_form{{ widget_counter }} = document.currentScript ? document.currentScript.closest('form') : null;
    function onFormSubmit{{ widget_counter }}(token) {
        if (recaptcha_form{{ widget_counter }}) {
            var submitEvent = new Event('submit', {bubbles: true, cancelable: true});
            if (recaptcha_form{{ widget_counter }}.dispatchEvent(submitEvent)) { recaptcha_form{{ widget_counter }}.submit(); }
        }
    }
    {% if badge_position == 'inline' %}var repositionCaptchaBadge{{ widget_counter }} = function () {
        var grecaptchaBadge = document.querySelector('.grecaptcha-badge'),
        grecaptchaContainer = grecaptchaBadge ? grecaptchaBadge.closest('div') : null,
        errorCaptcha = document.querySelector('#error-captcha');
        if (grecaptchaContainer && errorCaptcha) { errorCaptcha.parentNode.insertBefore(grecaptchaContainer, errorCaptcha); }
    };{% endif %}
</script>
<div id="error-captcha" class="invalid-feedback"></div>
HTML
        ];

        return $views;
    }
}
