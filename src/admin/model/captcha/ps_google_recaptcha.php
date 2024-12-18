<?php
namespace Opencart\Admin\Model\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package Opencart\Admin\Model\Extension\PsGoogleReCaptcha\Captcha
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Model
{
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
