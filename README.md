# Project Title

This project serves as a [brief description].

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Postman Collection](#postman-collection)
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

    - Duplicate the `.env.example` file as `.env`.
    - Update the `.env` file with your configuration details.

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

5. Run migrations and seeders:

    ```bash
    php artisan migrate:fresh --seed
    ```

## Usage

Provide detailed instructions on how to use your application or library. Include examples if needed.

## Features

- Uniform Response Handling: All response types (Success, Error, Unauthorized, Forbidden by Permission) follow a consistent format. Check the Handler and BaseController for implementation details.
- Authorization System: Utilizes `laravel-permission` to manage roles and permissions with separate tables for Admin and Users.
- Multi Guards With Permissions For Admin
- Used one query like it was required in task
- Clean Code
- I Could Have written some unit Tests and made Repositories For Controllers but I didn't have time 

## Postman Collection

[Import the Postman Collection](https://api.postman.com/collections/21322026-6c538bf0-869e-4c06-a362-c81de198b437?access_key=PMAT-01HFM09SWWNY0HKT8S32CGM5XK) for easy API testing and usage.

## Contributing

We encourage contributions! To contribute to this project:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Implement your changes.
4. Commit your changes (`git commit -am 'Add new feature'`).
5. Push to the branch (`git push origin feature/new-feature`).
6. Create a pull request.

Please adhere to our [code of conduct](CODE_OF_CONDUCT.md) and [contribution guidelines](CONTRIBUTING.md) when submitting pull requests.

## License

This project is licensed under the [License Name]. Review the [LICENSE](LICENSE) file for details.
