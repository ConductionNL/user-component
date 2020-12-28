About this component
-------
Het user component voert het beheer over gebruikersaccount en hun autorisaties. Hierbij kan in de traditionele zin worden gedacht aan aan een gebruik die behoort tot bepaald groepen die op hun beurt weer beschikken over bepaalde rechten. Waarbij het component tevens het bijhouden en valideren van wachtwoorden ondersteund (ten einde inlog mogelijkheden op bijvoorbeeld een dashboard of applicatie te faciliteren) maar in de wat abstracte context ondersteund het ook algemene inlogs systematieken.

Zo kan het user component zelf functioneren als oAuth 2.0 bron en daarmee de bronhouder zijn voor een OpenId van een gebruiker, maar kan het ook alternatieve inlog stromen zoals AFC en SAML afhandelen (en daarmee DigiD). Als laatste kan het functioneren als ontvangende partij van oAuth inloggen en biedt het daarmee een inloggen met facebook, Google of Github mogelijkheid voor applicaties.   

## Documentation

This component also provides the /login endpoint.

If you post an JSON object with a username and password these credentials will be checked.

```json
{
  "username": "test@user.nl",
  "password": "password"
}
```

If they are correct you wil get the user object as a response.

Otherwise you will receive a 403 access denied response.

- [Installation manual](https://github.com/ConductionNL/user-component/blob/master/INSTALLATION.md).
- [codebase](https://github.com/ConductionNL/user-component) on github.
- [codebase](https://github.com/ConductionNL/user-component/archive/master.zip) as a download.

Credits
-------

Created by [Ruben van der Linde](https://www.conduction.nl/team) for conduction. But based on [api platform](https://api-platform.com) by [Kévin Dunglas](https://dunglas.fr). Commercial support for common ground components available from [Conduction](https://www.conduction.nl).
