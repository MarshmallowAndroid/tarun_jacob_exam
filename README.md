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
