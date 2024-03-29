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

use Mautic\CoreBundle\Helper\TemplatingHelper;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Mautic\EmailBundle\Event\EmailSendEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class EmailSubscriber
 */
class EmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var TemplatingHelper
     */
    private $templating;

    public function __construct(
        TranslatorInterface $translator,
        TemplatingHelper $templating
    ) {
        $this->translator = $translator;
        $this->templating = $templating;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            EmailEvents::EMAIL_ON_BUILD   => ['onEmailBuild', 0],
            EmailEvents::EMAIL_ON_SEND    => ['decodeTokensSend', 0],
            EmailEvents::EMAIL_ON_DISPLAY => ['decodeTokensDisplay', 0],
        );
    }

    /**
     * @param EmailBuilderEvent $event
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function onEmailBuild(EmailBuilderEvent $event)
    {
        // register tokens
        $tokens = [
            '{alerts}' => $this->translator->trans('plugin.alerts.token'),
        ];

        if ($event->tokensRequested($tokens)) {
            $event->addTokens(
                $event->filterTokens($tokens)
            );
        }
    }

    /**
     * Search and replace tokens with content.
     *
     * @param EmailSendEvent $event
     *
     * @throws \RuntimeException
     */
    public function decodeTokensDisplay(EmailSendEvent $event)
    {
        $this->decodeTokens($event);
    }

    /**
     * Search and replace tokens with content.
     *
     * @param EmailSendEvent $event
     *
     * @throws \RuntimeException
     */
    public function decodeTokensSend(EmailSendEvent $event)
    {
        $this->decodeTokens($event);
    }

    /**
     * Search and replace tokens with content.
     *
     * @param EmailSendEvent $event
     *
     * @throws \RuntimeException
     */
    public function decodeTokens(EmailSendEvent $event)
    {
        $tokens = [];
        $lead = $event->getLead();
        $request = "https://alertas.platserv.bvsalud.org/alerts/templates/alerts.php?id=";

        $params  = array (
            'content' => file_get_contents($request.$lead['my_vhl_id'].'&lang='.$lead['alerts_lang']),
        );

        //$content = $event->getContent();
        $content = $this->templating->getTemplating()->render(
            'MauticAlertsBundle:SubscribedEvents\EmailToken:token.html.php',
            $params
        );

        $tokens['{alerts}'] = $content;
        $event->addTokens($tokens);
        //unset($tokens);
    }
}
