<?php

namespace Firebrand\HailOG\Extensions;

use Firebrand\Hail\Models\Article;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataExtension;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectRequired;


/**
 * Hail Page Extension, adds OpenGraph supports and fields to every Hail page
 *
 * see @link {TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectRequired] and @link {TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectExplicit} for fields description
 *
 * @package silverstripe-hail-elemental
 * @author Marc Espiard, Firebrand
 * @version 1.0
 */
class HailPageExtension extends Extension implements IOGObjectRequired
{
    public function AbsoluteLink(&$link = null)
    {
        if (Controller::curr()->article) {
            $link = Director::absoluteURL(Controller::curr()->article->Link(), true);
        }

        return $link;
    }

    public function getOGImage()
    {
        if (Controller::curr()->article) {
            if (Controller::curr()->article->hasHeroImage()) {
                return Controller::curr()->article->HeroImage()->Urloriginal;
            }
            if (Controller::curr()->article->hasHeroVideo()) {
                return Controller::curr()->article->HeroVideo()->Urloriginal;
            }
        }

        return Director::absoluteURL('resources/vendor/tractorcow/silverstripe-opengraph/images/logo.gif', true);
    }

    public function getOGTitle()
    {
        if (Controller::curr()->article) {
            return Controller::curr()->article->Title;
        }

        return $this->getOwner()->Title;
    }

    public function getOGType()
    {
        return 'website';
    }

    public function getOGDescription()
    {
        if (Controller::curr()->article) {
            return Convert::html2raw(Controller::curr()->article->Lead);
        }

        return Convert::html2raw($this->getOwner()->Content);
    }

    public function getOGVideo()
    {
        if (Controller::curr()->article && Controller::curr()->article->hasHeroVideo()) {
            return Controller::curr()->article->HeroVideo()->OGLink();
        }

        return null;
    }
}