# MirHamit/ACL


[![Latest Version on Packagist](https://img.shields.io/packagist/v/vendor_slug/package_slug.svg?style=flat-square)](https://packagist.org/packages/mirhamit/searchable)
[![Total Downloads](https://img.shields.io/packagist/dt/vendor_slug/package_slug.svg?style=flat-square)](https://packagist.org/packages/mirhamit/searchable)

---
A Minimal Laravel Search Package

## Installation


open terminal and cd to your project root folder

install laravel

Install this package with composer
```bash
composer require mirhamit/searchable
```

---
## Usage
Add HasPermission to your user model
in this example we used User model, you can use in any model
```php
use MirHamit\Searchable\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;
...
}
```

Get your search
In this example we used in route and searched a signle user
```php
Route::get('search', function () {
    return \App\Models\User::search('w1w', 0)->paginate(2);
    // return \App\Models\User::search($request->input(), 1)->paginate(2);
});
```
The second parameter of search accepts boolean
If you send 0 to second parameter, search will search with ``orWhere``

If you send 1 to second parameter, search will search with ``where``


---
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

---
## Security Vulnerabilities

Please review and check security vulnerabilities and report them in issues section.

---
## Credits

- [Həmid Musəvi](https://github.com/mirhamit)
- [All Contributors](../../contributors)

---
## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
