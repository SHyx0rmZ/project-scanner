project-scanner
===============

[![Latest Stable Version](http://poser.services.witches.io/ppokatilo/project-scanner/v/stable.svg)](https://packagist.org/packages/ppokatilo/services-loader)
[![Total Downloads](http://poser.services.witches.io/ppokatilo/project-scanner/downloads.svg)](https://packagist.org/packages/ppokatilo/services-loader)
[![Latest Unstable Version](http://poser.services.witches.io/ppokatilo/project-scanner/v/unstable.svg)](https://packagist.org/packages/ppokatilo/services-loader)
[![License](http://poser.services.witches.io/ppokatilo/project-scanner/license.svg)](https://packagist.org/packages/ppokatilo/services-loader)

Scan directories (for example vendor/, src/) for stuff.

## How to use

Use ProjectScanner to find classes in directories.

```php
public function doStuff()
{
  $projectScanner = new ProjectScanner();
  
  foreach ($projectScanner->findInDirectory('Entity') as $scanResult) {
    echo $scanResult->getReference() . PHP_EOL;
    echo $scanResult->getFileInfo()->getRelativePath() . PHP_EOL;
  }
}
```

Output:

```
You\YourLibrary\Entity\Foo
src/You/YourLibrary/Entity/Foo.php
Me\MyLibrary\Entity\Foo\Bar
vendor/me/my-library/src/Entity/Foo/Bar.php
```
