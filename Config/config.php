<?php

/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return array(
    'name'        => 'Alertas',
    'description' => 'Ativa o token {alerts} para inserir o template de alertas da MinhaBVS nos emails do Mautic.',
    'author'      => 'Wilson Moura',
    'version'     => '1.0.0',

	'services'    => array(
        'events' => array(
            'plugin.alerts.emailbundle.subscriber' => array(
                'class' => \MauticPlugin\MauticAlertsBundle\EventListener\EmailSubscriber::class,
                'arguments' => array(
                    'translator',
                    'mautic.helper.templating',
                )
            )
        ),
        'forms' => array(
            'plugin.alerts.form' => array(
                'class' => \MauticPlugin\MauticAlertsBundle\Form\Type\AlertsType::class,
                'alias' => 'alerts'
            )
        )
    )
);
