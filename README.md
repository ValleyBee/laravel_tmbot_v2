<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


### Dependency installed in this 6-vite course
- 1 [protonemedia / laravel x-form-components](https://github.com/protonemedia/laravel-form-components).
- 2 [bootstrap@5.2.3](https://techvblogs.com/blog/how-to-install-bootstrap-5-in-laravel-9-with-vite).
- 2.1 [bootstrap@5.2.3](https://stackoverflow.com/questions/74422287/how-to-install-bootstrap-5-on-laravel-9-with-vite).
- 3 [Laravel Lang Ru](https://github.com/Laravel-Lang/lang/blob/main/locales/ru/php-inline.json)
- 4 [npm list]
6-vite@1.0.0 /home/admin/course/6-vite
├── @popperjs/core@2.11.7
├── anymatch@3.1.3
├── asynckit@0.4.0
├── axios@1.4.0
├── binary-extensions@2.2.0
├── bootstrap@5.2.3
├── braces@3.0.2
├── chokidar@3.5.3
├── combined-stream@1.0.8
├── delayed-stream@1.0.0
├── esbuild@0.17.18
├── fill-range@7.0.1
├── follow-redirects@1.15.2
├── form-data@4.0.0
├── glob-parent@5.1.2
├── immutable@4.3.0
├── is-binary-path@2.1.0
├── is-extglob@2.1.1
├── is-glob@4.0.3
├── is-number@7.0.0
├── laravel-vite-plugin@0.7.4
├── mime-db@1.52.0
├── mime-types@2.1.35
├── nanoid@3.3.6
├── normalize-path@3.0.0
├── picocolors@1.0.0
├── picomatch@2.3.1
├── postcss@8.4.23
├── proxy-from-env@1.1.0
├── readdirp@3.6.0
├── rollup@3.21.5
├── sass@1.62.1
├── source-map-js@1.0.2
├── to-regex-range@5.0.1
├── vite-plugin-full-reload@1.0.5
└── vite@4.3.5


### MADE SOME SETTINGS AND CHANGINGS IN THIS PROJECT 
- 1,2 [VITE ND JS ] 
      - add @vite(['resources/css/app.css', 'resources/js/app.js'])  instead of
       <script src="{{asset('js/app.js')}}"></script> if error js/app.js file not found 

- 3 [php artisan lang:publish](https://laravel.com/docs/10.x/localization) it will creat Directories lang\en
    - manual installation LANG, command
    - add a dir 'ru' put a files with name validation.php if you need only for validation reason 
    - replace 'locale' => 'en' in config/app.php  
    - replace TIME  'timezone' => 'Europe/Kiev'
- 5 [Form Request Validation](https://laravel.com/docs/10.x/validation#creating-form-requests)
      For more complex validation scenarios, you may wish to create a "form request"
    - command php artisan make:request Posts/Save   it will creat Directories 
    - then add in App\Http\Requests\Posts\Save.php your rules
            'content' => 'required|min:8|max:512',
            'title' => 'required|min:3',
            'category_id' => 'required'
      
    - then add to Controller use App\Http\Requests\Posts\Save as SaveRequest;
    - then use in Controller
      public function update(SaveRequest $request, string $id)
      {
      $validated = $request->validated();
      }
- 6  [class RouteServiceProvider]() add some function to help Route accepts only digits in id
     - use Route::resource('posts',PostController::class)->parameters(['post'=> 'id']);
     - add function 
         protected function configurePatterns()
         {
          Route::pattern('id', '^[1-9]+\d*$');
         }
- 7 [Enum Status]()
     - Enum Status : int {
       case DRAFT = 0;
       case APPROVED = 5;
       case REJECTED = 10;
        }
     - helps to hide not approved posts from users or redirect to 404 
           if ($post->status !== PostStatus::APPROVED)  {
               return redirect()->route('posts.index');
           }
- 8 [CASTING]() we can make own logic how to show data    
     - Example: from db table column 'option' cast from json to array
        protected $casts = 
        'status' => Status::class,
        'option' => 'array'
        ;
## Laravel Sponsors


### Premium Partners

1. change name of columns: botuser_id and user_id
2.
