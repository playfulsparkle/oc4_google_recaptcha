<?php
namespace Opencart\Catalog\Controller\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Controller
{
    public function __construct(\Opencart\System\Engine\Registry $registry)
    {
        $this->registry = $registry;

        if (!isset($this->session->data['ps_google_recaptcha_counter'])) {
            $this->session->data['ps_google_recaptcha_counter'] = 0;
        }
    }

    /**
     * @return string
     */
    public function index(): string
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return '';
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $this->session->data['ps_google_recaptcha_counter']++;

        $data = [];

        $data['widget_counter'] = $this->session->data['ps_google_recaptcha_counter'];

        $data['key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $data['badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $data['badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $data['badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $data['site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');
        $data['script_nonce'] = $this->config->get('captcha_ps_google_recaptcha_script_nonce');
        $data['google_captcha_nonce'] = $this->config->get('captcha_ps_google_recaptcha_google_captcha_nonce');
        $data['hide_badge'] = $this->config->get('captcha_ps_google_recaptcha_hide_badge');

        $data['checkout_page'] = substr($this->request->get['route'], 0, 9) === 'checkout/';

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

        $data['google_captcha_url'] = 'https://www.google.com/recaptcha/api.js?' . http_build_query($query);

        return $this->load->view('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', $data);
    }

    /**
     * @return string
     */
    public function validate(): string
    {
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

            return $this->language->get('error_missing_input_response');
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

            return $this->language->get('error_bad_request');
        }

        if ($captcha_response['success']) {
            return '';
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

                return $this->language->get('error_invalid_input_response');
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

            return implode(', ', $errors);
        }

        if ($log_status) {
            $log->write('reCAPTCHA Error: ' . $this->language->get('error_captcha') . ', IP: ' . $this->request->server['REMOTE_ADDR']);
        }

        return $this->language->get('error_bad_request');
    }

    public function eventCatalogViewAccountLoginBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        // Captcha
        $this->load->model('setting/extension');

        $extension_info = $this->model_setting_extension->getExtensionByCode('captcha', $this->config->get('config_captcha'));

        if ($extension_info && $this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('catalog_login', (array) $this->config->get('config_captcha_page'))) {
            $args['captcha'] = $this->load->controller('extension/' . $extension_info['extension'] . '/captcha/' . $extension_info['code']);
        } else {
            $args['captcha'] = '';
        }

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewAccountLoginBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogControllerAccountLoginLoginAfter(string &$route, array &$args, string &$output = null)
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $json = json_decode($this->response->getOutput(), true);

		$this->load->model('setting/extension');

		$extension_info = $this->model_setting_extension->getExtensionByCode('captcha', $this->config->get('config_captcha'));

		if ($extension_info && $this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && in_array('catalog_login', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/' . $extension_info['extension'] . '/captcha/' . $extension_info['code'] . '.validate');

			if ($captcha) {
				$json['error']['captcha'] = $captcha;
			}
		}

        $this->response->setOutput(json_encode($json));
    }

    public function eventCatalogViewCommonHeaderBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $args['ps_hide_badge'] = $this->config->get('captcha_ps_google_recaptcha_hide_badge');
        $args['ps_css_nonce'] = $this->config->get('captcha_ps_google_recaptcha_css_nonce');

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewCommonHeaderBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventGoogleRecaptchaV3AndV2InivisibleButton(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $args['widget_counter'] = $this->session->data['ps_google_recaptcha_counter'];

        $args['key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $args['badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $args['badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $args['badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $args['site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceGoogleRecaptchaV3AndV2InivisibleButton($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogViewCheckoutRegisterBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewCheckoutRegisterBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogViewProductReviewBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewProductReviewBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogViewCmsCommentBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewCmsCommentBefore($args);

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

        // Support for OC4 extension
        $firstSlash = strpos($route, '/');
        $secondSlash = strpos($route, '/', $firstSlash + 1);
        $template_file = DIR_OPENCART . substr($route, 0, $secondSlash + 1) . 'catalog/view/template/' . substr($route, $secondSlash + 1) . '.twig';

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
