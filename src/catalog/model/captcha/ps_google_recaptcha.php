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
                <script src="https://www.google.com/recaptcha/api.js?render={{ site_key }}{% if badge_position != 'inline' %}&badge={{ badge_position }}{% endif %}" async defer></script>
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
                <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="{{ site_key }}" data-theme="{{ badge_theme }}" data-callback="onFormSubmit{{ widget_counter }}" data-badge="{{ badge_position }}"{% if key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %} data-action="submit"
            HTML
        ];

        return $views;
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function replaceCatalogViewAccountLoginBefore(array $args): array
    {
        $views = [];

        if ($args['key_type'] === 'v3' || $args['key_type'] == 'v2_invisible') {
            $views[] = [
                'search' => '<div class="text-end">',
                'replace' => <<<HTML
                <div class="mb-3 required">
                    <label for="input-google-recaptcha" class="col-form-label">{{ ps_entry_score_based_captcha }}</label>
                    <div id="error-captcha" class="invalid-feedback"></div>
                </div>
                <div class="text-end">
                HTML,
                'positions' => [2]
            ];

            $views[] = [
                'search' => '<button type="submit" class="btn btn-primary"',
                'replace' => <<<HTML
                <script src="https://www.google.com/recaptcha/api.js?render={{ site_key }}{% if badge_position != 'inline' %}&badge={{ badge_position }}{% endif %}" async defer></script>
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
                <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="{{ site_key }}" data-theme="{{ badge_theme }}" data-callback="onFormSubmit{{ widget_counter }}" data-badge="{{ badge_position }}"{% if key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %} data-action="submit"
                HTML
            ];
        } else if ($args['key_type'] == 'v2_checkbox') {
            $views[] = [
                'search' => '<div class="text-end">',
                'replace' => <<<HTML
                <div class="mb-3 required">
                    <label for="input-google-recaptcha" class="col-form-label">{{ ps_entry_challange_captcha }}</label>
                    <div id="g-recaptcha-{{ widget_counter }}" data-sitekey="{{ site_key }}"></div>
                    <script type="text/javascript">
                        var recaptcha_widget{{ widget_counter }};

                        var onloadCallback{{ widget_counter }} = function () {
                            recaptcha_widget{{ widget_counter }} = grecaptcha.render('g-recaptcha-{{ widget_counter }}', {
                                'sitekey': '{{ site_key }}',
                                'theme': '{{ badge_theme }}',
                                'size': '{{ badge_size }}'
                            });
                        };

                        var form = document.currentScript ? document.currentScript.closest('form') : null;

                        if (typeof form !== 'undefined') {
                            var resetRecaptcha{{ widget_counter }} = function () {
                                if (window.grecaptcha && typeof grecaptcha.reset === 'function') {
                                    grecaptcha.reset(recaptcha_widget{{ widget_counter }});
                                } else {
                                    console.warn('Google reCAPTCHA is not initialized.');
                                }
                            };

                            form.addEventListener('submit', function () {
                                setTimeout(resetRecaptcha{{ widget_counter }}, 1000);
                            });
                        }
                    </script>
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback{{ widget_counter }}&render=explicit&badge={{ badge_position }}" async defer></script>
                    <div id="error-captcha" class="invalid-feedback"></div>
                </div>
                <div class="text-end">
                HTML,
                'positions' => [2]
            ];
        }

        return $views;
    }
}
