# Project Title

This project is a [brief description].

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Contributing](#contributing)
- [License](#license)

## Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Set up the environment variables:

    - Copy the `.env.example` file to `.env`.
    - Update the `.env` file with your configuration.

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Run migrations && Seeders:

    ```bash
    php artisan migrate:fresh --seed
    ```

## Usage

Explain how to use your application or library. Include examples if needed.

## Features

- All Response Types Like Success, Error, unauthorized,  or Forbidden By Permission Have Same Response You  Can Check Handler and BaseController
- This project utilizes Laravel's authorization system with two separate tables for Admin and Users. We've implemented this using the `laravel-permission` package to manage roles and permissions.
- Use This Link To import Postman Collection https://api.postman.com/collections/21322026-6c538bf0-869e-4c06-a362-c81de198b437?access_key=PMAT-01HFM09SWWNY0HKT8S32CGM5XK

## Contributing

We welcome contributions! To contribute to this project, follow these steps:

1. Fork the project.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Make your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature/new-feature`).
6. Create a pull request.

Please follow our [code of conduct](CODE_OF_CONDUCT.md) and [contribution guidelines](CONTRIBUTING.md) when submitting pull requests.

## License

This project is licensed under the [License Name]. See the [LICENSE](LICENSE) file for details.
