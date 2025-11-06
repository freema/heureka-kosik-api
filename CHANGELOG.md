# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-01-04

### Added
- Modern PHP 8.1+ support with strict type declarations
- Full type hints and return type declarations for all methods
- PSR-4 autoloading
- PHPStan level 8 static analysis with strict rules
- PHP CS Fixer configuration for code quality
- PHPUnit configuration
- GitHub Actions CI workflow
- Comprehensive README with modern examples
- CHANGELOG.md

### Changed
- **BREAKING**: Minimum PHP version is now 8.1
- **BREAKING**: All Request classes moved to `Freema\HeurekaAPI\Request\` namespace
- **BREAKING**: All methods now require proper type hints (int instead of mixed)
- Modernized coding standards (PSR-12 compliant)
- Replaced classmap autoloading with PSR-4
- Updated Nette Bridge extension to modern standards
- Improved error handling with proper null types
- Modern date formatting in PutPaymentStatus (accepts DateTime|string)

### Fixed
- **CRITICAL BUG**: Fixed PutOrderStatus::setExpectDeliver() setting wrong parameter
  - Was setting `transport[note]` instead of `transport[expect_deliver]`
- Fixed incorrect comparison operator in PostOrderInvoice::setInvoiceFile()
  - Was `!$ext == '.pdf'` now `$ext !== '.pdf'`
- Fixed missing break statement in Container::setRequestMethod() switch

### Removed
- **BREAKING**: Removed manual loader.php (use Composer autoload instead)
- Removed underscore prefixes from private/protected properties
- Removed snake_case method naming
- Removed PHP 5.x compatibility code

## [1.x] - Legacy

### Legacy version
- PHP 5.3+ support
- Basic Heureka Košík API functionality
