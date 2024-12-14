<?php
// Heading
$_['heading_title']                    = 'Playful Sparkle - Google reCAPTCHA';
$_['heading_fix']                      = 'Исправление общих ошибок';
$_['heading_getting_started']          = 'Начало работы';
$_['heading_setup']                    = 'Настройка Google reCAPTCHA';
$_['heading_troubleshot']              = 'Типичные проблемы';
$_['heading_faq']                      = 'Часто задаваемые вопросы';
$_['heading_contact']                  = 'Связаться с поддержкой';
$_['heading_v3_score_threshold']       = 'Порог оценки';

// Text
$_['text_extension']                   = 'Расширения';
$_['text_success']                     = 'Успех: Вы успешно изменили настройки Google reCAPTCHA!';
$_['text_edit']                        = 'Редактировать Google reCAPTCHA';
$_['text_signup']                      = 'Перейдите на <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank" rel="noopener noreferrer">страницу Google reCAPTCHA</a> и зарегистрируйте ваш сайт.';
$_['text_getting_started']             = '<p><strong>Обзор:</strong> Playful Sparkle - Google reCAPTCHA — это расширение для OpenCart 4, предназначенное для защиты вашего магазина от спама и злоупотреблений. Оно поддерживает несколько реализаций Google reCAPTCHA, включая основанный на баллах (v3), флажок (v2) и невидимый (v2), предоставляя гибкость и повышенную безопасность для вашего магазина.</p><p><strong>Требования:</strong> OpenCart 4.x+, PHP 7.4+ или выше</p>';
$_['text_setup']                       = '<ul><li><strong>Шаг 1:</strong> Получите свой reCAPTCHA Site Key и Secret Key в <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="noopener noreferrer">консоли администратора Google reCAPTCHA</a>.</li><li><strong>Шаг 2:</strong> В админ-панели OpenCart перейдите в настройки расширений и выберите реализацию reCAPTCHA, которую вы хотите использовать (на основе баллов v3, флажок v2 или невидимый v2).</li><li><strong>Шаг 3:</strong> Настройте параметры в зависимости от выбранной реализации:<ul><li>Для основанного на баллах (v3): Установите положение значка (внизу слева, внизу справа или встраиваемое). Для встроенного выберите светлую или темную тему или скрыть значок (с уведомлением в нижнем колонтитуле для соответствия политике Google).</li><li>Для флажка (v2): Установите тему значка (светлая или темная) и размер (нормальный или компактный).</li><li>Для невидимого флажка (v2): Установите положение значка (внизу слева, внизу справа или встраиваемое). Для встроенного выберите светлую или темную тему.</li></ul></li><li><strong>Шаг 4:</strong> Настройте reCAPTCHA для нужных страниц в настройках OpenCart.</li></ul>';
$_['text_troubleshot']                 = '<ul><li><strong>Проблема:</strong> reCAPTCHA не отображается. <strong>Решение:</strong> Убедитесь, что правильные Site Key и Secret Key введены, и подтвердите, что ваш домен зарегистрирован в консоли администратора Google reCAPTCHA.</li><li><strong>Проблема:</strong> Ошибка при проверке. <strong>Решение:</strong> Убедитесь, что пара ключей соответствует выбранной реализации reCAPTCHA (например, ключи v2 для флажка не могут быть использованы для v3).</li><li><strong>Проблема:</strong> Настройка значка не отображается должным образом. <strong>Решение:</strong> Перепроверьте настройки конфигурации значка (например, положение, тему или размер).</li></ul>';
$_['text_faq']                         = '<details><summary>Какую реализацию reCAPTCHA выбрать?</summary> Это зависит от ваших потребностей:<ul><li><strong>Основанный на баллах (v3):</strong> Идеален для бесшовного пользовательского опыта без прямого взаимодействия, полезен для фоновой проверки.</li><li><strong>Флажок (v2):</strong> Добавляет четкий флажок "Я не робот" для видимого взаимодействия, идеально подходит для форм с пользовательским интерфейсом.</li><li><strong>Невидимый (v2):</strong> Проверяет запросы в фоновом режиме без взаимодействия с пользователем, идеально подходит для более чистых интерфейсов с необязательным отображением значка.</li></ul></details><details><summary>Почему появляется ошибка "Неверный ключ сайта"?</summary> Это происходит, когда введенные вами ключи не соответствуют выбранной реализации reCAPTCHA. Убедитесь, что используете правильную пару ключей для выбранной реализации (например, ключи v3 для v3, ключи v2 для флажка v2 и т. д.).</details><details><summary>Где можно включить reCAPTCHA?</summary> reCAPTCHA можно настроить для различных страниц на странице настроек OpenCart.</details>';
$_['text_contact']                     = '<p>Для получения дополнительной помощи свяжитесь с нашей службой поддержки:</p><ul><li><strong>Контакт:</strong> <a href="mailto:%s">%s</a></li><li><strong>Документация:</strong> <a href="%s" target="_blank" rel="noopener noreferrer">Документация пользователя</a></li></ul>';
$_['text_key_type_v3']                 = 'На основе баллов (v3) - Проверка запросов по баллам';
$_['text_key_type_v2_checkbox']        = 'Проверка (v2) - Флажок "Я не робот"';
$_['text_key_type_v2_invisible']       = 'Проверка (v2) - Невидимый значок reCAPTCHA';
$_['text_badge_inline']                = 'Встраиваемый';
$_['text_badge_bottom_left']           = 'Внизу слева';
$_['text_badge_bottom_right']          = 'Внизу справа';
$_['text_badge_dark']                  = 'Темный';
$_['text_badge_light']                 = 'Светлый';
$_['text_badge_compact']               = 'Компактный';
$_['text_badge_normal']                = 'Нормальный';
$_['text_badge_invisible']             = 'Невидимый';
$_['text_csp_info']                    = 'Убедитесь, что ваша политика безопасности контента (CSP) правильно настроена для работы с Google reCAPTCHA. Мы рекомендуем использовать <strong>метод nonce из CSP3</strong> для максимальной безопасности. В качестве альтернативы включите <strong>script-src</strong> для разрешения <strong>https://www.google.com/recaptcha/</strong> и <strong>https://www.gstatic.com/recaptcha/</strong>, а также <strong>frame-src</strong> для разрешения <strong>https://www.google.com/recaptcha/</strong> и <strong>https://recaptcha.google.com/recaptcha/</strong>. Использование <strong>strict-dynamic</strong> также поддерживается в совместимых браузерах.';
$_['text_v3_score_threshold_register'] = 'Регистрация';
$_['text_v3_score_threshold_guest']    = 'Покупка как гость';
$_['text_v3_score_threshold_review']   = 'Отзывы';
$_['text_v3_score_threshold_comment']  = 'Комментарий';
$_['text_v3_score_threshold_return']   = 'Возвраты';
$_['text_v3_score_threshold_contact']  = 'Контакт';

