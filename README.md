MCQ Grader — Automated MCQ Grading & Assessment System

A full-stack web application built with Laravel 11 that enables teachers to create exams, upload student answer sheets (CSV/Excel), automatically grade them, and generate detailed PDF reports.


Features


Create and manage MCQ exams with a custom answer key
Upload student answer sheets as CSV or Excel files
Automatic grading with per-question feedback
Pass/fail determination based on configurable pass mark
Detailed grading reports with score, percentage, and question breakdown
PDF export for every grading report
Clean, responsive UI built with Tailwind CSS



Tech Stack


Backend: Laravel 11, PHP 8.2+
Database: MySQL
File Processing: Maatwebsite Excel
PDF Generation: Laravel DomPDF
Frontend: Blade + Tailwind CSS (CDN)
Deployment: Render



Local Setup

Requirements


PHP 8.2+
Composer
MySQL
XAMPP or any local server


Steps

bash# 1. Clone the repository
git clone https://github.com/your-username/mcq-grader.git
cd mcq-grader

# 2. Install dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcq_grader
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Start the server
php artisan serve

Visit http://localhost:8000 to access the app.


CSV Format

Answer sheets must be uploaded as .csv or .xlsx files with this exact format:

question_number,selected_option
1,A
2,C
3,B
4,D
5,A


question_number — must match the question numbers in the exam
selected_option — must be one of: A, B, C, D
Missing answers are recorded as unanswered and marked incorrect



Deployment on Render

1. Push to GitHub

bashgit init
git add .
git commit -m "Initial commit"
git remote add origin https://github.com/your-username/mcq-grader.git
git push -u origin main

2. Create a Render account

Go to https://render.com and sign up.

3. Create a new Web Service


Click New → Web Service
Connect your GitHub repository
Set the following:


FieldValueEnvironmentPHPBuild Commandcomposer install --no-dev && php artisan migrate --forceStart Commandphp artisan serve --host=0.0.0.0 --port=10000

4. Add environment variables on Render

Go to Environment tab and add:

APP_NAME=MCQ Grader
APP_ENV=production
APP_KEY=           ← generate with: php artisan key:generate --show
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

DB_CONNECTION=mysql
DB_HOST=           ← your Render MySQL host
DB_PORT=3306
DB_DATABASE=mcq_grader
DB_USERNAME=       ← your Render MySQL user
DB_PASSWORD=       ← your Render MySQL password

FILESYSTEM_DISK=local

5. Create a MySQL database on Render


Click New → PostgreSQL or use a free MySQL provider like PlanetScale or Railway
Copy the connection details into your environment variables above


6. Deploy

Click Deploy — Render will build and launch your app automatically.


Project Structure

app/
├── Enums/AnswerOption.php
├── Http/
│   ├── Controllers/
│   │   ├── ExamController.php
│   │   ├── AnswerSheetController.php
│   │   └── ReportController.php
│   └── Requests/
│       ├── StoreExamRequest.php
│       └── UploadAnswerSheetRequest.php
├── Imports/AnswerSheetImport.php
├── Models/
│   ├── Exam.php
│   ├── Question.php
│   ├── AnswerSheet.php
│   ├── Answer.php
│   └── GradingReport.php
└── Services/GradingService.php

database/migrations/
├── 2024_01_01_000001_create_exams_table.php
├── 2024_01_01_000002_create_questions_table.php
├── 2024_01_01_000003_create_answer_sheets_table.php
├── 2024_01_01_000004_create_answers_table.php
└── 2024_01_01_000005_create_grading_reports_table.php

resources/views/
├── exams/
├── answer-sheets/
├── reports/
└── pdf/


License

MIT License. Free to use and modify.