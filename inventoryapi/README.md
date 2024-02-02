
I detta projekt skapas en fullständig REST-webbtjänst med CRUD-funktionalitet med Laravel som backend-ramverk. Webbtjänsten lagrar information om produkter med sju fält: productname, SKU, unitsininventory, minstocklevel, categories_id, description, price samt image. Antalet varor i lager kan enkelt justeras från webbappen. Även en tabell för kategorier skapas. Funktioner för att logga in och registrera användare finns även i AuthControllern. 

Hur används REST-webbtjänsten?
För att använda REST-webbtjänsten måste man använda serverurl + endpoints. Dessa routes finns i api.php. Dessa är de sökvägar som finns. Det man gör är att man skriver url + exempelvis (/register). Detta gör att man lkan registrera användare. Här skickar man med värden för att controllern sedan lägger in de i databasen. 

Alla routes som finns:
//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('getUser', AuthController::class);
Route::post('/addProduct/{id}',[ ProductController::class, 'addProduct']);
Route::post('/updateImage/{id}',[ ProductController::class, 'updateImage']);
Route::get('/products/search/categories_id/{int}',[ ProductController::class, 'searchCategory']);
Route::get('/category/search/product/{int}',[ CategoryController::class, 'searchProduct']);

//Väg till produkter
Route::resource('products', ProductController::class);

//Väg till kategori
Route::resource('category', CategoryController::class);

//logga ut
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Endpoints:
/register
/login
/getUser
/addProduct/{id}
/updateImage/{id}
/products/search/categories_id/{int}
/category/search/product/{int}
/products
/category
/logout
