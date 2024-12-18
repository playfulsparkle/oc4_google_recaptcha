<?php
namespace Opencart\Admin\Model\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package Opencart\Admin\Model\Extension\PsGoogleReCaptcha\Captcha
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Model
{
    public function replaceAdminViewCommonLoginBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => '<div class="text-end">',
            'replace' => <<<HTML
            <div class="mb-3">
                <label class="form-label" for="input-google-recaptcha">{% if key_type == 'v2_checkbox' %}{{ entry_challange_captcha }}{% else %}{{ entry_score_based_captcha }}{% endif %}</label>
                <div class="mb-2">
                    {% if key_type == 'v2_checkbox' %}<div id="g-recaptcha-{{ widget_counter }}" data-sitekey="{{ site_key }}"></div>{% endif %}
                    <script{% if script_nonce %} nonce="{{ script_nonce }}"{% endif %} data-widget-id="{{ widget_counter }}">
                        var repositionCaptchaBadge{{ widget_counter }} = function () {
                            var grecaptchaBadge = document.querySelector('.grecaptcha-badge'),
                            grecaptchaContainer = grecaptchaBadge ? grecaptchaBadge.closest('div') : null,
                            errorCaptcha = document.querySelector('#error-captcha');
                            if (grecaptchaContainer && errorCaptcha) { errorCaptcha.parentNode.insertBefore(grecaptchaContainer, errorCaptcha); }
                        };

                        var resetRecaptcha{{ widget_counter }} = function () {
                            if (window.grecaptcha && typeof grecaptcha.reset === 'function') {
                                if (typeof recaptcha_widget{{ widget_counter }} === 'number') {
                                    grecaptcha.reset(recaptcha_widget{{ widget_counter }});
                                } else {
                                    grecaptcha.reset();
                                }
                            }
                        };
                    {% if key_type == 'v3' or key_type == 'v2_invisible' %}
                        var recaptcha_form{{ widget_counter }} = document.currentScript ? document.currentScript.closest('form') : null;

                        var onFormSubmit{{ widget_counter }} = function (token) {
                                if (recaptcha_form{{ widget_counter }}) {
                                        var submitEvent = new Event('submit', {bubbles: true, cancelable: true});
                                        if (recaptcha_form{{ widget_counter }}.dispatchEvent(submitEvent)) { recaptcha_form{{ widget_counter }}.submit(); }
                                        {% if key_type == 'v2_invisible' %}resetRecaptcha{{ widget_counter }}();{% endif %}
                                }
                        }
                    {% elseif key_type == 'v2_checkbox' %}
                        var recaptcha_widget{{ widget_counter }},
                        recaptcha_form{{ widget_counter }} = document.currentScript ? document.currentScript.closest('form') : null;

                        var onloadCallback{{ widget_counter }} = function () {
                            recaptcha_widget{{ widget_counter }} = grecaptcha.render('g-recaptcha-{{ widget_counter }}', {
                                'sitekey': '{{ site_key }}',
                                'theme': '{{ badge_theme }}',
                                'size': '{{ badge_size }}'
                            });
                        };

                        if (recaptcha_form{{ widget_counter }}) {
                            recaptcha_form{{ widget_counter }}.addEventListener('submit', function () {
                                setTimeout(resetRecaptcha{{ widget_counter }}, 1000);
                            });
                        }
                    {% endif %}
                    </script>
                    <div id="error-captcha" class="invalid-feedback"></div>
                </div>
            </div>
            {% if hide_badge %}
            <div class="mb-3">
                <div class="mb-2">
                    <p>{{ text_recaptcha_branding }}</p>
                </div>
            </div>
            {% endif %}
            <script{% if google_captcha_nonce %} nonce="{{ google_captcha_nonce }}"{% endif %} src="{{ google_captcha_url }}" async defer></script>
            <div class="text-end">
HTML
        ];

        $button_tpl = <<<HTML
 {% if badge_position == 'inline' %} data-theme="{{ badge_theme }}"{% endif %} data-badge="{{ badge_position }}"
 {% if key_type == 'v2_checkbox' or key_type == 'v2_invisible' %} data-size="{{ badge_size }}"{% endif %}
 {% if key_type == 'v3' or key_type == 'v2_invisible' %}data-sitekey="{{ site_key }}" data-callback="onFormSubmit{{ widget_counter }}" data-action="submit{% endif %}"
HTML;

        $views[] = [
            'search' => '<button type="submit" class="btn btn-primary"><i class="fa-solid fa-key"></i> {{ button_login }}</button>',
            'replace' => '<button type="submit" class="btn btn-primary g-recaptcha"' . $button_tpl . '><i class="fa-solid fa-key"></i> {{ button_login }}</button>'
        ];

        return $views;
    }

    public function replaceAdminViewSettingSettingBefore(array $args): array
    {
        $views = [];

        $views[] = [
            'search' => "{% for captcha_page in captcha_pages %}",
            'replace' => <<<HTML
<div class="form-check">
    <input type="checkbox" name="config_captcha_page[]" value="admin_login" id="input-captcha-admin-login" class="form-check-input"{% if "admin_login" in config_captcha_page %} checked{% endif %}/> <label for="input-captcha-admin-login" class="form-check-label">{{ text_admin_login }}</label>
</div>
<div class="form-check">
    <input type="checkbox" name="config_captcha_page[]" value="catalog_login" id="input-captcha-catalog-login" class="form-check-input"{% if "catalog_login" in config_captcha_page %} checked{% endif %}/> <label for="input-captcha-catalog-login" class="form-check-label">{{ text_catalog_login }}</label>
</div>
<div class="form-check">
    <input type="checkbox" name="config_captcha_page[]" value="forgotten_password" id="input-captcha-forgotten-password" class="form-check-input"{% if "forgotten_password" in config_captcha_page %} checked{% endif %}/> <label for="input-captcha-forgotten-password" class="form-check-label">{{ text_forgotten_password }}</label>
</div>
{% for captcha_page in captcha_pages %}
HTML
        ];

        return $views;
    }
}
