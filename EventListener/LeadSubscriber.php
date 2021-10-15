<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticAlertsBundle\EventListener;

use Mautic\LeadBundle\Event as Events;
use Mautic\LeadBundle\LeadEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LeadSubscriber
 *
 * @package Mautic\LeadBundle\EventListener
 */
class LeadSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    static public function getSubscribedEvents()
    {
        return array(
            LeadEvents::LEAD_POST_SAVE     => array('onLeadPostSave', 0),
            LeadEvents::LEAD_POST_DELETE   => array('onLeadDelete', 0)
        );
    }

    public function onLeadPostSave(LeadEvent $event)
    {
        $lead = $event->getLead();

        // do something
    }

    public function onLeadDelete(LeadEvent $event)
    {
        $lead = $event->getLead();

        $deletedId = $lead->deletedId;

        // do something
    }
}