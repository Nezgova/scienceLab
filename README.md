
# Lab Website

## Description

The Lab Website is a comprehensive platform developed using Laravel, designed for managing and presenting the research activities of the EMSI lab. It features a range of functionalities including article management, member interactions, and administrative tools.

## Features

- **Home Page**: Provides an introduction to the lab and displays the top voted articles.
- **Articles Page**: Users can search for articles, post new articles, vote on them, and view them.
- **News Article Page**: Displays the latest technology news relevant to the lab's interests.
- **Members Page**: Shows a list of all lab members with profile details.
- **Messages Page**: Facilitates real-time communication among members through a chat system.
- **Profile Page**: Allows users to view and update their personal information and manage their articles.
- **Admin Page**: Provides admin users with the ability to manage other users, assign admin roles, and edit articles.
- **Statistics Page**: Displays statistics about the articles each user has posted.

## Technologies

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: Laravel
- **Database**: MySQL

## Getting Started

### Prerequisites

- PHP >= 7.3
- Composer
- MySQL

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/Nezgova/scienceLab
   ```
2. Navigate to the project directory:
   ```
   cd lab_website
   ```
3. Install dependencies:
   ```
   composer install
   ```
4. Set up your environment file:
   ```
   cp .env.example .env
   ```
5. Generate the application key:
   ```
   php artisan key:generate
   ```
6. Create a MySQL database and add the credentials to the `.env` file.
7. Run the migrations:
   ```
   php artisan migrate
   ```
8. Start the server:
   ```
   php artisan serve
   ```
9. Visit `http://localhost` in your browser.

