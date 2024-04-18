

make a api for user and products using repository pattern 


Technologies Used

    Laravel
    MySQL

Setup Instructions

    Clone the repository: https://github.com/abdulkareemh/repository-design-pattern-test.git

   

    git clone 

Navigate to the project directory:



    cd project-directory

Install dependencies:



    composer install

Create a .env file by copying the .env.example file:



    cp .env.example .env

Generate an application key:



    php artisan key:generate

Configure your database settings in the .env file.

Run database migrations to create tables:



    php artisan migrate 

Serve the application:



    php artisan serve

    Access the application in your browser at http://localhost:8000.

API Endpoints

    Login: POST /api/v1/login
    Registration: POST /api/v1/register
    logout: POST api/v1/logout
    Get All Users: GET /api/v1/users
    Get User by ID: GET /api/v1/users/{id}
    Create User: POST /api/v1/users
    Update User: PUT /api/v1/users/{id}
    Delete User: DELETE /api/v1/users/{id}
    Get All Products: GET /api/v1/products
    Get Product by ID: GET /api/v1/products/{id}
    Create Product: POST /api/v1/products
    Update Product: PUT /api/v1/products/{id}
    Delete Product: DELETE /api/v1/products/{id}
    Update Product Image POST api/v1/product-update-image/{id}
    Update User Avatar POST api/v1/user-update-avatar/{id}


User Types and Pricing

    Normal users: Standard pricing
    Gold users: 20% discount on product prices
    Silver users: 10% discount on product prices


License

MIT License
