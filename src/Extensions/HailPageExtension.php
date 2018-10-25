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
    private $article = null;

    public function __construct()
    {
        $params = Controller::curr()->getRequest()->params();
        if (isset($params['Action']) && $params['Action'] === "article" && isset($params['ID']) && !empty($params['ID'])) {
            $article = Article::get()->filter(['HailID' => $params['ID']])->first();
            if ($article) {
                $this->article = $article;
            }
        }
    }

    public function AbsoluteLink(&$link = null)
    {
        if ($this->article) {
            $link = Director::absoluteURL($this->article->Link(), true);
        }

        return $link;
    }

    public function getOGImage()
    {
        if ($this->article) {
            if ($this->article->hasHeroImage()) {
                return $this->article->HeroImage()->Urloriginal;
            }
            if ($this->article->hasHeroVideo()) {
                return $this->article->HeroVideo()->Urloriginal;
            }
        }

        return Director::absoluteURL('resources/vendor/tractorcow/silverstripe-opengraph/images/logo.gif', true);
    }

    public function getOGTitle()
    {
        if ($this->article) {
            return $this->article->Title;
        }

        return $this->getOwner()->Title;
    }

    public function getOGType()
    {
        return 'website';
    }

    public function getOGDescription()
    {
        if ($this->article) {
            return Convert::html2raw($this->article->Lead);
        }

        return Convert::html2raw($this->getOwner()->Content);
    }

    public function getOGVideo()
    {
        if ($this->article && $this->article->hasHeroVideo()) {
            return $this->article->HeroVideo()->OGLink();
        }

        return null;
    }
}