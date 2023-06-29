<?php

namespace Liondeer\Framework\Model\HttpGateway;

class SubscribedAppsModel
{
    /**
     * @var AppModel[]
     */
    private array $subscribedApps = [];

    /**
     * @return array
     */
    public function getSubscribedApps(): array
    {
        return $this->subscribedApps;
    }

    /**
     * @param array $subscribedApps
     * @return SubscribedAppsModel
     */
    public function setSubscribedApps(array $subscribedApps): SubscribedAppsModel
    {
        $this->subscribedApps = $subscribedApps;
        return $this;
    }

    public function isAppSubscribed(string $name): bool
    {
        foreach ($this->subscribedApps as $app) {
            if ($app->getName() === $name) {
                return true;
            }
        }
        return false;
    }

    public function addSubscribedApp(string $name): self
    {
        $app = new AppModel();
        $app
            ->setName($name)
        ;
        $this->subscribedApps[] = $app;
        return $this;
    }
}