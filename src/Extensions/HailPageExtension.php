<?php

namespace Firebrand\HailOG\Extensions;

use Firebrand\Hail\Models\Article;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectRequired;

class HailPageExtension extends DataExtension implements IOGObjectRequired
{
    private $article = null;

    public function __construct()
    {
        $params = Controller::curr()->getRequest()->params();
        if ($params['Action'] === "article" && !empty($params['ID'])) {
            $article = Article::get()->filter(['HailID' => $params['ID']])->first();
            if ($article) {
                $this->article = $article;
            }
        }
    }

    public function AbsoluteLink()
    {
        if ($this->article) {
            $url = $this->article->Link();
            return $url;
        }

        return Controller::curr()->Link();
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

        return Director::absoluteURL('resources/vendor/firebrand/silverstripe-hail-opengraph/images/hail-logo.png', true);
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
        return null;
    }
}