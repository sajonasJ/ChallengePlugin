# Support Time Tracker Plugin for Moodle

[![Moodle Version](https://img.shields.io/badge/Moodle-4.1.14+-blue.svg)](https://moodle.org)
A Moodle plugin for administrators to track and manage support time data by site, support type, and levels. This plugin integrates seamlessly into Moodle's admin interface, offering easy configuration and reporting capabilities.

Hosted on GitHub: [Support Time Tracker Plugin](https://github.com/sajonasJ/ChallengePlugin)

---

## Features

- **Pre-filled Name Field**: Automatically populates with the logged-in user's name.
- **Dynamic Dropdowns**: Site names are configurable via the plugin settings.
- **Date Picker**: Intuitive date selection using a modern calendar interface.
- **Validation**: Comprehensive form validation ensures data integrity.
- **Total Support Time Calculation**: Automatically calculates the total support time based on user inputs.
- **Database Integration**: Stores data securely in the Moodle database.
- **Duplicate Record Prevention**: Ensures no duplicate entries for the same user, date, and site.
- **Admin-Only Access**: Only administrators can access and use the plugin.
- **Responsive Design**: Optimized for desktop and mobile screens.
- **Keyboard Navigation**: Fully accessible form elements.

---

### Installation

#### 1. **Download and Place the Plugin**

- **Step 1**: Navigate to your Moodle installation directory.

  - This is the directory where Moodle is installed, typically containing folders like `admin`, `auth`, `course`, and `mod`.

- **Step 2**: Locate or create the `local` directory.

  - Inside your Moodle installation, there should be a directory named `local`.
  - If it doesn’t exist, create a new folder and name it `local`.

- **Step 3**: Add the plugin.

  - Download the plugin as a `.zip` or `.tar.gz` file from your source (e.g., GitHub, shared link, etc.).
  - Extract the plugin into the `local` directory.
  - Ensure the extracted folder is named `challenge` (or the plugin's defined name). The path should now look like this:

    ````
    moodle/
    ├── local/
    │ ├── challenge/
    │ ├── index.php

        ```
    ````

#### 2. **Set File Permissions**

- Ensure the `challenge` folder and its contents have appropriate permissions:
  - For Linux-based servers, set the folder permissions to allow the web server to read the files:
    ```bash
    chmod -R 755 moodle/local/challenge
    ```

#### 3. **Complete Plugin Installation via Moodle**

- Log in as an admin to your Moodle site.
- Navigate to **Site Administration > Notifications**.
- Moodle will detect the new plugin and guide you through the installation process.
- Verify that there are no errors during the installation.

---

## Usage

### Accessing the Plugin Page

1. Navigate to the plugin directly via the following URL:  
   [http://localhost/local/challenge/index.php](http://localhost/local/challenge/index.php)

2. Fill in the form:
   - The **Name** field will be pre-filled with the logged-in user's name.
   - Select a **Site** from the dropdown.
   - Pick a **Date** using the calendar picker.
   - Enter values for **Email Support** and **Phone Support** at each level.
3. Submit the form.
4. Confirmation will display once data is successfully stored.

---

## Configuration

### Accessing the Plugin Settings Page

To configure site names for the dropdown:

1. Navigate to the settings page via the **Site Administration** menu:  
   **Site Administration > Plugins > Local Plugins > Challenge**.

2. - **Database Table**:

- The plugin uses the `mdl_challenge_support_time` table to store records. The table structure includes:
  - `name`: Name of the user (validated to ensure 3-20 characters and specific formats).
  - `date`: Date of the entry.
  - `site`: Selected site.
  - `email_level[1-4]`: Email support levels.
  - `phone_level[1-4]`: Phone support levels.
  - `total_support_time`: Calculated total support time.

---

## Validation Rules

- **Name**:
  - Minimum 3 characters, maximum 20 characters.
  - Allowed characters: letters, spaces, hyphens, and apostrophes.
- **Date**:
  - Must be a valid date format.
- **Site Name**:
  - Must match one of the configured site names.
- **Support Levels**:
  - Non-negative integers only.
  - Total support time must be greater than zero.
- **Duplicate Records**:
  - No duplicate records are allowed for the same user, date, and site.

---

## Technical Details

- **Frontend**:
  - HTML5 form with validation and CSS for styling.
  - Uses JavaScript for dynamic total time calculation.
- **Backend**:
  - PHP for data processing and validation.
  - Moodle's `get_config` function for dynamic settings.
- **Database**:
  - Fully integrated with Moodle's database structure.
  - Ensures compatibility with Moodle's versioning and upgrade system.

---

## Accessibility

- Full keyboard navigation for seamless accessibility.
- Responsive design for use on all devices.

---

## Contributing

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Submit a pull request with detailed explanations.

---

## License

This plugin is licensed under the [GNU GPL v3](https://www.gnu.org/licenses/gpl-3.0.en.html).

---

## Author

Developed by Jonas Sajonas.
