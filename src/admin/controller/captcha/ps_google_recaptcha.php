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

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }

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
        $data['captcha_ps_google_recaptcha_error_log_status'] = $this->config->get('captcha_ps_google_recaptcha_error_log_status');
        $data['captcha_ps_google_recaptcha_log_filename'] = $this->config->get('captcha_ps_google_recaptcha_log_filename');
        $data['captcha_ps_google_recaptcha_key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $data['captcha_ps_google_recaptcha_badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $data['captcha_ps_google_recaptcha_badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $data['captcha_ps_google_recaptcha_badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $data['captcha_ps_google_recaptcha_hide_badge'] = $this->config->get('captcha_ps_google_recaptcha_hide_badge');
        $data['captcha_ps_google_recaptcha_site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');
        $data['captcha_ps_google_recaptcha_secret_key'] = $this->config->get('captcha_ps_google_recaptcha_secret_key');
        $data['captcha_ps_google_recaptcha_send_client_ip'] = $this->config->get('captcha_ps_google_recaptcha_send_client_ip');
        $data['captcha_ps_google_recaptcha_script_nonce'] = $this->config->get('captcha_ps_google_recaptcha_script_nonce');
        $data['captcha_ps_google_recaptcha_google_captcha_nonce'] = $this->config->get('captcha_ps_google_recaptcha_google_captcha_nonce');
        $data['captcha_ps_google_recaptcha_css_nonce'] = $this->config->get('captcha_ps_google_recaptcha_css_nonce');
        $data['captcha_ps_google_recaptcha_v3_score_threshold'] = (array) $this->config->get('captcha_ps_google_recaptcha_v3_score_threshold');

        $data['recaptcha_key_types'] = [
            'v2_checkbox' => $this->language->get('text_key_type_v2_checkbox') . ' ' . $this->language->get('text_default'),
            'v2_invisible' => $this->language->get('text_key_type_v2_invisible'),
            'v3' => $this->language->get('text_key_type_v3'),
        ];

        $data['badge_themes'] = [
            'light' => $this->language->get('text_badge_light') . ' ' . $this->language->get('text_default'),
            'dark' => $this->language->get('text_badge_dark'),
        ];

        $data['badge_positions'] = [
            'bottomright' => $this->language->get('text_badge_bottom_right') . ' ' . $this->language->get('text_default'),
            'bottomleft' => $this->language->get('text_badge_bottom_left'),
            'inline' => $this->language->get('text_badge_inline'),
        ];

        $data['badge_sizes'] = [
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_invisible', 'value' => 'normal', 'name' => $this->language->get('text_badge_normal'),],
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_invisible', 'value' => 'compact', 'name' => $this->language->get('text_badge_compact'),],
            ['disabled' => $this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_checkbox', 'value' => 'invisible', 'name' => $this->language->get('text_badge_invisible'),],
        ];

        $data['captcha_pages'] = [];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_admin_login'),
            'value' => 'admin_login'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_catalog_login'),
            'value' => 'catalog_login'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_register'),
            'value' => 'register'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_forgotten_password'),
            'value' => 'forgotten_password'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_guest'),
            'value' => 'guest'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_review'),
            'value' => 'review'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_comment'),
            'value' => 'comment'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_return'),
            'value' => 'returns'
        ];

        $data['captcha_pages'][] = [
            'text' => $this->language->get('text_contact'),
            'value' => 'contact'
        ];

        $data['error_log_output'] = '';
        $data['error_log_download'] = $this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . 'download', 'user_token=' . $this->session->data['user_token']);
        $data['error_log_clear'] = $this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . 'clear', 'user_token=' . $this->session->data['user_token']);

        if ($data['captcha_ps_google_recaptcha_error_log_status']) {
            $error_log_filename = DIR_LOGS . $data['captcha_ps_google_recaptcha_log_filename'];

            if (is_readable($error_log_filename)) {
                $error_log_handle = fopen($error_log_filename, 'r+');

                $data['error_log_output'] = fread($error_log_handle, 3145728);

                fclose($error_log_handle);
            }
        }

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

            if ((bool) $this->request->post['captcha_ps_google_recaptcha_error_log_status'] && !$this->request->post['captcha_ps_google_recaptcha_log_filename']) {
                $json['error']['input-log-filename'] = $this->language->get('error_log_filename');
            }

            if (isset($this->request->post['captcha_ps_google_recaptcha_v3_score_threshold'])) {
                foreach ($this->request->post['captcha_ps_google_recaptcha_v3_score_threshold'] as $captcha_page => $value) {
                    if ($value < 0 || $value > 1) {
                        $json['error']['input-v3-score-threshold-' . $captcha_page] = $this->language->get('error_v3_score_threshold_value');
                    }
                }
            }
        }

        if (!$json) {
            $this->load->model('setting/setting');

            if ($this->request->post['captcha_ps_google_recaptcha_key_type'] === 'v3') {
                $this->request->post['captcha_ps_google_recaptcha_badge_size'] = '';
            } else if ($this->request->post['captcha_ps_google_recaptcha_key_type'] === 'v2_checkbox') {
                $this->request->post['captcha_ps_google_recaptcha_badge_position'] = 'bottomright';
            }

            if (
                $this->request->post['captcha_ps_google_recaptcha_key_type'] !== 'v3' &&
                $this->request->post['captcha_ps_google_recaptcha_key_type'] !== 'v2_invisible'
            ) {
                $this->request->post['captcha_ps_google_recaptcha_hide_badge'] = 0;
            }

            $this->model_setting_setting->editSetting('captcha_ps_google_recaptcha', $this->request->post);

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function install(): void
    {
        if ($this->user->hasPermission('modify', 'extension/captcha')) {
            $this->load->model('setting/setting');

            $data = [
                'captcha_ps_google_recaptcha_key_type' => 'v2_checkbox',
                'captcha_ps_google_recaptcha_script_nonce' => $this->generateGuid(),
                'captcha_ps_google_recaptcha_google_captcha_nonce' => $this->generateGuid(),
                'captcha_ps_google_recaptcha_css_nonce' => $this->generateGuid(),
                'captcha_ps_google_recaptcha_badge_theme' => 'light',
                'captcha_ps_google_recaptcha_badge_position' => 'bottomright',
                'captcha_ps_google_recaptcha_log_filename' => 'ps_google_recaptcha.log',
            ];

            $this->model_setting_setting->editSetting('captcha_ps_google_recaptcha', $data);

            $this->load->model('setting/event');

            $this->_registerEvents();
        }
    }

    public function uninstall(): void
    {
        if ($this->user->hasPermission('modify', 'extension/captcha')) {
            $this->load->model('setting/event');

            $this->_unregisterEvents();
        }
    }

    public function download(): void
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $error_log_filename = DIR_LOGS . $this->config->get('captcha_ps_google_recaptcha_log_filename');

        if (!is_file($error_log_filename)) {
            $this->session->data['error'] = sprintf($this->language->get('error_error_log_file'), $this->config->get('captcha_ps_google_recaptcha_log_filename'));

            $this->response->redirect($this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', 'user_token=' . $this->session->data['user_token']));
        }

        if (!filesize($error_log_filename)) {
            $this->session->data['error'] = sprintf($this->language->get('error_error_log_empty'), $this->config->get('captcha_ps_google_recaptcha_log_filename'));

            $this->response->redirect($this->url->link('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', 'user_token=' . $this->session->data['user_token']));
        }

        $this->response->addheader('Pragma: public');
        $this->response->addheader('Expires: 0');
        $this->response->addheader('Content-Description: File Transfer');
        $this->response->addheader('Content-Type: application/octet-stream');
        $this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('captcha_ps_google_recaptcha_log_filename') . '"');
        $this->response->addheader('Content-Transfer-Encoding: binary');

        $this->response->setOutput(file_get_contents($error_log_filename, FILE_USE_INCLUDE_PATH, null));
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $json = [];

        if (!$this->user->hasPermission('modify', 'tool/log')) {
            $json['error'] = $this->language->get('error_permission');
        }

        $error_log_filename = DIR_LOGS . $this->config->get('captcha_ps_google_recaptcha_log_filename');

        if (!is_file($error_log_filename)) {
            $json['error'] = sprintf($this->language->get('error_error_log_file'), $this->config->get('captcha_ps_google_recaptcha_log_filename'));
        }

        if (!$json) {
            $handle = fopen($error_log_filename, 'w+');

            fclose($handle);

            $json['success'] = $this->language->get('text_log_clear_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function generateGuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, // Version 4
            mt_rand(0, 0x3fff) | 0x8000, // Variant 10
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
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
            ['trigger' => 'admin/view/setting/setting/before', 'description' => '', 'actionName' => 'eventAdminViewSettingSettingBefore'],

            ['trigger' => 'catalog/view/common/header/before', 'description' => '', 'actionName' => 'eventCatalogViewCommonHeaderBefore'],

            ['trigger' => 'admin/view/common/login/before', 'description' => '', 'actionName' => 'eventAdminViewCommonLoginBefore'],
            ['trigger' => 'admin/controller/common/login' . $separator . 'login/after', 'description' => '', 'actionName' => 'eventAdminControllerCommonLoginLoginAfter'],

            ['trigger' => 'catalog/view/account/login/before', 'description' => '', 'actionName' => 'eventCatalogViewAccountLoginBefore'],
            ['trigger' => 'catalog/controller/account/login' . $separator . 'login/after', 'description' => '', 'actionName' => 'eventCatalogControllerAccountLoginLoginAfter'],

            ['trigger' => 'catalog/view/account/forgotten/before', 'description' => '', 'actionName' => 'eventCatalogViewAccountForgottenBefore'],
            ['trigger' => 'catalog/controller/account/forgotten' . $separator . 'confirm/after', 'description' => '', 'actionName' => 'eventCatalogControllerAccountForgottenConfirmAfter'],

            // v3 and 2_invisible
            ['trigger' => 'catalog/view/account/register/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],
            ['trigger' => 'catalog/view/account/returns_form/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],
            ['trigger' => 'catalog/view/checkout/register/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],
            ['trigger' => 'catalog/view/information/contact/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],
            ['trigger' => 'catalog/view/product/review/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],
            ['trigger' => 'catalog/view/cms/comment/before', 'description' => '', 'actionName' => 'eventGoogleRecaptchaV3AndV2InivisibleButton'],

            ['trigger' => 'catalog/view/checkout/register/before', 'description' => '', 'actionName' => 'eventCatalogViewCheckoutRegisterBefore'],
            ['trigger' => 'catalog/view/product/review/before', 'description' => '', 'actionName' => 'eventCatalogViewProductReviewBefore'],
            ['trigger' => 'catalog/view/cms/comment/before', 'description' => '', 'actionName' => 'eventCatalogViewCmsCommentBefore'],
        ];

        $result = 0;

        if (version_compare(VERSION, '4.0.1.0', '>=')) {
            foreach ($events as $event) {
                $result += $this->model_setting_event->addEvent([
                    'code' => 'captcha_ps_google_recaptcha',
                    'description' => $event['description'],
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
                    $event['description'],
                    $event['trigger'],
                    'extension/ps_google_recaptcha/captcha/ps_google_recaptcha' . $separator . $event['actionName']
                );
            }
        }

        return $result > 0;
    }

    #region Admin login
    public function eventAdminViewCommonLoginBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        if (!isset($this->session->data['ps_google_recaptcha_counter'])) {
            $this->session->data['ps_google_recaptcha_counter'] = 0;
        } else {
            $this->session->data['ps_google_recaptcha_counter']++;
        }

        $args['widget_counter'] = $this->session->data['ps_google_recaptcha_counter'];

        $args['key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $args['badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $args['badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $args['badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $args['site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');
        $args['script_nonce'] = $this->config->get('captcha_ps_google_recaptcha_script_nonce');
        $args['google_captcha_nonce'] = $this->config->get('captcha_ps_google_recaptcha_google_captcha_nonce');
        $args['hide_badge'] = $this->config->get('captcha_ps_google_recaptcha_hide_badge');

        $query = [];

        if ($this->config->get('captcha_ps_google_recaptcha_key_type') === 'v3') {
            $query['render'] = $this->config->get('captcha_ps_google_recaptcha_site_key');

            if ($this->config->get('captcha_ps_google_recaptcha_badge_position') === 'inline') {
                $query['onload'] = 'repositionCaptchaBadge' . $this->session->data['ps_google_recaptcha_counter'];
            } else {
                $query['badge'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
            }
        } else if ($this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_checkbox') {
            $query['render'] = 'explicit';
            $query['onload'] = 'onloadCallback' . $this->session->data['ps_google_recaptcha_counter'];
            $query['badge'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        } else if ($this->config->get('captcha_ps_google_recaptcha_key_type') === 'v2_invisible') {
            if ($this->config->get('captcha_ps_google_recaptcha_badge_position') === 'inline') {
                $query['onload'] = 'repositionCaptchaBadge' . $this->session->data['ps_google_recaptcha_counter'];
            } else {
                $query['badge'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
            }
        }

        $query['hl'] = $this->language->get('code');

        $args['google_captcha_url'] = 'https://www.google.com/recaptcha/api.js?' . http_build_query($query);

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceAdminViewCommonLoginBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventAdminControllerCommonLoginLoginAfter(string &$route, array &$args, string &$output = null)
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $json = json_decode($this->response->getOutput(), true);

		$log_status = (bool) $this->config->get('captcha_ps_google_recaptcha_error_log_status') && !empty($this->config->get('captcha_ps_google_recaptcha_log_filename'));

        if ($log_status) {
            $log = new \Opencart\System\Library\Log($this->config->get('captcha_ps_google_recaptcha_log_filename'));
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        if (!isset($this->request->post['g-recaptcha-response'])) {
            if ($log_status) {
                $log->write('reCAPTCHA Error: Missing g-recaptcha-response. IP: ' . $this->request->server['REMOTE_ADDR'] .
                    ', URL: ' . $this->request->server['REQUEST_URI'] .
                    ', User-Agent: ' . $this->request->server['HTTP_USER_AGENT']);
            }

            $json['error'] = $this->language->get('error_missing_input_response');

            return $this->response->setOutput(json_encode($json));
        }

        $post_data = [
            'secret' => $this->config->get('captcha_ps_google_recaptcha_secret_key'),
            'response' => $this->request->post['g-recaptcha-response'],
        ];

        if ($this->config->get('captcha_ps_google_recaptcha_send_client_ip')) {
            $post_data['remoteip'] = $this->request->server['REMOTE_ADDR'];
        }

        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        } else if (ini_get('allow_url_fopen')) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($post_data)
                ]
            ]);
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        }

        $captcha_response = array_merge(
            ['success' => false, 'score' => 0.0, 'error-codes' => []],
            (array) json_decode((string) $response, true)
        );

        if (JSON_ERROR_NONE !== $json_last_error = json_last_error()) {
            if ($log_status) {
                $log->write('JSON Error: ' . json_last_error_msg() . ' (Code: ' . $json_last_error . ')');
            }

            $json['error'] = $this->language->get('error_bad_request');

            return $this->response->setOutput(json_encode($json));
        }

        if ($captcha_response['success']) {
            return;
        }

        if ($this->config->get('captcha_ps_google_recaptcha_key_type') === 'v3') {
            $route_to_page = [
                'product/review.write' => 'review',
                'information/contact.send' => 'contact',
                'account/returns.save' => 'returns',
                'checkout/register.save' => 'register',
                'account/register.register' => 'register',
            ];
            $recaptcha_page = isset($route_to_page[$this->request->get['route']]) ? $route_to_page[$this->request->get['route']] : '';

            $recaptcha_pages = (array) $this->config->get('captcha_ps_google_recaptcha_v3_score_threshold');

            if (!isset($recaptcha_pages[$recaptcha_page])) {
                $recaptcha_pages[$recaptcha_page] = 0.5; // default value
            }

            if ($recaptcha_page && $captcha_response['score'] < $recaptcha_pages[$recaptcha_page]) {
                if ($log_status) {
                    $log->write('V3 Score threshold error on page ' . $recaptcha_page .
                        '. Score: ' . $captcha_response['score'] .
                        ', Threshold: ' . $recaptcha_pages[$recaptcha_page] .
                        ', IP: ' . $this->request->server['REMOTE_ADDR']);
                }

                $json['error'] = $this->language->get('error_invalid_input_response');

                return $this->response->setOutput(json_encode($json));
            }
        }

        if ($captcha_response['error-codes']) {
            $errors = [];

            foreach ($captcha_response['error-codes'] as $error_code) {
                $error_message = $this->language->get('error_' . str_replace('-', '_', $error_code));

                $errors[] = $error_message;

                if ($log_status) {
                    $log->write('reCAPTCHA Error: ' . $error_code . ' - ' . $error_message . ', IP: ' . $this->request->server['REMOTE_ADDR']);
                }
            }

            $json['error'] = implode(', ', $errors);

            return $this->response->setOutput(json_encode($json));
        }

        if ($log_status) {
            $log->write('reCAPTCHA Error: ' . $this->language->get('error_captcha') . ', IP: ' . $this->request->server['REMOTE_ADDR']);
        }

        $json['error'] = $this->language->get('error_bad_request');

        $this->response->setOutput(json_encode($json));
    }
    #endregion

    public function eventAdminViewSettingSettingBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $args['text_admin_login'] = $this->language->get('text_admin_login');
        $args['text_catalog_login'] = $this->language->get('text_catalog_login');
        $args['text_forgotten_password'] = $this->language->get('text_forgotten_password');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceAdminViewSettingSettingBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    /**
     * Retrieves the contents of a template file based on the provided route.
     *
     * This method checks if an event template buffer is provided. If so, it returns that buffer.
     * If not, it constructs the template file path based on the current theme settings and checks
     * for the existence of the template file. If the file exists, it reads and returns its contents.
     * It supports loading templates from both the specified theme directory and the default template directory.
     *
     * @param string $route The route for which the template is being retrieved.
     *                      This should match the naming convention for the template files.
     * @param string $event_template_buffer The template buffer that may be passed from an event.
     *                                       If provided, this buffer will be returned directly,
     *                                       bypassing file retrieval.
     *
     * @return mixed Returns the contents of the template file as a string if it exists,
     *               or false if the template file cannot be found or read.
     */
    protected function getTemplateBuffer(string $route, string $event_template_buffer): mixed
    {
        if ($event_template_buffer) {
            return $event_template_buffer;
        }

        if (defined('DIR_CATALOG')) {
            $dir_template = DIR_TEMPLATE;
        } else {
            if ($this->config->get('config_theme') == 'default') {
                $theme = $this->config->get('theme_default_directory');
            } else {
                $theme = $this->config->get('config_theme');
            }

            $dir_template = DIR_TEMPLATE . $theme . '/template/';
        }

        $template_file = $dir_template . $route . '.twig';

        if (file_exists($template_file) && is_file($template_file)) {
            $template_file = $this->modCheck($template_file);

            return file_get_contents($template_file);
        }

        if (defined('DIR_CATALOG')) {
            return false;
        }

        $dir_template = DIR_TEMPLATE . 'default/template/';
        $template_file = $dir_template . $route . '.twig';

        if (file_exists($template_file) && is_file($template_file)) {
            $template_file = $this->modCheck($template_file);

            return file_get_contents($template_file);
        }

        // Support for OC4 catalog
        $dir_template = DIR_TEMPLATE;
        $template_file = $dir_template . $route . '.twig';

        if (file_exists($template_file) && is_file($template_file)) {
            $template_file = $this->modCheck($template_file);

            return file_get_contents($template_file);
        }

        return false;
    }

    /**
     * Checks and modifies the provided file path based on predefined directory constants.
     *
     * This method checks if the file path starts with specific directory constants (`DIR_MODIFICATION`,
     * `DIR_APPLICATION`, and `DIR_SYSTEM`). Depending on these conditions, it modifies the file path to
     * point to the appropriate directory under `DIR_MODIFICATION`.
     *
     * - If the file path starts with `DIR_MODIFICATION`, it checks if it should point to either the
     *   `admin` or `catalog` directory based on the definition of `DIR_CATALOG`.
     * - If `DIR_CATALOG` is defined, the method checks for the file in the `admin` directory.
     *   Otherwise, it checks in the `catalog` directory.
     * - If the file path starts with `DIR_SYSTEM`, it checks for the file in the `system` directory
     *   within `DIR_MODIFICATION`.
     *
     * The method ensures that the returned file path exists before modifying it.
     *
     * @param string $file The original file path to check and modify.
     * @return string|null The modified file path if found, or null if it does not exist.
     */
    protected function modCheck(string $file): mixed
    {
        if (defined('DIR_MODIFICATION')) {
            if ($this->startsWith($file, DIR_MODIFICATION)) {
                if (defined('DIR_CATALOG')) {
                    if (file_exists(DIR_MODIFICATION . 'admin/' . substr($file, strlen(DIR_APPLICATION)))) {
                        $file = DIR_MODIFICATION . 'admin/' . substr($file, strlen(DIR_APPLICATION));
                    }
                } else {
                    if (file_exists(DIR_MODIFICATION . 'catalog/' . substr($file, strlen(DIR_APPLICATION)))) {
                        $file = DIR_MODIFICATION . 'catalog/' . substr($file, strlen(DIR_APPLICATION));
                    }
                }
            } elseif ($this->startsWith($file, DIR_SYSTEM)) {
                if (file_exists(DIR_MODIFICATION . 'system/' . substr($file, strlen(DIR_SYSTEM)))) {
                    $file = DIR_MODIFICATION . 'system/' . substr($file, strlen(DIR_SYSTEM));
                }
            }
        }

        return $file;
    }

    /**
     * Checks if a given string starts with a specified substring.
     *
     * This method determines if the string $haystack begins with the substring $needle.
     *
     * @param string $haystack The string to be checked.
     * @param string $needle The substring to search for at the beginning of $haystack.
     *
     * @return bool Returns true if $haystack starts with $needle; otherwise, false.
     */
    protected function startsWith(string $haystack, string $needle): bool
    {
        if (strlen($haystack) < strlen($needle)) {
            return false;
        }

        return (substr($haystack, 0, strlen($needle)) == $needle);
    }

    /**
     * Replaces specific occurrences of a substring in a string with a new substring.
     *
     * This method searches for all occurrences of a specified substring ($search) in a given string ($string)
     * and replaces the occurrences at the positions specified in the $nthPositions array with a new substring ($replace).
     *
     * @param string $search The substring to search for in the string.
     * @param string $replace The substring to replace the found occurrences with.
     * @param string $string The input string in which replacements will be made.
     * @param array $nthPositions An array of positions (1-based index) indicating which occurrences
     *                            of the search substring to replace.
     *
     * @return mixed The modified string with the specified occurrences replaced, or the original string if no matches are found.
     */
    protected function replaceNth(string $search, string $replace, string $string, array $nthPositions): mixed
    {
        $pattern = '/' . preg_quote($search, '/') . '/';
        $matches = [];
        $count = preg_match_all($pattern, $string, $matches, PREG_OFFSET_CAPTURE);

        if ($count > 0) {
            foreach ($nthPositions as $nth) {
                if ($nth > 0 && $nth <= $count) {
                    $offset = $matches[0][$nth - 1][1];
                    $string = substr_replace($string, $replace, $offset, strlen($search));
                }
            }
        }

        return $string;
    }

    /**
     * Replaces placeholders in a template with corresponding values from the views array.
     *
     * This method retrieves the template content based on the given route and template name,
     * then replaces specified search strings with their corresponding replace strings.
     * If positions are specified, the method performs replacements only at those positions.
     *
     * @param string $route The route associated with the template.
     * @param string $template The name of the template to be processed.
     * @param array $views An array of associative arrays where each associative array contains:
     *                     - string 'search': The string to search for in the template.
     *                     - string 'replace': The string to replace the 'search' string with.
     *                     - array|null 'positions': (Optional) An array of positions
     *                     where replacements should occur. If not provided,
     *                     all occurrences will be replaced.
     *
     * @return mixed The modified template content after performing the replacements.
     */
    protected function replaceViews(string $route, string $template, array $views): mixed
    {
        $output = $this->getTemplateBuffer($route, $template);

        foreach ($views as $view) {
            if (isset($view['positions']) && $view['positions']) {
                $output = $this->replaceNth($view['search'], $view['replace'], $output, $view['positions']);
            } else {
                $output = str_replace($view['search'], $view['replace'], $output);
            }
        }

        return $output;
    }
}
