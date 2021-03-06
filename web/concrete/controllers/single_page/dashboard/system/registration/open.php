<?php
namespace Concrete\Controller\SinglePage\Dashboard\System\Registration;

use Concrete\Core\Page\Controller\DashboardPageController;
use Config;
use Loader;

class Open extends DashboardPageController
{

    public $helpers = array('form');

    public function update_registration_type()
    {
        if ($this->isPost()) {
            Config::save('USER_REGISTRATION_WITH_EMAIL_ADDRESS', ($this->post('email_as_username') ? true : false));

            Config::save('REGISTRATION_TYPE', $this->post('registration_type'));
            Config::save('ENABLE_REGISTRATION_CAPTCHA', ($this->post('enable_registration_captcha')) ? true : false);

            switch ($this->post('registration_type')) {
                case "enabled":
                    Config::save('ENABLE_REGISTRATION', true);
                    Config::save('USER_VALIDATE_EMAIL', false);
                    Config::save('USER_REGISTRATION_APPROVAL_REQUIRED', false);
                    Config::save('REGISTER_NOTIFICATION', $this->post('register_notification'));
                    Config::save(
                        'EMAIL_ADDRESS_REGISTER_NOTIFICATION',
                        Loader::helper('security')->sanitizeString(
                            $this->post('register_notification_email')));
                    break;

                case "validate_email":
                    Config::save('ENABLE_REGISTRATION', true);
                    Config::save('USER_VALIDATE_EMAIL', true);
                    Config::save('USER_REGISTRATION_APPROVAL_REQUIRED', false);
                    Config::save('REGISTER_NOTIFICATION', $this->post('register_notification'));
                    Config::save(
                        'EMAIL_ADDRESS_REGISTER_NOTIFICATION',
                        Loader::helper('security')->sanitizeString(
                            $this->post('register_notification_email')));
                    break;

                case "manual_approve":
                    Config::save('ENABLE_REGISTRATION', true);
                    Config::save('USER_REGISTRATION_APPROVAL_REQUIRED', true);
                    Config::save('USER_VALIDATE_EMAIL', false);
                    Config::save('REGISTER_NOTIFICATION', $this->post('register_notification'));
                    Config::save(
                        'EMAIL_ADDRESS_REGISTER_NOTIFICATION',
                        Loader::helper('security')->sanitizeString(
                            $this->post('register_notification_email')));
                    break;

                default: // disabled
                    Config::save('ENABLE_REGISTRATION', false);
                    Config::save('REGISTER_NOTIFICATION', false);
                    break;
            }
            Config::save('REGISTRATION_TYPE', $this->post('registration_type'));

            $this->redirect('/dashboard/system/registration/open', 1);
        }
    }

    public function view($updated = false)
    {
        if ($updated) {
            $this->set('message', t('Registration settings have been saved.'));
        }
        $this->token = Loader::helper('validation/token');

        $this->set('email_as_username', USER_REGISTRATION_WITH_EMAIL_ADDRESS);
        $this->set('registration_type', REGISTRATION_TYPE);
        $this->set('user_timezones', ENABLE_USER_TIMEZONES);
        $this->set('enable_registration_captcha', ENABLE_REGISTRATION_CAPTCHA);
        $this->set('register_notification', REGISTER_NOTIFICATION);
        $this->set('register_notification_email', EMAIL_ADDRESS_REGISTER_NOTIFICATION);
    }

}
