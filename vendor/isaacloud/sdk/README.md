# Isaacloud SDK for PHP

The Isaacloud Scala SDK can be used to access the IsaaCloud API through PHP. The user can make any number of request calls to the API.

## Basics

This SDK can be used to connect to Isaacloud v1 REST API on api.isaacloud.com.
Main class in "isaacloud", which gives the possibility to connect to the public api. It has convenience methods for delete, get, post, put and patch methods. In future it will also contain a wrapper, which will offer all methods defined by isaacloud raml api.

## How to build
1. via Composer 

Install composer in your system

```bash
curl -s https://getcomposer.org/installer | php
```    
Create a ** composer.json ** 

```bash
touch composer.json
```    
fill it

```javascript
{
  "require": {
      "isaacloud/sdk": "0.0.3"
   }
}
```

Install!

```bash
php composer.phar install
```
    
Add autoloader in your main script
```php
require 'vendor/autoload.php';
```

## Making request calls

To make a simple request we first to specify the path to a resource using the *path* method, then declare the query parameters and lastly use a concrete REST method for acquiring the results.

```php
$isaac = new Isaacloud(array("clientId"=>YOUR_CLIENT_ID,"secret"=>YOUR_SECRET))
```

* get a list of users

```php
$limit = 11
$offset = 10

$result = $isaac->path("/cache/users")
                ->withFields("firstName","lastName")
                ->withPaginator($limit,$offset).get();
```
* get one user

```php
$result2 = $isaac->path("/cache/users/1")
                 ->withFields("firstName","lastName");
//or
$result3 = $isaac->path("/cache/users/{userId}")
                 ->withParameters(array("userId" =>1))
                 ->withFields("firstName","lastName");
```


The methods that start with word *with* are responsible for narrowing the result set. Each one changes the way the result will be returned by the method. You can combine multiple in order to have a desired effect.
In methods without the concrete traits Here we give a list of those methods:

* withFields - narrows the result set to contain only json fields, which are in the list of the method

    ```php
    $isaac->path("/cache/users")->withFields("firstName","lastName");  
    //returns only the first and last names of a user
    ```

* withPaginator - limits the number and defines the offset for the results, works only with list resources

    ```php
    $isaac->path("/cache/users")->withPaginator(10,5);  
    //returns 5 elements starting with the tenth
    ```

* withGroups - returns only the the resources with groups' ids in the list

    ```php
    $isaac->path("/cache/users")->withGroups(1,2,3);  
    //returns only the users in groups 1 or 2 or 3
    ```

* withSegments - returns only the the resources with segments' ids in the list

    ```php
    $isaac->path("/cache/users")->withSegments(1,2,3);  
    //returns only the users in segments 1 or 2 or 3
    ```

* withOrder - declares the order in which results in list resources should be returned

    ```php
    $isaac->path("/cache/users")->withOrder(array("firstName"=>"ASC","lastName"=>"DESC"));  
    //returns results sorted first by firstName ascending and then by lastName descending
    ```

* withCreatedAt - returns only the resources created between certain dates given as milliseconds. In case one of the parameters is None, the limit is not set.

    ```php
    $isaac->path("/cache/users")->withCreatedAt(1398157190540,Null);  
    //returns only the users created after Tue Apr 22 2014 8:59:50 AM
    ```

* withUpdatedAt - returns only the resources last updated between certain dates given as milliseconds. In case one of the parameters is None, the limit is not set.

    ```php
    $isaac->path("/cache/users")->withUpdatedAt(Null, 1398157190540);  
    //returns only the users last updated before Tue Apr 22 2014 8:59:50 AM
    ```

* withCustom - shows custom fields in the result

    ```php
    $isaac->path("/admin/users")->withCustom();  
    //returns all custom fields
    ```

* withCustoms - declares exactly which fields in custom fields should be shown.

    ```php
    $isaac->path("/admin/users")->withCustoms("shoeSize","weight");  
    //returns only custom fields with keys shoeSize and weight
    ```

* withQuery - performs a search with concrete field values.
    ```php
    $isaac->path("/admin/users")->withQuery(array("wonGames.amount" => 12, "wonGames.game" => 1));  
    //returns only users with game 1 won 12 times
     ```

* withQueryParameters - add query parameters manually.
    ```php
    
    $isaac->path("/cache/users").withQueryParameters(array("fields" => array("firstName","lastName"))  
    //returns only the first and last names of a user
     ```



If no detailed exception handling is required, you can simply catch the basic IsaacloudConnectionException. If more detailed information about the error is needed, however, there are several exception classes that extend the general IsaacloudConnectionException case class. Catch the detailed exception before the general one. Check isaacloud package for more details on available exceptions. Each of these exceptions can return an internal error code and message through the *internalCode* and *message* methods. Reviewing these values will give you further insight on what went wrong.

For detailed information about the possible uri calls, available query parameters and request methods please see our documentation:
https://isaacloud.com/documentation
