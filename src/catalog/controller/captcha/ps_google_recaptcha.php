<?php
namespace Opencart\Catalog\Controller\Extension\PsGoogleReCaptcha\Captcha;
/**
 * Class PsGoogleReCaptcha
 *
 * @package
 */
class PsGoogleReCaptcha extends \Opencart\System\Engine\Controller
{
    /**
     * @return string
     */
    public function index(): string
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return '';
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $data = [];

        if (!isset($this->session->data['ps_google_recaptcha_counter'])) {
            $this->session->data['ps_google_recaptcha_counter'] = 0;
        } else {
            $this->session->data['ps_google_recaptcha_counter']++;
        }

        $data['widget_counter'] = $this->session->data['ps_google_recaptcha_counter'];
        $data['key_type'] = $this->config->get('captcha_ps_google_recaptcha_key_type');
        $data['badge_theme'] = $this->config->get('captcha_ps_google_recaptcha_badge_theme');
        $data['badge_size'] = $this->config->get('captcha_ps_google_recaptcha_badge_size');
        $data['badge_position'] = $this->config->get('captcha_ps_google_recaptcha_badge_position');
        $data['site_key'] = $this->config->get('captcha_ps_google_recaptcha_site_key');

        return $this->load->view('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', $data);

    }

    /**
     * @return string
     */
    public function validate(): string
    {
        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        unset($this->session->data['ps_google_recaptcha_counter']);

        if (!isset($this->request->post['g-recaptcha-response'])) {
            return $this->language->get('error_captcha');
        }

        $recaptcha_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('captcha_ps_google_recaptcha_secret_key')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

        $recaptcha = array_merge(
            ['success' => false, 'error-codes' => []],
            (array) json_decode($recaptcha_response, true)
        );

        if ($recaptcha['success']) {
            return '';
        }

        if ($recaptcha['error-codes']) {
            $errors = [];

            foreach ($recaptcha['error-codes'] as $error_code) {
                $errors[] = $this->language->get('error_' . str_replace('-', '_', $error_code));
            }

            $this->error['captcha'] = implode(', ', $errors);
        }

        $this->error['captcha'] = $this->language->get('error_captcha');
    }

    public function eventCatalogViewCommonHeaderBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $this->load->model('extension/ps_google_recaptcha/captcha/ps_google_recaptcha');

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewCommonHeaderBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogViewAccountRegisterBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        if (
            $this->config->get('captcha_ps_google_recaptcha_key_type') !== 'v3' &&
            $this->config->get('captcha_ps_google_recaptcha_key_type') !== 'v2_invisible'
        ) {
            return;
        }

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

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewAccountRegisterBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogViewAccountLoginBefore(string &$route, array &$args, string &$template): void
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        if (!in_array('login', (array) $this->config->get('config_captcha_page'))) {
            return;
        }

        $this->load->language('extension/ps_google_recaptcha/captcha/ps_google_recaptcha', 'ps');

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

        $headerViews = $this->model_extension_ps_google_recaptcha_captcha_ps_google_recaptcha->replaceCatalogViewAccountLoginBefore($args);

        $template = $this->replaceViews($route, $template, $headerViews);
    }

    public function eventCatalogControllerAccountLoginLoginAfter(string &$route, array &$args, string &$output = null)
    {
        if (!$this->config->get('captcha_ps_google_recaptcha_status')) {
            return;
        }

        $json_response = json_decode($this->response->getOutput(), true);

        if ($validation_result = $this->validate()) {
            $json_response['error'] = [];
            $json_response['error']['captcha'] = $validation_result;
        }

        $this->response->setOutput(json_encode($json_response));
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
