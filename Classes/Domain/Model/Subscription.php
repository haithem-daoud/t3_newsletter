<?php

namespace TYPO3\T3Newsletter\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class Subscription extends AbstractEntity {

    /**
     * @var bool
     */
    protected bool $hidden = true;

    /**
     * @var string
     */
    protected string $gender = '';

    /**
     * @var string
     */
    protected string $firstname = '';

    /**
     * @var string
     */
    protected string $lastname = '';

    /**
     * @var string
     */
    protected string $email = '';
   
   /**
    * @var string
    */
   protected string $emailConfirmation = '';
   
   /**
    * @var string
    */
   protected string $company = '';
   
   /**
    * @var string
    */
   protected string $token = '';
   
   /**
    * @var boolean
    */
   protected bool $dataPrivacyAccepted = false;
   
   /**
    * @var boolean
    */
   protected bool $emailConfirmed = false;

   function getFirstname(): string
   {
       return $this->firstname;
   }

    function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

   function getLastname(): string
   {
       return $this->lastname;
   }

    function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

   function getEmail(): string
   {
       return $this->email;
   }

    function setEmail($email)
    {
        $this->email = $email;
    }

   function getToken(): string
   {
       return $this->token;
   }

    function setToken($token)
    {
        $this->token = $token;
    }

   function getDataPrivacyAccepted(): bool
   {
       return $this->dataPrivacyAccepted;
   }

   function setDataPrivacyAccepted($dataPrivacyAccepted)
   {
       $this->dataPrivacyAccepted = $dataPrivacyAccepted;
   }
   
   function getGender(): string
   {
       return $this->gender;
   }

    public function getGenderOptions(): array
    {
        return [
            '' => LocalizationUtility::translate('subscription.gender.select', 't3_newsletter'),
            'male' => LocalizationUtility::translate('subscription.gender.male', 't3_newsletter'),
            'female' => LocalizationUtility::translate('subscription.gender.female', 't3_newsletter')
        ];
    }

   function setGender($gender)
   {
       $this->gender = $gender;
   }

   function getEmailConfirmed(): bool
   {
       return $this->emailConfirmed;
   }

   function setEmailConfirmed($emailConfirmed)
   {
       $this->emailConfirmed = $emailConfirmed;
   }

   function getCompany(): string
   {
       return $this->company;
   }

    function setCompany($company)
    {
        $this->company = $company;
    }
   
   function getHidden(): bool
   {
       return $this->hidden;
   }

   function setHidden($hidden)
   {
       $this->hidden = $hidden;
   }
   
   function getEmailConfirmation(): string
   {
       return $this->emailConfirmation;
   }

   function setEmailConfirmation($emailConfirmation)
   {
       $this->emailConfirmation = $emailConfirmation;
   }
}