# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.0.1-alpha.3] - 2019-09-18
### Added
- Title filed in general settings section
- Toast notifications `Timoneiro::pushNotifications`
- Delete functionality
- package auto discovery

### Fixed
- Issue where settings where not being saved when there where multiple fields #16

## [0.0.1-alpha.1] - 2019-09-17
### Added
- authorization system
- ability to manage users and roles
- command to create admin user `php artisan timoneiro:admin --create your@email.com`
- release helper yarn command (`yarn release -V` for more info)
- ability to browse, create and update models
- Media manager
- file input handler

### Changed
- Login screen design
