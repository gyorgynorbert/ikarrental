# IkarRental

IkarRental is a web-based application designed to facilitate the rental of vehicles, specifically focusing on Ikarus buses. The platform allows users to register, browse available vehicles, and manage their rental activities.

## Features

- **User Authentication:** Secure user registration and login system.
- **Vehicle Listings:** Browse and view details of available Ikarus buses for rent.
- **Profile Management:** Users can view and edit their personal profiles.
- **Session Management:** Securely handle user sessions with login and logout functionalities.

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/gyorgynorbert/ikarrental.git
   ```

2. **Navigate to the Project Directory:**
   ```bash
   cd ikarrental
   ```

3. **Set Up the Environment:**
   - Ensure you have a web server with PHP support (e.g., Apache) and a MySQL database.
   - Configure the database connection settings in the relevant PHP files.

4. **Deploy the Application:**
   - Place the project files in your web server's root directory.
   - Import the provided SQL schema to set up the necessary database tables.

5. **Access the Application:**
   - Open your web browser and navigate to the application's URL to start using IkarRental.

## Usage

- **Register an Account:** Create a new user account to access the platform's features.
- **Browse Vehicles:** View the list of available Ikarus buses for rent.
- **Manage Profile:** Update your personal information and view rental history.
- **Logout:** Securely end your session when finished.

## Project Structure

- `assets/`: Contains images, stylesheets, and other static resources.
- `car.php`: Displays detailed information about a specific vehicle.
- `index.php`: The main landing page showcasing available vehicles.
- `login.php`: Handles user authentication and login processes.
- `logout.php`: Manages user session termination.
- `profile.php`: Displays and allows editing of user profile information.
- `register.php`: Facilitates new user registration.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.

