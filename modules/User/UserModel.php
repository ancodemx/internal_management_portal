<?php

namespace modules\User;

use app\Core\EntityModel;

class UserModel extends EntityModel
{
    protected $bd = DB_NAME;
    protected $table = 'users';

    private string $ban = '';

    private int $id = 0;
    private ?string $firstName = NULL;
    private ?string $lastName = NULL;
    private ?string $middleName = NULL;
    private ?string $email = NULL;
    private ?string $username = NULL;
    private ?string $password = NULL;
    private ?int $profileId = NULL;
    private ?string $jsonCategories = NULL;
    private int $userActionId = 0;
    

    public function getBan(){ return $this->ban; }
    public function setBan($ban){ $this->ban = $ban; }

    public function getId(){ return $this->id; }
    public function setId($id){ $this->id = $id; }

    public function getFirstName(){ return $this->firstName; }
    public function setFirstName($firstName){ $this->firstName = $firstName; }

    public function getLastName(){ return $this->lastName; }
    public function setLastName($lastName){ $this->lastName = $lastName; }

    public function getMiddleName(){ return $this->middleName; }
    public function setMiddleName($middleName){ $this->middleName = $middleName; }

    public function getEmail(){ return $this->email; }
    public function setEmail($email){ $this->email = $email; }

    public function getUsername(){ return $this->username; }
    public function setUsername($username){ $this->username = $username; }

    public function getPassword(){ return $this->password; }
    public function setPassword($password){ $this->password = $password; }

    public function getProfileId(){ return $this->profileId; }
    public function setProfileId($profileId){ $this->profileId = $profileId; }

    public function getJsonCategories(){ return $this->jsonCategories; }
    public function setJsonCategories($jsonCategories){ $this->jsonCategories = $jsonCategories; }

    public function getUserActionId(): int { return $this->userActionId; }
    public function setUserActionId(int $userActionId): void { $this->userActionId = $userActionId; }

}

?>