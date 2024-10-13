<h1>Project Description:</h1>

<p>This Laravel-based E-Commerce platform is designed to provide a seamless shopping experience for customers while offering a powerful management dashboard for administrators. The platform features a robust API that enables integration with mobile applications, web services, or third-party platforms, ensuring scalability and flexibility to meet diverse e-commerce needs. With a modern admin dashboard, administrators can efficiently manage various entities, including products, orders, users, and roles, along with advanced functionalities such as payments and permissions. While the front-end is currently in development, the platform's back-end is fully operational, ready to support both mobile and web applications.</p>

<h2>Technologies Used</h2>
<ul>
    <li><strong>Laravel:</strong> A powerful PHP framework used for building the back-end, offering robust features for routing, authentication, and database management.</li>
    <li><strong>MySQL:</strong> A reliable relational database management system used to store and manage the application's data.</li>
    <li><strong>Laravel Breeze:</strong> A simple and minimalistic package for authentication scaffolding, streamlining user registration and login processes.</li>
    <li><strong>API Development:</strong> RESTful APIs are implemented for seamless integration with mobile applications and third-party services, ensuring smooth data exchange.</li>
    <li><strong>Bootstrap:</strong> A responsive front-end framework utilized for designing the admin dashboard, providing a clean and user-friendly interface.</li>
    <li><strong>Chart.js:</strong> A JavaScript library used for creating interactive charts and graphs in the admin dashboard to visualize data insights effectively.</li>
    <li><strong>Blade Templates:</strong> Laravel's templating engine used to create dynamic views, ensuring a consistent and maintainable user interface across the application.</li>
    <li><strong>GitHub:</strong> Version control and collaboration platform for source code management and project tracking.</li>
</ul>

<h2>How to Install the Project</h2>
<ol>
    <li>Clone the repository to your local machine:
        <pre><code>git clone https://github.com/MansourTarekMansour/E_Commerce_BackEnd.git</code></pre>
    </li>
    <li>Navigate to the project directory:
        <pre><code>cd E_Commerce_BackEnd</code></pre>
    </li>
    <li>Install the required dependencies using Composer:
        <pre><code>composer install</code></pre>
    </li>
    <li>Copy the `.env.example` file to `.env` and update your environment variables (database credentials, app key, etc.):
        <pre><code>cp .env.example .env</code></pre>
    </li>
    <li>Generate the application key:
        <pre><code>php artisan key:generate</code></pre>
    </li>
    <li>Migrate the database:
        <pre><code>php artisan migrate</code></pre>
    </li>
    <li>Run the development server:
        <pre><code>php artisan serve</code></pre>
        The application will be accessible at <strong>http://localhost:8000</strong>.
    </li>
</ol>

<h2>Postman Collection</h2>

<p>This repository contains a Postman collection for testing the API.</p>

<h3>How to Import</h3>
<ol>
    <li>Open Postman.</li>
    <li>Click on the "Import" button.</li>
    <li>Select the exported <code>E-Commerce.postman_collection.json</code> file from this repository.</li>
    <li>Click "Import" to load the collection.</li>
</ol>
