<p align="center"><a href="https://fortnitestatstracker.xyz" target="_blank"><img src="https://fortnitestatstracker.xyz/favicons/android-chrome-256x256.png" width="256" alt="fortnitestatstracker.xyz_logo"></a></p>

# Fortnite Stats Tracker

Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!

---

## Pre Setup

Follow these steps to get started before you download this repository.

1. You need to install [Composer](https://getcomposer.org/)
2. You need to install [Laravel with Composer](https://laravel.com/docs/8.x#installation-via-composer)
3. Mysql server (Can be used with [XAMPP](https://www.apachefriends.org/index.html))
4. You need to install [Node.js version 16.x](https://nodejs.org/en/) or higher
5. You need to install **NPM** (Node Package Manager) witch comes with Node.js

---

## Branches

Branches are for version control. This makes it possible to work on multiple issues/tickets at the same time. Make sure that you never work on the `main` branch.

1. Change your branch corresponding to your issue/ticket. Example: `git checkout v1/frontend` to switch to the branch `v1/frontend`. If the branch already exist, go to next section.
2. If the branch does not exist yet, create a new branch by typing `git checkout -b branch_name`. Example: `git checkout -b v1/frontend`. And push the branch to the remote repository. Example: `git push origin v1/frontend`
3. If you created a new branch, you must go back to step 1 afterwards.

**Always try to keep the branch up to date with the latest changes.**

---

## Setup

### Cloning the Repository
1. Navigate to your Programming folder and open your terminal/command prompt
2. Clone this repository by typing:
```bash
git clone https://github.com/DevShaded/fortnitestatstracker.xyz.git
```

### Installing Dependencies
1. Navigate to the root directory of the repository and open your terminal/command prompt
2. Install dependencies by typing: 
```bash 
composer install
``` 
and then type
```bash
npm install
```

### Environment Setup
1. We need to copy the .env.example file to .env that you create, and change the values to your own.
2. For the `FORTNITE_API_KEY` variable go to [Fortnite-API.com](https://fortnite-api.com/) and get the API key form there.
3. For the `FORTNITE_IO_KEY` variable go to [FortniteApi.io](https://fortniteapi.io/) and get the API key form there.
4. Set up the database information in the `.env` file, and create a new database with `utf8mb4_unicode_ci` as a collation.
5. Run `php artisan key:generate` to generate a new session key for the application.
6. Then for the last step we need to run `php artisan migrate` to create the database tables.

### **Do not ever upload the `.env` file as it contains private credentials.**

### Running the Application (PRODUCTION)
1. Now we need to run the build command that is located in the `package.json` file
```bash
npm run build
```
2. Then we need to start the `ssr.js` server!
   1. Method 1:
      1. We can start the `ssr.js` server with just doing
      ```bash
      node /storage/ssr/ssr.js
      ```
   2. Method 2:
      1. we can also use [PM2](https://www.pm2.io/) to start the `ssr.js` server with this command
      ```bash
      pm2 start /storage/ssr/ssr.js --watch
      ```

### Running the Application (LOCAL)
We need to run the dev command that is located in the `package.json` file
```bash
npm run dev
```

Now you should be all set with the application!
---

### Any issues? Open a new [issue](https://github.com/DevShaded/fortnitestatstracker.xyz/issues)!
