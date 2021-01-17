# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 3.0.1 - 2021-01-17

### Fixed
- Fixed issue where it was possible to get more output after a 404 was generated.

## 3.0.0 - 2021-01-17

### Added
- A way to write custom routers and with that make routing more dynamic.
- Middleware implementation to generalize any checks for routes.
- Input method to retrieve all parameters at once.

### Removed
- Standard routers and group routers.
- Service declaration of routes and route groups.
- Authorization logic in favor of middleware implementation.
- Removed path matcher for middleware.

## 2.0.0 - 2020-11-10

### Added
- Route and route group compiler and factory.

### Removed
- Support for old way of registering routes and route groups.
- Support for authorization registration, moved to direct services.

## 1.0.1 - 2020-08-10

### Fixed
- Issue with home path never being empty during the check in the router.

## 1.0.0 - 2020-08-08

### Added
- The initial implementation of the package.

# Versions
- [3.0.1 > Unreleased](https://github.com/ulrack/web/compare/3.0.0...HEAD)
- [3.0.0 > 3.0.1](https://github.com/ulrack/web/compare/3.0.0...3.0.1)
- [2.0.0 > 3.0.0](https://github.com/ulrack/web/compare/2.0.0...3.0.0)
- [1.0.1 > 2.0.0](https://github.com/ulrack/web/compare/1.0.1...2.0.0)
- [1.0.0 > 1.0.1](https://github.com/ulrack/web/compare/1.0.0...1.0.1)
