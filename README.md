# d3FrameworkBundle

dev
Add the content of the extra block to your composer.json to use our recipe:
```json
{
  "extra": {
    "symfony": {
      "endpoint": [
        "https://api.github.com/repos/LionAndDeer/recipes/contents/index.json?ref=main",
        "flex://defaults"
      ]
    }
  }
}
```

## Verwenden der D3-Security:
```yaml
security:
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
    providers:
        users_in_memory: { memory: null }
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: true
        main:
            lazy: true
            provider: users_in_memory
            custom_authenticator: Liondeer\Framework\Security\D3UserAuthenticator
```
Die letzte Zeile sorgt für die Einbindung der L & D Security.