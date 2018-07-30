# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project attempts to follow [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased

### Changed

* 	Allow subject to be empty/null on templated emails ([#22](https://github.com/quartzy/php-email/pull/22))

## 0.5.1 - 2018-02-25

### Added

* Created helper function on `Attachment` to get the RFC content type header.

### Changed

* Allowed null charset on attachments and changed the default to null.

## 0.5.0 - 2018-02-25

### Added

* Support for custom headers on emails.
* Add character set header to text and HTML content.
* Add common headers to attachments: content type, character set, name, content ID.
* Add embedded (inline) attachments to emails.
* Added fluent `addText` and `addHtml` methods on `SimpleContent`

### Changed

* Now using `Message` objects instead of string for `SimpleContent`'s text and HTML properties.

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
