# PropertyHub

PropertyHub is a dynamic web application designed to streamline property management. Built using SQL, HTML, CSS, and PHP, the platform allows users to list properties, manage user data, and facilitate property renting and selling. It also features a user-friendly dashboard for easy navigation and control.

---

## Features

### Property Listings
- Add, edit, and manage property details.
- View properties with detailed descriptions and images.
- Filter and search for properties based on preferences.

### User Management
- Secure user registration and login system.
- Store and manage user data in a robust SQL database.

### Rent or Sell Options
- Users can list properties for rent or sale.
- Buyers and renters can contact property owners directly.

### User Dashboard
- Personalized dashboard for users to manage their activities.
- Track listed properties, received inquiries, and more.

---

## Technology Stack

### Frontend
- **HTML**: For structuring the web pages.
- **CSS**: For styling and layout design.

### Backend
- **PHP**: For server-side scripting and application logic.

### Database
- **SQL**: For storing and managing application data.

---

## Setup Instructions

### Prerequisites
- A local server environment (e.g., XAMPP, WAMP, or MAMP).
- Basic understanding of PHP and SQL.

### Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/propertyhub.git
   ```

2. **Move Files**
   Place the project files in the web server's root directory (e.g., `htdocs` for XAMPP).

3. **Set Up the Database**
   - Open `phpMyAdmin`.
   - Create a new database (e.g., `propertyhub`).
   - Import the SQL file provided in the project (`database/propertyhub.sql`).

4. **Configure Database Connection**
   - Open the `config.php` file.
   - Update the database credentials:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "propertyhub";
     ```

5. **Run the Application**
   - Start your local server.
   - Open the browser and go to `http://localhost/propertyhub`.

---

## Usage

### For Users
1. Register or log in to access the platform.
2. Add new properties for rent or sale.
3. Manage property details and inquiries via the dashboard.

### For Administrators
1. Monitor and manage user activities.
2. Oversee property listings and database records.

---

## Future Enhancements
- Add advanced filtering options for property search.
- Implement messaging functionality between users.
- Integrate payment gateways for secure transactions.
- Enhance mobile responsiveness.

---

## License
This project is licensed under the [MIT License](LICENSE).

---

## Contact
For questions or support, contact:
- **Name**: Divyana
- **Email**: [your-email@example.com](mailto:your-email@example.com)
- **GitHub**: [your-username](https://github.com/your-username)

