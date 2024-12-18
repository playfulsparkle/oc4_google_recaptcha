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
            'replace' => '<style{% if ps_css_nonce %} nonce="{{ ps_css_nonce }}"{% endif %}>
            {% if ps_hide_badge %}
            .grecaptcha-badge { visibility: hidden; }
            .row .grecaptcha-badge { visibility: visible; }
            {% endif %}
            .text-end > div:has(> iframe) {
                display: inline-block;
            }
            </style>
            </head>'
        ];

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
 {% if badge_position == 'inline' %} data-theme="{{ badge_theme }}"{% endif %} data-badge="{{ badge_position }}"
 {% if key_type == 'v2_checkbox' or key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %}
 {% if key_type == 'v3' or key_type == 'v2_invisible' %}data-sitekey="{{ site_key }}" data-callback="onFormSubmit{{ widget_counter }}" data-action="submit{% endif %}"
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

        $views[] = [
            'search' => '<button type="submit" id="button-comment" form="form-comment" class="btn btn-primary">{{ button_comment }}</button>',
            'replace' => '<button type="submit" id="button-comment" form="form-comment" class="btn btn-primary g-recaptcha"' . $button_tpl . '>{{ button_comment }}</button>'
        ];

        return $views;
    }

    public function replaceCatalogViewCmsCommentBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '<form id="form-comment" action="" data-oc-target="" data-oc-trigger="">',
            'replace' => ''
        ];

        $views[] = [
            'search' => '<div id="modal-comment" class="modal">',
            'replace' => '<div id="modal-comment" class="modal">
            <form id="form-comment" action="" data-oc-target="" data-oc-trigger="">'
        ];

        $views[] = [
            'search' => '</form>',
            'replace' => ''
        ];

        $views[] = [
            'search' => '</div>
<script type="text/javascript">',
            'replace' => '</form>
            </div>
<script type="text/javascript">'
        ];

        $views[] = [ // OpenCart 4 does not reset button state because of Google reCAPTCHA script!
            'search' => "$('#button-comment').button('reset');",
            'replace' => "$('#button-comment').button('reset').prop('disabled', false);"
        ];

        return $views;
    }

    public function replaceCatalogViewCheckoutRegisterBefore(array $args): array
    {
        $views = [];

        $views[] = [ // OpenCart 4 does not reset button state because of Google reCAPTCHA script!
            'search' => "$('#button-register').button('reset');",
            'replace' => "$('#button-register').button('reset').prop('disabled', false);"
        ];

        return $views;
    }

    public function replaceCatalogViewProductReviewBefore(array $args): array
    {
        $views = [];

        $views[] = [ // OpenCart 4 does not reset button state because of Google reCAPTCHA script!
            'search' => "$('#button-review').button('reset');",
            'replace' => "$('#button-review').button('reset').prop('disabled', false);"
        ];

        return $views;
    }

    public function replaceCatalogViewAccountLoginBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '<div class="text-end">',
            'replace' => '
            {{ captcha }}
            <div class="text-end">',
            'positions' => [2]
        ];

        return $views;
    }
}
