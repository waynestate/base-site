## Contributing
When contributing to this repository, please first discuss the change you wish to make via issue, email, or any other method with the owners of the repository.

### How to Contribute
1. Please open an issue before submitting a pull request.
2. Fork the waynestate/base-site.
3. Make your changes on the fork.
4. Add any necessary tests for your change under the `tests` folder
5. Submit a PR to the waynestate/base-site **develop** branch.

### Coding conventions

Start reading our code and you'll get the hang of it. We optimize for readability:

* We require [EditorConfig](http://editorconfig.org/) to be used with your IDE to take advantage of the project's `.editorconfig` settings.
* PSR-2 Coding Standard - The easiest way to apply the conventions is to run `make phplint`, which uses [Laravel Pint](https://laravel.com/docs/9.x/pint).
    * It will use the `pint.json` file within the project to tailor to our code styling.
* Static Analysis - We use [PHPStan/Larastan](https://github.com/larastan/larastan) to perform static analysis on the codebase.
    * Run `make phpstan` to analyze the codebase.
    * The configuration is in the `phpstan.neon` file at the root of the project.

### Security

If you discover any security related issues, please email web@wayne.edu instead of using the issue tracker.