// Tab
$_['tab_general']                      = 'Основные';
$_['tab_security']                     = 'Безопасность';
$_['tab_help_and_support']             = 'Помощь и поддержка';

// Entry
$_['entry_key_type']                   = 'Тип reCAPTCHA';
$_['entry_site_key']                   = 'Ключ сайта';
$_['entry_secret_key']                 = 'Секретный ключ';
$_['entry_status']                     = 'Статус';
$_['entry_badge_position']             = 'Позиция значка';
$_['entry_badge_theme']                = 'Тема значка';
$_['entry_badge_size']                 = 'Размер значка';
$_['entry_hide_badge']                 = 'Скрыть значок';
$_['entry_script_nonce']               = 'Nonce для скрипта';
$_['entry_google_captcha_nonce']       = 'Nonce для скрипта Google Captcha API';
$_['entry_css_nonce']                  = 'Nonce для тега стилей CSS';

// Button
$_['button_fix_event_handler']         = 'Исправить обработчик событий';

// Help
$_['help_copy']                        = 'Копировать URL';
$_['help_key_type']                    = 'Выберите тип reCAPTCHA для этого ключа сайта. Ключ сайта работает только с одним типом reCAPTCHA. См. <a href="https://developers.google.com/recaptcha/docs/versions" target="_blank" rel="noopener noreferrer">Типы сайтов</a> для получения дополнительной информации.';
$_['help_hide_badge']                  = 'Включив эту опцию, вы можете полностью скрыть значок Google reCAPTCHA. Внизу каждой страницы автоматически будет добавлено уведомление для соблюдения руководящих принципов Google. Для получения дополнительной информации обратитесь к разделу <a href="https://developers.google.com/recaptcha/docs/faq#id-like-to-hide-the-recaptcha-badge.-what-is-allowed" target="_blank" rel="noopener noreferrer">Я хочу скрыть значок reCAPTCHA. Что разрешено?</a> на странице часто задаваемых вопросов Google reCAPTCHA.';
$_['help_site_key']                    = 'Используйте этот ключ сайта в HTML-коде, который ваш сайт отправляет пользователям.';
$_['help_secret_key']                  = 'Используйте этот секретный ключ для связи между вашим сайтом и reCAPTCHA.';
$_['help_v3_score_threshold']          = 'Эта настройка определяет порог для оценки, возвращаемой reCAPTCHA v3. Оценка варьируется от 0,0 до 1,0, где более высокая оценка (ближе к 1,0) указывает на большую вероятность легитимного взаимодействия пользователя, а более низкая оценка (ближе к 0,0) предполагает большую вероятность бота. Вы можете настроить этот порог, чтобы определить действия в зависимости от оценки. По умолчанию используется порог 0,5, но вы можете изменить его в зависимости от специфических требований вашего сайта.';

// Error
$_['error_permission']                 = 'Предупреждение: У вас нет прав на изменение Google reCAPTCHA!';
$_['error_site_key']                   = 'Требуется ключ!';
$_['error_secret_key']                 = 'Требуется секрет!';
$_['error_v3_score_threshold_value']   = 'Значение балла должно быть между 0 и 1. Оно не может быть меньше 0 или больше 1.';
