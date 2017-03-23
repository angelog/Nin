# What is Nin?
Nin is a minimalistic PHP framework based on some of the ideas of Yii 1 and 2. It stands for "No It's Not", a play on Yii's "Yes It Is".

# How does it work?
By relying on PHP 5.4 features (HHVM also works), we can achieve some of the effects of Yii 2 while keeping the integrity of some of Yii 1's well-designed features.

Nin uses an MVC system, where `Model` and `Controller` are the key classes, and views are included PHP files.

# Quick start
You can use the Nin CLI interface with `nfc.php`. It allows you to create a simple skeleton website, with a default layout using [Foundation](http://foundation.zurb.com/).

```
$ git clone https://github.com/codecat/Nin.git
$ cd Nin
$ ./nfc.php create /var/www/html
```

# Using Composer
Quickly get started with Nin by installing the dependency via Composer. You can find the package [on Packagist](https://packagist.org/packages/codecat/nin). Install it by running:

```
$ composer require angelog/nin
$ cp vendor/angelog/nin/.htaccess .
```

Then create `index.php`:

```PHP
<?php
include('vendor/angelog/nin/nf.php');
nf_begin(__DIR__);
```

**Note:** For Nginx, you do not have to copy the `.htaccess` file. Instead, copy the contents inside of `nginx.conf`, and paste them inside the `server { }` block. You should also pass `no_htaccess` in `nf_begin`, like so:

```PHP
nf_begin(__DIR__, array(
  'no_htaccess' => true
));
```

# A very basic example
Let's say you own `example.com` and you want to put a Nin site on there. Just clone Nin anywhere on the server, and create an `index.php` with the following lines:

```PHP
<?php
include('/var/www_nin/nf.php');
nf_begin(__DIR__);
```

And copy over the default `.htaccess` file from the Nin repository. Visiting `example.com` should now give an error, since you didn't create any controllers yet:

```
nf error: Controller does not exist (Details: "/var/www/html/controllers/index.php")
```

By default, Nin will use `index/index` as a standard route. Routing works as `controller/action`. What this means, is that you could create `controllers/foo.php`, and put this code in:

```PHP
<?php
class FooController extends Controller
{
  public function actionBar()
  {
    echo 'Hey!';
  }
}
```

Navigating to `example.com/foo/bar` will now echo `Hey!`. So, to handle the default case of `index/index`, create `controllers/index.php`, make the class `IndexController`, and add the `actionIndex()` function.

You can also do the following inside of an action:

```PHP
$this->render('foo');
```

This will render the `foo` view, located at `views/controller/view.php`. So if the above line was in `IndexController`, the view would be located at `views/index/foo.php`.

You can also pass parameters to the `render()` function, like so:

```PHP
$this->render('foo', array(
  'bar' => 'hello ',
  'foobar' => 'world'
));
```

Your view can then use these parameters as if the keys in the array were PHP variables:

```
<p>The controller says: <b><?= $bar . $foobar ?></b></p>
```

If you create a layout file at `views/layout.php`, you can use that as a wrapper for your views. It will expose the `$content` variable for the rendered view. It could for example look like this:

```
<!doctype html>
<html>
  <head>
    <title>My website</title>
  </head>

  <body>
    <h1>My website</h1>
    <div class="content">
      <?= $content ?>
    </div>
  </body>
</html>
```
