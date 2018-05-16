<?php

namespace Firebrand\HailOG\Extensions;

use SilverStripe\ORM\DataExtension;


/**
 * Adds Opengrah Support for Hail Video
 *
 * see @link {TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectRequired] and @link {TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectExplicit} for fields description
 *
 * @package silverstripe-hail-elemental
 * @author Marc Espiard, Firebrand
 * @version 1.0
 */
class VideoExtension extends DataExtension
{
    public function OGLink()
    {
        switch ($this->owner->Service) {
            case "youtube":
                $link = "https://www.youtube.com/v/" . $this->owner->ServiceData;
                break;
            case "vimeo":
                $link = "https://vimeo.com/" . $this->owner->ServiceData;
                break;
            default:
                $link = null;
                break;
        }

        return $link;
    }
}