# Qualification Exam for PurpleBug Inc.

Designed according to the design specifications given:
- Laravel for backend, Vue.js and Inertia for the SPA frontend
- Database accessed via query builders and Eloquent ORM
- API endpoint authorization with Laravel Sanctum

Additional components:
- UI built with components from shadcn/vue, which in turn is built upon Reka UI
- API endpoints accessed internally via Axios

### Implemented
- User session timeout after 30 minutes of inactivity
- Separate redirects for guests and admins
- Admins can perform CRUD operations on users and products
- Admins can update orders
- Guests can see products on the home page
- Adding to cart redirects to login if unauthenticated
- Adding an existing product to cart will add quantity instead of duplicating
- Home page with products is paginated
- Guests can search and sort the results on the home page
- Product and cart listings are fetched via API endpoints
- Product listing can be fetched by unauthenticated users
- Cart listing can only by fetched by authenticated users

### Unimplimented/Limitations
- Test cases are incomplete
- Checked out orders can be duplicated
- Product stocks are not automatically subtracted when checking out

## Building and Running
Build the application with:
```
npm run build
```
Then serve with:
```
php artisan serve
```
The application can then be accessed via http://localhost:8000 or http://127.0.0.1:8000

Otherwise, for development purposes run:
```
composer run dev
```
---
## Answers for Multiple Choice
1. What command is used to create a new Laravel project?
```
b) composer create-project laravel/laravel project-name
```

2. Which file contains the database connection settings in Laravel?
```
c) database.php
```

3. What is the purpose of Laravel Eloquent?
```
c) It is an ORM (Object-Relational Mapper) for database interactions.
```

4. Which command is used to create a new model in Laravel?
```
b) php artisan make:model
```

5. Which of the following is the correct way to define a route in Laravel?
```
b) Route::get('/home', [HomeController::class, 'index']);
```

6. What is the default templating engine used in Laravel?
```
b) Blade
```

7. Which command is used to run database migrations?
```
b) php artisan migrate
```

8. What is middleware in Laravel used for?
```
b) To modify HTTP requests before they reach controllers
```

9. Which command is used to start a Laravel development server?
```
b) php artisan serve
```

10. What is the purpose of Laravel Sanctum?
```
b) To provide lightweight API authentication
```

`True`: Laravel supports API routes using api.php instead of web.php.

`True`: Laravel’s hasMany relationship defines a one-to-many relationship.

11. What command is used to generate a Laravel factory?
```
a) php artisan make:factory
```

12. Which of the following is used to validate form requests in Laravel?
```
a) $request->validate([...])
```

13. Which command creates a controller in Laravel?
```
b) php artisan make:controller ControllerName
```

14. What is Vue.js primarily used for?
```
c) Building user interfaces and single-page applications
```

15. Which command is used to create a new Vue.js project with Vite?
```
b) npm init vue@latest my-project
```

16. What directive is used to bind data to an element in Vue.js?
```
c) v-bind
```

17. What is the correct syntax for rendering a variable inside Vue.js templates?
```
a) {{ variable }}
```

18. Which Vue lifecycle hook is called after the component is mounted?
```
c) mounted()
```

19. What Vue directive is used for conditional rendering?
```
d) v-if
```

20. What is the Vue Router used for?
```
c) Enabling navigation between different components/pages
```

21. Which of the following is used to create two-way data binding in Vue?
```
b) v-model
```

22. How do you listen for an event in Vue.js?
```
a) @click="methodName"
```

23. What is Vuex used for in Vue.js applications?
```
a) Managing application state
```

24. What is the purpose of watch in Vue.js?
```
a) To execute code when a variable changes
```

25. Which package is used to integrate Vue.js with Laravel 11?
```
c) inertia.js
```
