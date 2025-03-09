
# Assignment Backend

Assignment Test Api development Using laravel.

## Technologies Used
Laravel, Sanctum, Socialite (Google Auth).

- **Database**: MySQL
- **Authentication**: JWT Tokens or Laravel Sanctum for API authentication.
## Installation
1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/project-name.git
    cd project-name
    ```
2. Install dependencies:
    ```bash
    composer install
    ```
3. Set up environment variables:
    - Copy `.env.example` to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update `.env` file with your database, 
    - **GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET.

4. Generate application key:
    ```bash
    php artisan key:generate
    ```

5. Attach database zipped file with email.
    ```
    or php artisan migrate
    ```

6. Serve the Laravel app:
    ```bash
    php artisan serve
    ```
    This will start the backend on `http://localhost:8000`.
## Usage
Users can register and log in using email/password or social login via Google.
