<?php

namespace modules\Profile;

use app\Core\EntityModel;

class ProfileModel extends EntityModel
{
    protected $bd = DB_NAME;
    protected $table = 'profiles';

    private string $ban = '';

    private int $id = 0;
    private ?string $profileName = NULL;
    private ?string $descriptionName = NULL;
    private ?string $jsonItems = NULL;
    private ?string $jsonPermissions = NULL;
    private int $userActionId = 0;
    
    public function getBan(){ return $this->ban; }
    public function setBan($ban){ $this->ban = $ban; }

    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getProfileName(){ return $this->profileName; }
    public function setProfileName($profileName){ $this->profileName = $profileName; }

    public function getDescriptionName(){ return $this->descriptionName; }
    public function setDescriptionName($descriptionName){ $this->descriptionName = $descriptionName; }

    public function getJsonItems(){ return $this->jsonItems; }
    public function setJsonItems($jsonItems){ $this->jsonItems = $jsonItems; }

    public function getJsonPermissions(){ return $this->jsonPermissions; }
    public function setJsonPermissions($jsonPermissions){ $this->jsonPermissions = $jsonPermissions; }

    public function getUserActionId(){ return $this->userActionId; }
    public function setUserActionId($userActionId){ $this->userActionId = $userActionId; }

}

?>