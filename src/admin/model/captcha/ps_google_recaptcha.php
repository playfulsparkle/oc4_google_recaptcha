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
            'replace' => '{{ captcha }}
            <div class="text-end">'
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
