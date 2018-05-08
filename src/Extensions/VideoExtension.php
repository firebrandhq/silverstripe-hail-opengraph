<?php

namespace Firebrand\HailOG\Extensions;

use SilverStripe\ORM\DataExtension;

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