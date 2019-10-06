atomic.center SMS wrapper for laravel/lumen


--- 
**Install package:**

```
composer require ognistyi/atompark
```
 
 
 ---
 **Register AtomParkServiceProvider**
 
 Lumen:
 In your bootstrap/app.php add this:
 
 ```
 // registering facade
 $app->withFacades(true, [
     \Ognistyi\AtomPark\Facade\AtomParkFacade::class => 'AtomPark',
 ]); 
 
 //...
 
 // registering service
 $app->register(\Ognistyi\AtomPark\ServiceProvider\AtomParkServiceProvider::class);
 
 ```
 
 **Publish assets:**
 ```
 php artisan vendor:publish --provider="Ognistyi\AtomPark\ServiceProvider\AtomParkServiceProvider"
 ```
 
 