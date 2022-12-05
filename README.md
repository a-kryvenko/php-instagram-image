# php-instagram-image

PHP library for resizing images according to instagram requirements.

![tests workflow](https://github.com/a-kryvenko/php-instagram-image/actions/workflows/tests.yml/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/a-kryvenko/php-instagram-image/badge.svg?branch=master)](https://coveralls.io/github/a-kryvenko/php-instagram-image?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://stand-with-ukraine.pp.ua)

------

## Setup

Manually by cloning repository, or via composer:

```sh
$ composer require antey/instagram-image
```

## Requirements

- PHP version: >= 7.4;
- PHP extensions: gd.

## Dependencies

This package using [php-image-resize](https://github.com/gumlet/php-image-resize) and [php-image-slice](https://github.com/antey/php-image-slice)

## Usage

This package allow to resize image to any resolution, according
to instagram requirements or get optimal resolution for
post or gallery (description of features is below).

### Instagram resolutions

- Profile photo - 360x360 px;
- Stories - 1080x1920 px;
- Reels - 1080x1920 px;
- IGTV cover - 420x654 px;
- Square post - 1080x1080 px;
- Landscape post - 1080x564 px;
- Portrait post - 1080x1350 px;

### Resizing

Package allow to simple resize original image into one of instagram images,
using one of methods: `getProfile`, `getIgtvCover`, `getSinglePostSquare`,
`getSinglePostLandscape` and `getSinglePostPortrait`.

### Slicing

Different to simple resizing, instagram also allow to publish some multiple images.
It can be `Stories`, `Reels`, `Post` with several images. To create this types
of images, package provide methods, that resize and slice original image into a
pieces. List of this methods: `getStories`, `getReels`, `getGallerySquare`,
`getGalleryLandscape`, `getGalleryPortrait`.

### Optimal resizing

To simplify work with `Post`, package provide methods, that will automatically
find most reliable type (single image or gallery) and resolution (Square,
Landscape, Portrait) for given image and return path to resized image, or
paths of sliced pieces. It's `getSinglePostOptimal`, `getGalleryOptimal`,
`getPostOptimal`.

## Available features

### Resizing initialization

```php
use Antey\InstagramImage\InstagramImageResize;

$imageResize = new InstagramImageResize();
```

### Resizing simple images

For simple images (like a `Profile`, `Stories`, `Reels`, `IGTVCover`) resized
image (or images gallery) will be created by single specified method.

#### getProfile

```php
$imageResize->getProfile(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to profile resolution 
and return path to result image. If destination empty - will replace
original file.

#### getStories

```php
$imageResize->getStories(string $filename, string $path = ''): array;
```

Convert given image into jpeg, resize to stories resolution
and slice into several stories images, if it possible.
Return array of paths to result images. If destination empty - will store
result file near to original file.

#### getReels

```php
$imageResize->getReels(string $filename, string $path = ''): array;
```

Convert given image into jpeg, resize to Reels resolution
and slice into several reels images, if it possible.
Return array of paths to result images. If destination empty - will store
result file near to original file.

#### getIgtvCover

```php
$imageResize->getIgtvCover(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to IGTVCover resolution
and return path to result image. If destination empty - will replace
original file.

### Resizing post images

Different to simple images, `Post` resizing is tricky. Instagram allow
publishing post int three resolutions: 1080x1080, 1080x565, 1080x1350. Also,
there is availability to publish gallery of post images. So, to manipulate
post resizing, we need additional set of methods.

#### getSinglePostSquare

```php
$imageResize->getSinglePostSquare(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to square post resolution
and return path to result image. If destination empty - will replace
original file.

#### getSinglePostLandscape

```php
$imageResize->getSinglePostLandscape(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to landscape post resolution
and return path to result image. If destination empty - will replace
original file.

#### getSinglePostPortrait

```php
$imageResize->getSinglePostPortrait(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to portrait post resolution
and return path to result image. If destination empty - will replace
original file.

#### getSinglePostOptimal

```php
$imageResize->getSinglePostOptimal(string $filename, string $path = ''): string;
```

Convert given image into jpeg, resize to most conformity post resolution
and return path to result image. If destination empty - will replace
original file.

#### getGallerySquare

```php
$imageResize->getGallerySquare(string $filename, string $path = ''): array;
```

Convert given image into jpeg, slice to several images in square post resolution
and return paths to result images. If destination empty - will be stored ner to
original image.

#### getGalleryLandscape

```php
$imageResize->getGalleryLandscape(string $filename, string $path = ''): array;
```

Convert given image into jpeg, slice to several images in landscape post resolution
and return paths to result images. If destination empty - will be stored ner to
original image.

#### getGalleryPortrait

```php
$imageResize->getGalleryPortrait(string $filename, string $path = ''): array;
```

Convert given image into jpeg, slice to several images in portrait post resolution
and return paths to result images. If destination empty - will be stored ner to
original image.

#### getGalleryOptimal

```php
$imageResize->getGalleryOptimal(string $filename, string $path = ''): array;
```

Convert given image into jpeg, and slice to several images in most conformity
post resolution, then return path to result image.
If destination empty - will be stored ner to original image.

#### getOptimalPost

```php
$imageResize->getOptimalPost(string $filename, string $path = ''): array;
```

Convert given image into jpeg, and based on image resolution
just resize into optimal post resolution, or slice to several images in most conformity
post resolution, then return path to result image.
If destination empty - will be stored ner to original image.

---

