# Microsoft Cognitive Face Service APIs Client Library for PHP #

The cloud-based Face API provides developers with access to advanced face algorithms. Microsoft Face algorithms enable face attribute detection and face recognition

## Requirements ##
* [PHP 7.1.0 or higher](http://www.php.net/)

## Installation ##

You can use **Composer** or simply **Download the Release**

### Composer

The preferred method is via [composer](https://getcomposer.org). Follow the
[installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have
composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer require subsan/subsan/microsoft-cognitive-face-php-api-client:"^1.0"
```

Finally, be sure to include the autoloader:

```php
require_once '/path/to/your-project/vendor/autoload.php';
```

### Download the Release

If you abhor using composer, you can download the package in its entirety. The [Releases](https://github.com/subsan/microsoft-cognitive-face-php-api-client/releases) page lists all stable versions. Download any file
with the name `microsoft-cognitive-face-php-api-client-[RELEASE_NAME].zip` for a package including this library and its dependencies.

Uncompress the zip file you download, and include the autoloader in your project:

```php
require_once '/path/to/microsoft-cognitive-face-php-api-client/vendor/autoload.php';
```

## Examples ##

### Basic Example ###

```php
// include your composer dependencies
require_once 'vendor/autoload.php';

$client = new \Subsan\MicrosoftCognitiveFace\Client('YOUR_APP_KEY', 'YOUR_REGION');
$faces  = $client->face()->detectFacesFromImg('URL_IMAGE_WITH_FACES');

var_dump($faces);
```

### Create person group and add new persons for all faces in image ###

```php
require_once 'vendor/autoload.php';

$client = new \Subsan\MicrosoftCognitiveFace\Client('YOUR_APP_KEY', 'YOUR_REGION');

// create new person group
$newPersonGroupId = uniqid();
$client->personGroup($newPersonGroupId)->create(
    new \Subsan\MicrosoftCognitiveFace\Entity\PersonGroup(
        null, 
        'Group Name',
        'Additional info'
    )
);

// get faces from image
$url   = 'URL_IMAGE_WITH_FACES';
$faces = $client->face()->detectFacesFromImg($url);

$userNumber = 1;
foreach ($faces as $face) {
    $personFaceRectangle = (new \Subsan\MicrosoftCognitiveFace\Entity\FaceRectangle())->import($face->faceRectangle);

    // create person
    $person = $client->personGroup($newPersonGroupId)->person()->create(
        new \Subsan\MicrosoftCognitiveFace\Entity\Person(
            null, 
            'User '.$userNumber
        )
    );

    // add image to person
    $client->personGroup($newPersonGroupId)->person($person->getPersonId())->addFace($url,'test',$personFaceRectangle);

    $userNumber++;
}
```

### Training person group ###
```php
require_once 'vendor/autoload.php';

$client = new \Subsan\MicrosoftCognitiveFace\Client('YOUR_APP_KEY', 'YOUR_REGION');

// in previous example $newPersonGroupId
$personGroupId = 'ID_OF_CREATED_PERSON_GROUP';

// train group
$client->personGroup()->train($personGroupId);

// get train status
var_dump($client->personGroup()->getTrainStatus($personGroupId));
```

### Identity all faces in image ###
```php
require_once 'vendor/autoload.php';

$client = new \Subsan\MicrosoftCognitiveFace\Client('YOUR_APP_KEY', 'YOUR_REGION');

// in previous example $newPersonGroupId
$personGroupId = 'ID_OF_CREATED_PERSON_GROUP';

// get faces from image
$url   = 'URL_IMAGE_WITH_FACES';
$faces = $client->face()->detectFacesFromImg($url);

// prepare array of faces ids
$faceIds = array();
foreach ($faces as $face) {
    $faceIds[] = $face->faceId;
}

// identify all faces
print_r($client->face()->identify($faceIds, $personGroupId));
```