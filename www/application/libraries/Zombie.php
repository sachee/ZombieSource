<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Player.php');
require_once(APPPATH . 'libraries/IPlayer.php');

class Zombie extends Player implements IPlayer{
    private $ci = null;

    public function __construct($playerid){
        parent::__construct($playerid);
        $this->ci =& get_instance();
    }

    // @Implements getStatus()
    public function getStatus(){
        return "zombie"; 
    }

    // @Implements getPublicStatus()
    public function getPublicStatus(){
        if($this->canParticipate()) {
            return "zombie";
        } else if ($this->isStarved() && parent::isActive()){
            return "starved zombie";
        } else {
            return "banned";
        }
    }

    // MOVE TO ZOMBIE
    public function secondsSinceLastFeed(){
        //check model
        $this->ci->load->model('Feed_model');
        $utcTime = null;
        try{
            $feedid = $this->ci->Feed_model->getMostRecentFeedIDByPlayerID($this->getPlayerID());
            $this->ci->load->library('FeedCreator');
            $feed = $this->ci->feedcreator->getFeedByFeedID($feedid);
            $utcTime = $feed->getFeedUTCDateTime();
        } catch (PlayerDoesNotHaveAnyValidFeedsException $e){
            //if none, check for tag
            $this->ci->load->helper('tag_helper');
            $tagid = getInitialTagIDByPlayer($this);
            if($tagid){
                $this->ci->load->library('TagCreator');
                $tag = $this->ci->tagcreator->getTagByTagID($tagid);
                $utcTime = $tag->getTagDateTimeClaimed();
            }
        }
        
        if($utcTime){
            $this->ci->load->helper('date_helper');
            $seconds = getUTCTimeDifferenceInSeconds(gmdate("Y-m-d H:i:s", time()), $utcTime);
            
            return $seconds;
        }
    }

    // MOVE TO ZOMBIE
    public function getKills(){
        $this->ci->load->helper('tag_helper');
        return getTagCountByPlayerID($this->getPlayerID());
    }

    public function isViewable(){
        if(parent::isActive()) {
            return true;
        } else {
            return false;
        }
    }

    public function canParticipate(){
        if(parent::isActive() && !$this->isStarved()){
            return true;
        } else {
            return false;
        }
    }

    public function isStarved(){
        $secondsSinceFeed = $this->secondsSinceLastFeed();
        if($secondsSinceFeed > 60*60*48 ){
            return true;
        }
        return false;
    }

    public function registerTag($humanCode, $claimed_tag_time_offset = null, $long = null, $lat = null){
        $this->ci->load->model('Tag_model','',true);
        
        $tagid = $this->ci->Tag_model->storeNewTag($taggeeid, $this->getPlayerID(), $claimed_tag_time_offset, $long, $lat);
        return $tagid;
    }

    public function isElligibleForTagUndo(){
        //can't undo tag if you're starved or if you already tagged someone else
        if(!$this->isStarved() && !$this->hasTaggedSomeone()){
            return true;
        }
        else{
            return false;
        }
    }

    public function hasTaggedSomeone(){
        return $this->ci->Tag_model->checkForTagByPlayerID($this->getPlayerID());
    }
}