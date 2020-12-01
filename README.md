![Vonage][logo]

# Stream Audio Into a Call With PHP

This repository is the complete example for the accompanying post at: [Stream Audio Into a Call With PHP](https://learn.vonage.com/blog/2019/04/12/play-audio-voice-call-php-dr)

**Table of Contents**

- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Code of Conduct](#code-of-conduct)
- [Contributing](#contributing)
- [License](#license)

## Prerequisites

- A phone number
- [A Vonage account](https://dashboard.nexmo.com/sign-up?utm_source=DEV_REL&utm_medium=github&utm_campaign=https://github.com/nexmo-community/stream-audio-into-call-php)
- [Vonage Application](https://dashboard.nexmo.com/applications) and [Virtual phone number](https://dashboard.nexmo.com/buy-numbers)
- [Nexmo-CLI](https://github.com/Nexmo/nexmo-cli)
- [Composer](http://getcomposer.org/)
- [Ngrok](https://learn.vonage.com/blog/2017/07/04/local-development-nexmo-ngrok-tunnel-dr)

### Getting Started

* Install dependencies - `composer install`
* Run the application - `php -t . -S localhost:8000`
* Expose your application to the internet - `ngrok http 8000`
* Update your `answer_url` and `event_url` in your [Vonage application](https://dashboard.nexmo.com/applications)
* Call your Vonage Number to hear the welcome message
* Make a request to `<ngrok url>/trigger/<ID>/1` to play audio in to an active call.

## Code of Conduct

In the interest of fostering an open and welcoming environment, we strive to make participation in our project and our community a harassment-free experience for everyone. Please check out our [Code of Conduct][coc] in full.

## Contributing
We :heart: contributions from everyone! Check out the [Contributing Guidelines][contributing] for more information.

[![contributions welcome][contribadge]][issues]

## License

This project is subject to the [MIT License][license]

[logo]: vonage_logo.png "Vonage"
[contribadge]: https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat "Contributions Welcome"

[coc]: CODE_OF_CONDUCT.md "Code of Conduct"
[contributing]: CONTRIBUTING.md "Contributing"
[license]: LICENSE "MIT License"

[issues]: ./../../issues "Issues"
