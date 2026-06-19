The system is developed using Laravel Framework.
Users can register and login to the platform. Authenticated users can create, update, delete and manage their shortened URLs.
When a visitor accesses a shortened URL, the request is handled by the Redirect Service. The system first checks Redis Cache for the original URL. If the URL is not found, it displays an error message.
Analytics data such as click count, browser information,  are recorded and displayed through the Analytics Dashboard.
Administrators can manage users, links, and monitor overall system usage through the Admin .



## Features

- User Registration/Login
- URL Shortening
- QR Code Generation
- Analytics 
- Admin Management
