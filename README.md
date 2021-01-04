Additional Information
----

For deployment to kubernetes clusters we use Helm 3.

For an in depth installation guide you can refer to the [installation guide](INSTALLATION.md).

- [Contributing](CONTRIBUTING.md)

- [ChangeLogs](CHANGELOG.md)

- [RoadMap](ROADMAP.md)

- [Security](SECURITY.md)

- [Licence](LICENSE.md)

Description
----

Het user component voert het beheer over gebruikersaccount en hun autorisaties. Hierbij kan in de traditionele zin worden gedacht aan aan een gebruik die behoort tot bepaald groepen die op hun beurt weer beschikken over bepaalde rechten. Waarbij het component tevens het bijhouden en valideren van wachtwoorden ondersteund (ten einde inlog mogelijkheden op bijvoorbeeld een dashboard of applicatie te faciliteren) maar in de wat abstracte context ondersteund het ook algemene inlogs systematieken.

Zo kan het user component zelf functioneren als oAuth 2.0 bron en daarmee de bronhouder zijn voor een OpenId van een gebruiker, maar kan het ook alternatieve inlog stromen zoals AFC en SAML afhandelen (en daarmee DigiD). Als laatste kan het functioneren als ontvangende partij van oAuth inloggen en biedt het daarmee een inloggen met facebook, Google of Github mogelijkheid voor applicaties.   

Tutorial
----

For information on how to work with the component you can refer to the tutorial [here](TUTORIAL.md).

#### Setup your local environment
Before we can spin up our component we must first get a local copy from our repository, we can either do this through the command line or use a Git client. 

For this example we're going to use [GitKraken](https://www.gitkraken.com/) but you can use any tool you like, feel free to skip this part if you are already familiar with setting up a local clone of your repository.

Open gitkraken press "clone a repo" and fill in the form (select where on your local machine you want the repository to be stored, and fill in the link of your repository on github), press "clone a repo" and you should then see GitKraken downloading your code. After it's done press "open now" (in the box on top) and voilá your codebase (you should see an initial commit on a master branch).

You can now navigate to the folder where you just installed your code, it should contain some folders and files and generally look like this. We will get into the files later, lets first spin up our component!

Next make sure you have [docker desktop](https://www.docker.com/products/docker-desktop) running on your computer.

Open a command window (example) and browse to the folder where you just stuffed your code, navigating in a command window is done by cd, so for our example we could type 
cd c:\repos\common-ground\my-component (if you installed your code on a different disk then where the cmd window opens first type <diskname>: for example D: and hit enter to go to that disk, D in this case). We are now in our folder, so let's go! Type docker-compose up and hit enter. From now on whenever we describe a command line command we will document it as follows (the $ isn't actually typed but represents your folder structure):

```CLI
$ docker-compose up
```

Your computer should now start up your local development environment. Don't worry about al the code coming by, let's just wait until it finishes. You're free to watch along and see what exactly docker is doing, you will know when it's finished when it tells you that it is ready to handle connections. 

Open your browser type [<http://localhost/>](https://localhost) as address and hit enter, you should now see your common ground component up and running.

#### Additional Calls

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

Credits
----

Information about the authors of this component can be found [here](AUTHORS.md)

Copyright © [Utrecht](https://www.utrecht.nl/) 2019
