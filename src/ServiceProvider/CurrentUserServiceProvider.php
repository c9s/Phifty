<?php

namespace Phifty\ServiceProvider;

use Phifty\Kernel;
use Phifty\Security\CurrentUser;

class CurrentUserServiceProvider extends ServiceProvider
{
    public function getId()
    {
        return 'current_user';
    }

    public static function canonicalizeConfig(Kernel $kernel, array $options)
    {
        $args = [];
        $args['model_class'] = isset($options['Model'])
            ? $options['Model']
            : $kernel->config->get('framework', 'CurrentUser.Model');

        if (isset($options['PrimaryKey'])) {
            $args['primary_key'] = $options['PrimaryKey'];
        }

        if (isset($options['SessionPrefix'])) {
            $args['session_prefix'] = $options['SessionPrefix'];
        }

        $currentUserClass = isset($options['Class'])
            ? $options['Class']
            : $kernel->config->get('framework', 'CurrentUser.Class') ?: CurrentUser::class;

        $options['CurrentUserConstructorArgs'] = $args;
        $options['CurrentUserClass'] = $currentUserClass;

        return $options;
    }

    public function register(Kernel $kernel, array $options = array())
    {
        $kernel->event->register('view.init', function ($view) use ($kernel) {
            $view['CurrentUser'] = $kernel->currentUser;
        });
        $kernel->currentUser = function () use ($options) {
            $currentUserClass = $options['CurrentUserClass'];

            return new $currentUserClass($options['CurrentUserConstructorArgs']);
        };
    }
}
