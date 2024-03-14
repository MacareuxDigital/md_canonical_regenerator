# Macareux Canonical Regenerator

![Version](https://img.shields.io/badge/version-0.0.1-brightgreen.svg)
![Concrete CMS](https://img.shields.io/badge/concrete%20cms-8.x%20%7C%209.x-orange.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Macareux Canonical Regenerator is a Concrete CMS package that provides a command-line interface to regenerate canonical URLs under a specific page path.

## Installation

### Requirements

- Concrete CMS 8.x or 9.x

### Installation Steps

1. Download the latest release ZIP file from the [Releases](https://github.com/macareuxdigital/md_canonical_regenerator/releases) page.
2. Extract the ZIP file.
3. Move the `md_canonical_regenerator` directory to your Concrete CMS `packages` directory.
4. Install the package through the Concrete CMS Dashboard.

## Usage

### Regenerate Canonical URLs

To regenerate canonical URLs under a specific page path, use the following command:

```bash
./concrete/bin/concrete5 md:canonical:regenerate --page-path=/your-page-path
```
