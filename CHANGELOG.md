# Change Log

## 0.4.0 - 2017-12-13

### Changed

* Updated `EmailBuilder::attach` to accept an `Attachment` object to support more than just `FileAttachment`

## 0.3.2 - 2017-12-13

### Fixed

* Corrected file name determination for `UrlAttachment`s and `ResourceAttachment`s

## 0.3.1 - 2017-12-12

### Added

* Added `UrlAttachment` and `ResourceAttachment`

## 0.3.0 - 2017-11-08

### Changed

#### General

* Added argument and return type hints
* Added strict types

#### Dependencies

* Support was dropped for 5.6 and 7.0. Project only supports 7.1+.

## 0.2.0 - 2017-08-02

### Added

* Added `fromRfc2822` and `fromString` functions to `Address` to assist in construction.
