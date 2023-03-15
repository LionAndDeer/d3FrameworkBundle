<?php
/** @noinspection PhpUnused */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */

namespace Liondeer\Framework\D3\Model;

use JetBrains\PhpStorm\Pure;

class UserResponse
{
    private string $id;
    private string $userName;
    private Name $name;
    private string $displayName = '';
    /** @var Email[] */
    private array $emails = [];
    /** @var Group[] */
    private array $groups = [];
    /** @var Photo[] */
    private array $photos = [];

    #[Pure]
    public function __construct()
    {
        $this->name = new Name();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getEmails(): array
    {
        $emails = [];
        foreach ($this->emails as $email) {
            array_push($emails, $email->getValue());
        }

        return $emails;
    }

    public function setEmails(array $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    public function getGroups(): array
    {
        $groups = [];
        foreach ($this->groups as $group) {
            /** @var Group $group */
            array_push($groups, [$group->getDisplay(), $group->getValue()]);
        }

        return $groups;
    }

    public function setGroups(array $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        foreach ($this->groups as $index => $myGroup) {
            if ($group === $myGroup) {
                unset($this->groups[$index]);
            }
        }
        return $this;
    }

    public function removeEmail(Email $email): self
    {
        foreach ($this->emails as $index => $myEmail) {
            if ($email === $myEmail) {
                unset($this->emails[$index]);
            }
        }
        return $this;
    }

    public function addEmail(Email $email)
    {
        $this->emails[] = $email;
    }

    public function removePhoto(Photo $photo): self
    {
        foreach ($this->photos as $index => $myPhoto) {
            if ($photo === $myPhoto) {
                unset($this->photos[$index]);
            }
        }
        return $this;
    }

    public function addPhoto(Photo $photo)
    {
        $this->photos[] = $photo;
    }

    public function addGroup(Group $group): self
    {
        $this->groups[] = $group;

        return $this;
    }

    public function getPhotos(): array
    {
        $photos = [];
        foreach ($this->photos as $photo) {
            array_push($photos, $photo->getValue());
        }

        return $photos;
    }

    public function setPhotos(array $photos): self
    {
        $this->photos = $photos;

        return $this;
    }
}

class Name
{
    private string $familyName = '';
    private string $givenName = '';

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }
}

class Email
{
    private string $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}

class Group
{
    private string $value;
    private string $display;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getDisplay(): string
    {
        return $this->display;
    }

    public function setDisplay(string $display): void
    {
        $this->display = $display;
    }
}

class Photo
{
    private string $value;

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
