<?php
namespace Opencart\Admin\Controller\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package Opencart\Admin\Controller\Extension\PsGoogleReCaptcha\Captch
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Controller
{
    /**
     * @var string The support email address.
     */
    const EXTENSION_EMAIL = 'support@playfulsparkle.com';

    /**
     * @var string The documentation URL for the extension.
     */
    const EXTENSION_DOC = 'https://playfulsparkle.com/en-us/resources/downloads/';

    /**
     * @return void
     */
    public function index(): void
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=captcha')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', 'user_token=' . $this->session->data['user_token'])
        ];


        $separator = version_compare(VERSION, '4.0.2.0', '>=') ? '.' : '|';

        $data['save'] = $this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . 'save', 'user_token=' . $this->session->data['user_token']);
        $data['fix_event_handler'] = $this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . 'fixEventHandler', 'user_token=' . $this->session->data['user_token']);
        $data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=captcha');

        $data['captcha_ps_google_recaptcha_status'] = $this->config->get('captcha_ps_google_recaptcha_status');
        $data['captcha_ps_google_recaptcha_key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $data['captcha_ps_google_recaptcha_badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $data['captcha_ps_google_recaptcha_badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $data['captcha_ps_google_recaptcha_badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $data['captcha_ps_google_recaptcha_site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');
        $data['captcha_ps_google_recaptcha_secret_key'] = $this->config->get('captcha_ps_google_recaptcha_secret_key');

        $data['recaptcha_key_types'] = [
            'v3' => $this->language->get('text_key_type_v3'),
            'v2_checkbox' => $this->language->get('text_key_type_v2_checkbox'),
            'v2_invisible' => $this->language->get('text_key_type_v2_invisible'),
        ];

        $data['badge_themes'] = [
            'light' => $this->language->get('text_badge_light'),
            'dark' => $this->language->get('text_badge_dark'),
        ];

        $data['badge_positions'] = [
            'bottomright' => $this->language->get('text_badge_bottom_right'),
            'bottomleft' => $this->language->get('text_badge_bottom_left'),
            'inline' => $this->language->get('text_badge_inline'),
        ];

        $data['badge_sizes'] = [
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_invisible', 'value' => 'normal', 'name' => $this->language->get('text_badge_normal'),],
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_invisible', 'value' => 'compact', 'name' => $this->language->get('text_badge_compact'),],
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_checkbox', 'value' => 'invisible', 'name' => $this->language->get('text_badge_invisible'),],
        ];

        $data['text_contact'] = sprintf($this->language->get('text_contact'), self::EXTENSION_EMAIL, self::EXTENSION_EMAIL, self::EXTENSION_DOC);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', $data));
    }

    /**
     * @return void
     */
    public function save(): void
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/ps_google_recaptcha/captcha/ps_google_recaptcha')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (!$json) {
            if (!$this->request->post['captcha_ps_google_recaptcha_site_key']) {
                $json['error']['input-site-key'] = $this->language->get('error_site_key');
            }

            if (!$this->request->post['captcha_ps_google_recaptcha_secret_key']) {
                $json['error']['input-secret-key'] = $this->language->get('error_secret_key');
            }
        }

        if (!$json) {
            $this->load->model('setting/setting');

            if ($this->request->post['captcha_ps_google_recaptcha_key_type'] === 'v3') {
                $this->request->post['captcha_ps_google_recaptcha_badge_size'] = '';
            } else  if ($this->request->post['captcha_ps_google_recaptcha_key_type'] === 'v2_checkbox') {
                $this->request->post['captcha_ps_google_recaptcha_badge_position'] = 'bottomright';
            }

            $this->model_setting_setting->editSetting('captcha_ps_google_recaptcha', $this->request->post);

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function install(): void
    {
        if ($this->user->hasPermission('modify', 'extension/ps_google_recaptcha/captcha/ps_google_recaptcha')) {
            $this->load->model('setting/setting');

            $data = [
                'captcha_ps_google_recaptcha_key_type' => 'v3',
            ];

            $this->model_setting_setting->editSetting('captcha_ps_google_recaptcha', $data);

            $this->load->model('setting/event');

            $this->_registerEvents();
        }
    }

    public function uninstall(): void
    {
        if ($this->user->hasPermission('modify', 'extension/ps_google_recaptcha/captcha/ps_google_recaptcha')) {
            $this->load->model('setting/event');

            $this->_unregisterEvents();
        }
    }

    public function fixEventHandler(): void
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/ps_google_recaptcha/captcha/ps_google_recaptcha')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (!$json) {
            $this->load->model('setting/event');

            $this->_unregisterEvents();

            if ($this->_registerEvents() > 0) {
                $json['success'] = $this->language->get('text_success');
            } else {
                $json['error'] = $this->language->get('error_event');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function _unregisterEvents(): void
    {
        $this->model_setting_event->deleteEventByCode('captcha_ps_google_recaptcha');
    }

    private function _registerEvents(): int
    {
        $separator = version_compare(VERSION, '4.0.2.0', '>=') ? '.' : '|';

        $events = [
            ['trigger' => 'catalog/view/common/header/before', 'actionName' => 'eventCatalogViewCommonHeaderBefore'],
            ['trigger' => 'catalog/view/account/register/before', 'actionName' => 'eventCatalogViewAccountRegisterBefore'],
        ];

        $result = 0;

        if (version_compare(VERSION, '4.0.1.0', '>=')) {
            foreach ($events as $event) {
                $result += $this->model_setting_event->addEvent([
                    'code' => 'captcha_ps_google_recaptcha',
                    'description' => '',
                    'trigger' => $event['trigger'],
                    'action' => 'extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . $event['actionName'],
                    'status' => '1',
                    'sort_order' => '0'
                ]);
            }
        } else {
            foreach ($events as $event) {
                $result += $this->model_setting_event->addEvent(
                    'captcha_ps_google_recaptcha',
                    '',
                    $event['trigger'],
                    'extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . $event['actionName']
                );
            }
        }

        return $result > 0;
    }
}
