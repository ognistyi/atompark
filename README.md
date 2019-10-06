atomic.center SMS wrapper for laravel/lumen


--- 
**Install package:**

```
composer require ognistyi/atompark
```
 
 
 ---
 **Require AtomParkServiceProvider**
 
 Lumen
 In your bootstrap/app.php add this line:
 
 ```
 $app->register(Ognistyi\AtomPark\ServiceProvider\AtomParkServiceProvider::class);
 ```
 
 Laravel
 Open config/app.php and find the providers key:
 ```
    'providers' => array(
         // ...
         Ognistyi\AtomPark\ServiceProvider\AtomParkServiceProvider::class
     )
 ```
 
 **Publish assets:**
 ```
 php artisan vendor:publish --provider="Ognistyi\AtomPark\ServiceProvider\AtomParkServiceProvider"
 ```
 
 